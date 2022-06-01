<?php
namespace App\Http\Controllers;
use App\Http\Requests\G2FverifyRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUser;
use App\Http\Requests\ResetPasswordSaveRequest;
use App\Jobs\SendVerifyEmail;
use App\Model\Category;
use App\Model\Coin;
use App\Model\Service;
use App\Model\Slider;
use App\Model\TopSeller;
use App\Model\UserSocialMedia;
use App\Model\UserVerificationCode;
use App\Model\Wallet;
use App\Http\Services\MailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PragmaRX\Google2FA\Google2FA;

/**
 * Class AuthController
 */
class AuthController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login()
    {
        $t1 = time();
        if (file_exists(storage_path('installed'))) {
            if (Auth::user()) {
                if (Auth::user()->role == USER_ROLE_ADMIN) {
                    return redirect()->route('admin_dashboard');
                } elseif (Auth::user()->role == USER_ROLE_USER) {
                    return redirect()->route('dashboard');
                } else {
                    Auth::logout();
                    return view('auth.landing', ['title' => __('Home')]);
                }
            }
            $slider = Slider::first();
            $categories_services =   Category::orderBy('title', 'ASC')->with('services', 'services.author')->paginate(8);
            $latest_max_date = Service::max('created_at');
            $latest_services = Service::orderBy('id', 'DESC')->with('author')->where('status', APPROVED)->where('created_at', $latest_max_date)->paginate(8);
            $slide_images = Service::orderBy('id', 'DESC')->with('author')->where('status', APPROVED)->paginate(8);
            $max_date = TopSeller::max('activate_date');
            $first_day = Carbon::parse($max_date)->startOfMonth();
            $last_day = Carbon::parse($max_date)->lastOfMonth();
            $first_year = Carbon::parse($max_date)->startOfYear();
            $last_year = Carbon::parse($max_date)->lastOfYear();
            $top_sellers_today = TopSeller::where('activate_date', $max_date)->with('seller')->paginate(8);
            $top_sellers_month = TopSeller::whereBetween('activate_date', [$first_day, $last_day])->with('seller')->paginate(8);
            $top_sellers_year = TopSeller::whereBetween('activate_date', [$first_year, $last_year])->with('seller')->paginate(8);
            return view('user.landing', [
                'title' => __('Home'),
                'categories_services' => $categories_services,
                'latest_services' => $latest_services,
                'top_sellers_today' => $top_sellers_today,
                'top_sellers_month' => $top_sellers_month,
                'top_sellers_year' => $top_sellers_year,
                'slider' => $slider,
                'slide_images' => $slide_images,
            ]);
        }
        else {
            return redirect()->to('/install');
        }

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function signUp()
    {
        return view('auth.signup');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forgotPassword()
    {
        return view('auth.forgot_password');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetPasswordPage()
    {
        return view('user.pages.reset-password', ['title' => __('Reset Password')]);
    }

    /**
     * @param RegisterUser $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function signUpProcess(RegisterUser $request)
    {
        DB::beginTransaction();
        $parentUserId = 0;
        try {
            if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                return ['status' => false, 'message' => __('Invalid email address')];
            }
        } catch (\Exception $e) {
            return ['status' => false, 'message' => __('Failed to signup! Try Again.' . errorHandle($e->getMessage()))];
        }
        try {
            $mail_key = $this->generate_email_verification_key();
            $user = User::create([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'role' => USER_ROLE_USER,
                'password' => Hash::make($request['password']),
            ]);
            UserVerificationCode::create(['user_id' => $user->id, 'code' => $mail_key, 'expired_at' => date('Y-m-d', strtotime('+15 days'))]);
            UserSocialMedia::create(['user_id'=> $user->id,]);
            $coins = Coin::where(['status' => STATUS_ACTIVE])->get();
            foreach ($coins as $coin){
                Wallet::create([
                    'user_id' => $user->id,
                    'coin_id' => $coin->id,
                    'address' => '',
                    'is_primary' => STATUS_SUCCESS,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => __('Failed to signup! Try Again.' . errorHandle($e->getMessage()))];
        }
        if (!empty($user)){
            $this->sendVerifyemail($user, $mail_key);
            return response()->json(['success' => true, 'message' => __('Email send successful,please verify your email'), 'data' => ['redirect' => true, 'type' => 'success','returnRoute' => route('login')]]);
        } else {
            return ['status' => false, 'message' => __('Something went wrong')];
        }
    }

    /**
     * @return string
     */
    private function generate_email_verification_key()
    {
        $key = randomNumber(6);
        return $key;
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function loginProcess(LoginRequest $request)
    {

        $data['success'] = false;
        $data['message'] = '';
        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            if(empty($user->is_verified)) {
                $user->is_verified =  0;
            }
            if(($user->role == USER_ROLE_USER) || ($user->role == USER_ROLE_ADMIN)) {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    if ($user->status == STATUS_SUCCESS) {
                        if (!empty($user->is_verified)) {
                            $data['success'] = true;
                            $data['message'] = __('Login successful');
                            if (Auth::user()->role == USER_ROLE_ADMIN) {
                                return response()->json(['success' => true, 'message' => __('Admin successfully login'), 'data' => ['redirect' => true, 'type' => 'success','returnRoute' => route('admin_dashboard')]]);
                            } else {
                                createUserActivity(Auth::user()->id, USER_ACTIVITY_LOGIN);
                                return response()->json(['success' => true, 'message' => $data['message'], 'data' => ['redirect' => true, 'type' => 'success','returnRoute' => route('dashboard')]]);
                            }
                        } else {
                            $existsToken = User::join('user_verification_codes','user_verification_codes.user_id','users.id')
                                ->where('user_verification_codes.user_id',$user->id)
                                ->whereDate('user_verification_codes.expired_at' ,'>=', Carbon::now()->format('Y-m-d'))
                                ->first();
                            if(!empty($existsToken)) {
                                $mail_key = $existsToken->code;
                            } else {
                                $mail_key = randomNumber(6);
                                UserVerificationCode::create(['user_id' => $user->id, 'code' => $mail_key, 'status' => STATUS_PENDING, 'expired_at' => date('Y-m-d', strtotime('+15 days'))]);
                            }
                            try {
                                $this->sendVerifyemail($user, $mail_key);
                                $data['success'] = false;
                                $data['message'] = __('Your email is not verified yet. Please verify your mail.');
                                Auth::logout();
                                return response()->json(['status' => $data['success'], 'message' => $data['message']]);
                            } catch (\Exception $e) {
                                $data['success'] = false;
                                $data['message'] = errorHandle($e->getMessage());
                                Auth::logout();
                                return response()->json(['status' => $data['success'], 'message' => $data['message']]);
                            }
                        }
                    } elseif ($user->status == STATUS_SUSPENDED) {
                        $data['success'] = false;
                        $data['message'] = __("Your account has been suspended. please contact support team to active again");
                        Auth::logout();
                        return response()->json(['status' => $data['success'], 'message' => $data['message']]);
                    } elseif ($user->status == STATUS_DELETED) {
                        $data['success'] = false;
                        $data['message'] = __("Your account has been deleted. please contact support team to active again");
                        Auth::logout();
                        return response()->json(['status' => $data['success'], 'message' => $data['message']]);
                    } elseif ($user->status == STATUS_PENDING) {
                        $data['success'] = false;
                        $data['message'] = __("Your account has been pending for admin approval. please contact support team to active again");
                        Auth::logout();
                        return response()->json(['status' => $data['success'], 'message' => $data['message']]);
                    }
                } else {
                    $data['success'] = false;
                    $data['message'] = __("Email or Password doesn't match");
                    return response()->json(['status' => $data['success'], 'message' => $data['message']]);
                }
            } else {
                $data['success'] = false;
                $data['message'] = __("You have no login access");
                Auth::logout();
                return response()->json(['status' => $data['success'], 'message' => $data['message']]);
            }
        } else {
            $data['success'] = false;
            $data['message'] = __("You have no account,please register new account");
            return response()->json(['status' => $data['success'], 'message' => $data['message']]);
        }
    }

    /**
     * @param $user
     * @param $mail_key
     */
    public function sendVerifyemail($user, $mail_key)
    {
        $data['userName'] = $user->first_name.' '.$user->last_name;
        $data['userEmail'] = $user->email;
        $data['companyName'] = isset(allsetting()['app_title']) && !empty(allsetting()['app_title']) ? allsetting()['app_title'] : __('Company Name');
        $data['subject'] = __('Email Verification | :companyName', ['companyName' => $data['companyName']]);
        $data['data'] = $user;
        $data['key'] = $mail_key;
        $data['template'] = 'email.verifyWeb';
        dispatch(new SendVerifyEmail($data))->onQueue('email-send');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendForgotMail(Request $request)
    {

        $rules = ['email' => 'required|email'];
        $messages = ['email.required' => __('Email field can not be empty'), 'email.email' => __('Email is invalid')];
        $validatedData = $request->validate($rules,$messages);
        $user = User::where(['email' => $request->email])->first();
        if ($user) {
            DB::beginTransaction();
            try {
                $key = randomNumber(6);
                $existsToken = User::join('user_verification_codes','user_verification_codes.user_id','users.id')
                    ->where('user_verification_codes.user_id',$user->id)
                    ->whereDate('user_verification_codes.expired_at' ,'>=', Carbon::now()->format('Y-m-d'))
                    ->first();
                if(!empty($existsToken)) {
                    $token = $existsToken->code;
                } else {
                    UserVerificationCode::create(['user_id' => $user->id, 'code'=>$key,'expired_at' => date('Y-m-d', strtotime('+15 days')), 'status' => STATUS_PENDING]);
                    $token = $key;
                }
                $user_data = [
                    'user' => $user,
                    'token' => $token,
                ];
                $mailService = new MailService();
                $userName = $user->first_name.' '.$user->last_name;
                $userEmail = $user->email;
                $companyName = isset(allsetting()['app_title']) && !empty(allsetting()['app_title']) ? allsetting()['app_title'] : __('Company Name');
                $subject = __('Forgot Password | :companyName', ['companyName' => $companyName]);
                $mailService->send('email.password_reset', $user_data, $userEmail, $userName, $subject);
                $data['message'] = 'Mail sent successfully to ' . $user->email . ' with password reset code.';
                $data['success'] = true;
                Session::put(['resend_email'=>$user->email]);
                DB::commit();
                return redirect(route('resetPasswordPage'))->with('success',$data['message']);
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('dismiss', __('Something went wrong. Please check mail credential.'));
            }
        } else {
            return redirect()->back()->with('dismiss',__('Email not found'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logOut()
    {
        Session::forget('g2f_checked');
        Session::flush();
        Auth::logout();
        return redirect()->route('logOut')->with('success', __('Logout successful'));
    }

    /**
     * @param ResetPasswordSaveRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPasswordSave(ResetPasswordSaveRequest $request)
    {
        try {
            $vf_code = UserVerificationCode::where(['code' => $request->token, 'status' => STATUS_PENDING])->first();

            if (!empty($vf_code)) {
                $user = User::where(['id'=> $vf_code->user_id, 'email'=>$request->email])->first();
                if (empty($user)) {
                    return redirect()->back()->withInput()->with('dismiss', __('User not found'));
                }
                $data_ins['password'] = hash::make($request->password);
                $data_ins['is_verified'] = STATUS_SUCCESS;
                if(!Hash::check($request->password,User::find($vf_code->user_id)->password)) {

                    User::where(['id' => $vf_code->user_id])->update($data_ins);
                    UserVerificationCode::where(['id' => $vf_code->id])->delete();

                    $data['success'] = 'success';
                    $data['message'] = __('Password Reset Successfully');
                } else {
                    $data['success'] = 'dismiss';
                    $data['message'] = __('You already used this password');
                    return redirect()->back()->with($data['success'],$data['message']);
                }
            } else {
                $data['success'] = 'dismiss';
                $data['message'] = __('Invalid code');
                return redirect()->back()->with('dismiss', __('Invalid code'));
            }
            return redirect()->back()->with($data['success'],$data['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function g2fChecked(Request $request)
    {
        return view('auth.g2f');
    }

    /**
     * @param G2FverifyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     * @throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
     */
    public function g2fVerify(G2fverifyRequest $request){

        $google2fa = new Google2FA();
        $google2fa->setAllowInsecureCallToGoogleApis(true);
        $valid = $google2fa->verifyKey(Auth::user()->google2fa_secret, $request->code, 8);

        if ($valid){
            Session::put('g2f_checked',true);
            return redirect()->route('dashboard')->with('success',__('Login successful'));
        }
        return redirect()->back()->with('dismiss',__('Code doesn\'t match'));

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function verifyEmailPost(Request $request)
    {
        $user = User::where(['email' => $request->email])->first();

        if (!empty($user)) {
            $varify = UserVerificationCode::where(['user_id' => $user->id])
                ->where('code', decrypt($request->token))
                ->where('status', STATUS_PENDING)
                ->whereDate('expired_at', '>', Carbon::now()->format('Y-m-d'))
                ->first();

            if ($varify) {

                $check = $user->update(['is_verified' => STATUS_SUCCESS]);
                try {
                    if ($check) {
                        UserVerificationCode::where(['user_id' => $user->id])->delete();
                        return redirect()->route('login')->with('success',__('Verify successful,you can login now'));
                    }
                } catch (\Exception $e) {
                    dd($e);
                }
            } else {
                Auth::logout();
                return redirect()->route('login')->with('dismiss',__('Your verify token was expired,you can generate new token'));
            }
        }
    }

    /**
     * @param $request
     * @return array
     */
    public function changePassword($request)
    {
        $data = ['success' => false, 'message' => __('Something went wrong')];
        try {
            $user = Auth::user();
            if (!Hash::check($request->password, $user->password)) {

                $data['message'] = __('Old password doesn\'t match');
                return $data;
            }
            if (Hash::check($request->new_password, $user->password)) {
                $data['message'] = __('You already used this password');
                return $data;
            }

            $user->password = Hash::make($request->new_password);
            $user->save();
            return ['success' => true, 'message' => __('Password change successfully')];
        } catch (\Exception $exception)
        {
            return ['success' => false, 'message' => __('Something went wrong')];
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sellerProfile($id)
    {
        $id = decrypt($id);
        $seller = User::whereId($id)->with('service_sells')->first();
        $categories = Category::orderBy('title', 'ASC')->paginate(8);
        $services = Service::where('created_by', $id)->paginate(8);
        return view('user.pages.seller-profile', ['title' => __('Seller Profile'), 'seller' => $seller, 'categories' => $categories, 'services' => $services]);
    }

    public function manualInstalled()
    {
        $installedLogFile = storage_path('installed');

        $dateStamp = date('Y/m/d h:i:sa');

        if (! file_exists($installedLogFile)) {
            $message = trans('ZaiInstaller successfully INSTALLED on ').$dateStamp."\n";

            file_put_contents($installedLogFile, $message);
        }
        return redirect('/');
    }
}

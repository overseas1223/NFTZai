<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\AuthController;
use App\Http\Requests\AdminCreateUser;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UserProfileUpdate;
use App\Jobs\CommonEmailSendJob;
use App\Model\Coin;
use App\Model\TopSeller;
use App\Model\UserVerificationCode;
use App\Model\Wallet;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class UserController
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminUsers(Request $request)
    {
        $data['title'] = __('Users');
        if ( $request->ajax() ) {
            $users = [];
            if ($request->type == 'active_users') {
            }
            $users = User::where('status', STATUS_SUCCESS)->where('id', '<>', Auth::user()->id);
            if ($request->type == 'suspend_user')
                $users = User::where('status', STATUS_SUSPENDED)->where('id', '<>', Auth::user()->id);
            if ($request->type == 'deleted_user')
                $users = User::where('status', STATUS_DELETED)->where('id', '<>', Auth::user()->id);
            if ($request->type == 'email_pending')
                $users = User::where('is_verified', '!=', STATUS_SUCCESS)->where('id', '<>', Auth::user()->id);
            return datatables($users)
                ->addColumn('status', function ($item) {
                    return statusAction($item->status);
                })
                ->addColumn('type', function ($item) {
                    return userRole($item->role);
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? with(new Carbon($item->created_at))->format('d M Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d %M %Y') like ?", ["%$keyword%"]);
                })
                ->addColumn('activity', function ($item) use ($request) {
                    return getActionHtml($request->type, $item->id, $item);
                })
                ->rawColumns(['activity'])
                ->make(true);
        }
            return view('admin.users.users', $data);
    }

    /**
     * @param AdminCreateUser $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function UserAddEdit(AdminCreateUser $request)
    {
        DB::beginTransaction();
        try {
            if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->withInput()->with('dismiss', __('Invalid email address'));
            }
            $mail_key = randomNumber(6)();
            $user = User::create([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'role' => $request->role,
                'phone' => $request->phone,
                'status' => STATUS_SUCCESS,
                'password' => Hash::make(randomString(8)),
            ]);
            $coins = Coin::where(['active_status' => STATUS_ACTIVE])->get();
            foreach ($coins as $coin){
                Wallet::create([
                    'user_id' => $user->id,
                    'coin_id' => $coin->id,
                    'address' => '',
                    'is_primary' => STATUS_SUCCESS,
                ]);
            }
            $key = randomNumber(6);
            $existsToken = User::join('user_verification_codes', 'user_verification_codes.user_id', 'users.id')
                ->where('user_verification_codes.user_id', $user->id)
                ->whereDate('user_verification_codes.expired_at', '>=', Carbon::now()->format('Y-m-d'))
                ->first();

            if ( !empty($existsToken) ) {
                $token = $existsToken->code;
            } else {
                $s = UserVerificationCode::create(['user_id' => $user->id, 'code' => $key, 'expired_at' => date('Y-m-d', strtotime('+15 days')), 'status' => STATUS_PENDING]);
                $token = $key;
            }
            $user_data = [
                'email' => $user->email,
                'token' => $token,
            ];
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        if ( !empty($user) ) {
            $email_data = [
                'user' => $user,
                'key' => $mail_key
            ];
            $subject = __('Email Verification | :companyName', ['companyName' => env('APP_NAME')]);;
            dispatch(new CommonEmailSendJob($email_data, 'email.email_verify', $subject, $user))->onQueue('common-email-send');
            return redirect()->route('admin_users')->with('success', __('Email send successful,please verify your email'));
        } else {
            return redirect()->route('admin_users')->with('dismiss', __('Something went wrong'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminUserProfile(Request $request)
    {
        $data['title'] = __('User Profile');
        $data['user'] = User::find(decrypt($request->id));
        $data['type'] = $request->type;
        return view('admin.users.profile',$data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function UserEdit(Request $request)
    {
        $data['title'] = __('User Edit');
        $data['user'] = User::find(decrypt($request->id));
        $data['type'] = $request->type;
        return view('admin.users.edit',$data);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminUserDelete($id)
    {
        $user = User::find(decrypt($id));
        $user->status = STATUS_DELETED;
        $user->save();
        return redirect()->back()->with('success','User deleted successfully');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminUserSuspend($id){
        $user = User::find(decrypt($id));
        $user->status = STATUS_SUSPENDED;
        $user->save();
        return redirect()->back()->with('success','User suspended successfully');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminUserRemoveGauth($id){
        $user = User::find(decrypt($id));
        $user->google2fa_secret = '';
        $user->g2f_enabled  = '0';
        $user->save();
        return redirect()->back()->with('success','User gauth removed successfully');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminUserActive($id){
        $user = User::find(decrypt($id));
        $user->status = STATUS_SUCCESS;
        $user->save();
        return redirect()->back()->with('success','User activated successfully');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminUserEmailVerified($id){
        $user = User::find(decrypt($id));
        $user->is_verified = STATUS_SUCCESS;
        $user->save();
        return redirect()->back()->with('success','Email verified successfully');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminProfile(Request $request)
    {
        $data['title'] = __('Profile');
        $data['tab']='profile';
        $data['user']= User::where('id', Auth::id())->first();
        $data['settings'] = allsetting();

        return view('admin.users.admin_profile',$data);
    }

    /**
     * @param UserProfileUpdate $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function UserProfileUpdate(UserProfileUpdate $request)
    {
        if($request->top_seller == 1) {
            TopSeller::create([
                'user_id' => decrypt($request->id),
                'activate_date' => date("Y-m-d"),
            ]);
        }
        else {
            TopSeller::where('user_id', decrypt($request->id))->first()->delete();
        }
        if (strpos($request->phone, '+') !== false) {
            return redirect()->back()->with('dismiss',__("Don't put plus sign with phone number"));
        }
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $user = (!empty($request->id)) ? User::find(decrypt($request->id)) : Auth::user();
        if ($user->phone != $request->phone){
            $data['phone'] =  $request->phone;
            $data['phone_verified'] = 0;
        }
        $user->update($data);
        return redirect()->back()->with('success',__('Profile updated successfully'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadProfileImage(Request $request)
    {
        $rules['file_one'] = 'required|image|max:2024|mimes:jpg,jpeg,png,jpg,gif,svg|max:2048|dimensions:max_width=500,max_height=500';
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $message = $validator->getMessageBag()->getMessages()['file_one'][0];
            if ($message == 'The file one has invalid image dimensions.')
                $message =  __('Image size must be less than (height:500,width:500)');
            return redirect()->back()->with('dismiss',$message);
        }
        try {
            $img = $request->file('file_one');
            $user_data = (!empty($request->id) ) ? User::find(decrypt($request->id)) : Auth::user();
            if ($img !== null) {
                $photo = uploadFile($img, IMG_USER_PATH, !empty($user_data->photo) ? $user_data->photo : '');
                $user = User::find($user_data->id);
                $user->photo  = $photo;
                $user->save();
                return redirect()->back()->with('success',__('Profile picture uploaded successfully'));
            } else {
                return redirect()->back()->with('dismiss',__('Please input a image'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('dismiss', errorHandle($e->getMessage()));
        }
    }

    /**
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePasswordSave(resetPasswordRequest $request)
    {
        $service = new AuthController();
        $change = $service->changePassword($request);
        if ($change['success']) {
            return redirect()->back()->with('success',$change['message']);
        } else {
            return redirect()->back()->with('dismiss',$change['message']);
        }
    }
}

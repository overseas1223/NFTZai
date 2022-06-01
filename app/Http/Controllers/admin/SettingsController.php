<?php
namespace App\Http\Controllers\admin;
use App\Http\Services\SettingService;
use App\Model\Setting;
use App\Model\Faq;
use App\Model\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

/**
 * Class SettingsController
 */
class SettingsController extends Controller
{
    public function __construct()
    {
        $this->settingRepo = new SettingService();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminSettings(Request $request)
    {
        if (isset($request->itech) && ($request->itech == 99)) {
            $data['itech'] = 'itech';
        }
        $data['tab']='general';
        if(isset($_GET['tab'])){
            $data['tab']=$_GET['tab'];
        }
        $data['title'] = __('General Settings');
        $data['settings'] = allsetting();
        return view('admin.settings.general', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function adminCommonSettings(Request $request)
    {
        $rules=[];
        if(!empty($request->logo)){
            $rules['logo']='image|mimes:jpg,jpeg,png|max:2000';
        }
        if(!empty($request->favicon)){
            $rules['favicon']='image|mimes:jpg,jpeg,png|max:2000';
        }
        if(!empty($request->login_logo)){
            $rules['login_logo']='image|mimes:jpg,jpeg,png|max:2000';
        }
        if(!empty($request->coin_price)){
            $rules['coin_price']='numeric';
        }
        if(!empty($request->number_of_confirmation)){
            $rules['number_of_confirmation']='integer';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $data['message'] = $errors;
            return redirect()->route('admin_settings', ['tab' => 'general'])->with(['dismiss' => $errors[0]]);
        }
        try {
            if ($request->post()) {
                $response = $this->settingRepo->saveCommonSetting($request);
                if ($response['success'] == true) {
                    return redirect()->route('admin_settings', ['tab' => 'general'])->with('success', $response['message']);
                } else {
                    return redirect()->route('admin_settings', ['tab' => 'general'])->withInput()->with('success', $response['message']);
                }
            }
        } catch(\Exception $e) {
            return redirect()->back()->with(['dismiss' => errorHandle($e->getMessage())]);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function adminSaveEmailSettings(Request $request)
    {
        if ($request->post()) {
            $rules = [
                'mail_host' => 'required'
                ,'mail_port' => 'required'
                ,'mail_username' => 'required'
                ,'mail_password' => 'required'
                ,'mail_encryption' => 'required'
                ,'mail_from_address' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = [];
                $e = $validator->errors()->all();
                foreach ($e as $error) {
                    $errors[] = $error;
                }
                $data['message'] = $errors;
                return redirect()->route('admin_settings', ['tab' => 'email'])->with(['dismiss' => $errors[0]]);
            }
            try {
                $response = $this->settingRepo->saveEmailSetting($request);
                if ($response['success'] == true) {
                    return redirect()->route('admin_settings', ['tab' => 'email'])->with('success', $response['message']);
                } else {
                    return redirect()->route('admin_settings', ['tab' => 'email'])->withInput()->with('success', $response['message']);
                }
            } catch(\Exception $e) {
                return redirect()->back()->with(['dismiss' => $e->getMessage()]);
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function adminSavePaymentSettings(Request $request)
    {
        if ($request->post()) {
            $rules = [
                'COIN_PAYMENT_PUBLIC_KEY' => 'required',
                'COIN_PAYMENT_PRIVATE_KEY' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = [];
                $e = $validator->errors()->all();
                foreach ($e as $error) {
                    $errors[] = $error;
                }
                $data['message'] = $errors;
                return redirect()->route('admin_settings', ['tab' => 'payment'])->with(['dismiss' => $errors[0]]);
            }
            try {
                $response = $this->settingRepo->savePaymentSetting($request);
                if ($response['success'] == true) {
                    return redirect()->route('admin_settings', ['tab' => 'payment'])->with('success', $response['message']);
                } else {
                    return redirect()->route('admin_settings', ['tab' => 'payment'])->withInput()->with('success', $response['message']);
                }
            } catch(\Exception $e) {
                return redirect()->back()->with(['dismiss' => $e->getMessage()]);
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminPaymentSetting()
    {
        $data['title'] = __('Payment Method');
        $data['settings'] = allsetting();
        $data['payment_methods'] = paymentMethods();

        return view('admin.settings.payment-method', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePaymentMethodStatus(Request $request)
    {
        $settings = allsetting();
        if (!empty($request->active_id)) {
            $value = 1;
            $item = isset($settings[$request->active_id]) ? $settings[$request->active_id] : 2;
            if ($item == 1) {
                $value = 2;
            } elseif ($item == 2) {
                $value = 1;
            }
            Setting::updateOrCreate(['slug' => $request->active_id], ['value' => $value]);
        }
        return response()->json(['message'=>__('Status changed successfully')]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function slider()
    {
        $slider = Slider::first();
        return view('admin.slider.slider', ['slider' => $slider]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sliderUpdate(Request $request)
    {
        $slider = Slider::whereId($request->slider_id)->first();
        $action = Slider::whereId($slider->id)->update([
            'short_description' => is_null($request->short_description) ? $slider->short_description : $request->short_description,
            'long_desc_header' => is_null($request->long_desc_header) ? $slider->long_desc_header : $request->long_desc_header,
            'long_desc_middle' => is_null($request->long_desc_middle) ? $slider->long_desc_middle : $request->long_desc_middle,
            'long_desc_footer' => is_null($request->long_desc_footer) ? $slider->long_desc_footer : $request->long_desc_footer,
        ]);
        if(!empty($action)) {
            return redirect()->back()->with('success', __('Slider update successfully!'));
        }
        return redirect()->back()->with('dismiss', __('Something were wrong!'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contents()
    {
        $data['title'] = __('Content Settings');
        $data['settings'] = allsetting();
        return view('admin.settings.contents', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contentsUpdate(Request $request)
    {
        $response = $this->settingRepo->saveCommonSetting($request);
        if ($response['success'] == true) {
            return redirect()->back()->with('success', $response['message']);
        } else {
            return redirect()->back()->withInput()->with('success', $response['message']);
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function counters()
    {
        $data['title'] = __('Counter Settings');
        $data['settings'] = allsetting();
        return view('admin.settings.counters', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function countersUpdate(Request $request)
    {
        $response = $this->settingRepo->saveCommonSetting($request);
        if ($response['success'] == true) {
            return redirect()->back()->with('success', $response['message']);
        } else {
            return redirect()->back()->withInput()->with('success', $response['message']);
        }
    }
}

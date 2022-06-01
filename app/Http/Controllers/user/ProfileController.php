<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\AuthController;
use App\Http\Requests\resetPasswordRequest;
use App\Http\Requests\UserProfileUpdate;
use App\Model\ActivityLog;
use App\Model\TopSeller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    //my profile
    public function userProfile(Request $request)
    {
        $data['title'] = __('My Profile');
        $data['user'] = User::where('id', Auth::id())->first();
        $data['qr'] = (!empty($request->qr)) ? $request->qr : 'profile-tab';

        if($request->ajax()){
            $data['activities'] = ActivityLog::where('user_id', Auth::id())->select('*');

            return datatables()->of($data['activities'])
                ->addColumn('action',function ($item) {return userActivity($item->action);})
                ->make(true);
        }
        return view('user.profile.profile', $data);
    }


    // profile upload image
    public function uploadProfileImage(Request $request)
    {
        $rules['file_one'] = 'required|image|max:3048|mimes:jpg,jpeg,png,jpg,gif,svg|max:2048|dimensions:max_width=500,max_height=500';
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


    // update user profile
    public function userProfileUpdate(UserProfileUpdate $request)
    {
        if (strpos($request->phone, '+') !== false) {
            return redirect()->back()->with('dismiss',__("Don't put plus sign with phone number"));
        }
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['country'] = $request->country;
        $user = (!empty($request->id)) ? User::find(decrypt($request->id)) : Auth::user();

        if ($user->phone != $request->phone){
            $data['phone'] =  $request->phone;
            $data['phone_verified'] = 0;
        }
        $user->update($data);

        return redirect()->back()->with('success',__('Profile updated successfully'));
    }

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

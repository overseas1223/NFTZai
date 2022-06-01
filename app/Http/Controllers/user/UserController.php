<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Model\Follow;
use App\Model\LikeView;
use App\Model\Service;
use App\Model\UserSocialMedia;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function userProfile()
    {
        return view('user.pages.user-profile', ['title' => __('User Profile')]);
    }

    public function editProfile()
    {
        return view('user.pages.edit-profile', ['title' => __('Edit Profile')]);
    }

    public function updateProfile(UserUpdateRequest $request)
    {
        DB::beginTransaction();
        if (!empty($request->thumbnail)) {
            $thumb = uploadimage($request['thumbnail'], IMG_USER_VIEW_PATH);
        }
        else {
            $thumb = Auth::user()->photo;
        }
        $email_notification_status = checkBoxValue($request->email_notification_status);
        $new_bid_notification = checkBoxValue($request->new_bid_notification);
        $item_purchased_notification = checkBoxValue($request->item_purchased_notification);
        $people_follow_notification = checkBoxValue($request->people_follow_notification);
        try {
            $action = User::whereId(Auth::id())->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'bio' => $request->bio,
                'country_code' => $request->country_code,
                'website' => $request->website,
                'phone' => $request->phone,
                'country' => $request->country,
                'gender' => $request->gender,
                'photo' => $thumb,
                'birth_date' => is_null($request->birth_date) ? Auth::user()->birth_date : $request->birth_date,
                'email_notification_status' => $email_notification_status,
                'new_bid_notification' => $new_bid_notification,
                'item_purchased_notification' => $item_purchased_notification,
                'people_follow_notification' => $people_follow_notification,
            ]);
            UserSocialMedia::where('user_id', Auth::id())->update([
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
            ]);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollback();
            $data['success'] = false;
            $data['message'] = errorHandle($e->getMessage());

            return response()->json(['status' => $data['success'], 'message' => $data['message']]);
        }

        if(!empty($action)) {
            return ['status' => true, 'message' => __('User updated!')];
        }
        else {
            return ['status' => false, 'message' => __('User updated failed')];
        }
    }

    public function myCollections()
    {
        $on_sales = Service::where('created_by', Auth::id())->with('category')->where('status', APPROVED)->get() ;

        return view('user.pages.my-collections', ['title' => __('My Collections'), 'on_sales' => $on_sales]);
    }

    public function onSalesData(Request $request)
    {
        $collections = Service::where('created_by', Auth::id())->with('category')->where('status', APPROVED)->paginate(6) ;
        if($request->ajax()) {
            return view('user.components.services-card', ['collections' => $collections]);
        }
    }

    public function myCollectionData(Request $request)
    {
        $collections = Service::where('created_by', Auth::id())->with('category')->paginate(6) ;
        if ($request->ajax()) {
            return view('user.components.services-card', ['collections' => $collections]);
        }
    }

    public function myCreatedData(Request $request)
    {
        $collections = Service::where('created_by', Auth::id())->where('status', DRAFT)->with('category')->paginate(6) ;
        if ($request->ajax()) {
            return view('user.components.services-card', ['collections' => $collections]);
        }
    }

    public function myLikeData(Request $request)
    {
        $collections = LikeView::where('user_id', Auth::id())->where('isLike', 1)->with('service')->paginate(6) ;
        if($request->ajax()) {
            return view('user.components.like-services-card', ['collections' => $collections]);
        }
    }

    public function updateCoverPhoto(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->filename)) {
                $thumb = uploadimage($request['filename'], IMG_USER_COVER_PHOTO);
            }
            User::whereId(Auth::id())->update([
                'cover_photo' => $thumb,
            ]);

            $html = '';
        }
    }

    public function followSeller($id)
    {
        $id = decrypt($id);
        $follower_id = Auth::id();
        $following_id = $id;
        if(Follow::where('follower_id', $follower_id)->where('following_id', $following_id)->exists()) {
            return redirect()->back()->with('dismiss', __('Already you follow this user!'));
        }
        $action = Follow::create([
            'follower_id' => $follower_id,
            'following_id' => $following_id,
        ]);
        if(!empty($action)) {
            return redirect()->back()->with('success', __('Your are following the user!'));
        }
        return redirect()->back()->with('dismiss', __('Something went wrong!'));
    }

    public function unfollowSeller($id)
    {
        $id = decrypt($id);
        $follower_id = Auth::id();
        $following_id = $id;
        if(Follow::where('follower_id', $follower_id)->where('following_id', $following_id)->exists()) {
            $action = Follow::where('follower_id', $follower_id)->where('following_id', $following_id)->first()->delete();
            if(!empty($action)) {
                return redirect()->back()->with('success', __('Unfollow user!'));
            }
        }
        return redirect()->back()->with('dismiss', __('Something went wrong!'));
    }

    public function followingData(Request $request)
    {
        $collections = Follow::where('follower_id', Auth::id())->with('following_user')->paginate(6);
        if ($request->ajax()) {
            return view('user.components.follow-card', ['collections' => $collections]);
        }
    }

    public function followerData(Request $request)
    {
        $collections = Follow::where('following_id', Auth::id())->with('follower')->paginate(6);
        if ($request->ajax()) {
            return view('user.components.follower-card', ['collections' => $collections]);
        }
    }
}

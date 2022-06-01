<?php
namespace App\Http\Services;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

    // update user profile
    public function profileUpdate($request, $user_id)
    {
        $response['status'] = false;
        $response['user'] = (object)[];
        $response['message'] = __('Invalid Request');
        $user = User::find($user_id);
        $userData = [];
        try {
            if ($user) {
                $userData = [
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'phone' => $request['phone'],
                ];
                if (!empty($request['country'])) {
                    $userData['country'] = $request['country'];
                }
                if (!empty($request['type'])) {
                    $userData['type'] = $request['type'];
                }
                if (!empty($request['photo'])) {
                    $old_img = '';
                    if (!empty($user->photo)) {
                        $old_img = $user->photo;
                    }
                    $userData['photo'] = uploadFile($request['photo'], IMG_USER_PATH, $old_img);
                }

                $affected_row = User::where('id', $user_id)->update($userData);
                if ($affected_row) {
                    $response['status'] = true;
                    $response['user'] = $this->userProfile($user_id)['user'];
                    $response['message'] = __('Profile updated successfully');
                }

            } else {
                $response['status'] = false;
                $response['user'] = (object)[];
                $response['message'] = __('Invalid User');
            }
        } catch (\Exception $e) {
            $response = [
                'status' => false,
                'user' => (object)[],
                'message' => $e->getMessage()
            ];
            return $response;
        }

        return $response;
    }

    public function passwordChange($request, $user_id)
    {
        $response['status'] = false;
        $response['message'] = __('Invalid Request');
        $user = User::find($user_id);

        if ($user) {
            $old_password = $request['old_password'];
            if (Hash::check($old_password, $user->password)) {
                $user->password = bcrypt($request['password']);
                $user->save();

                $affected_row = $user->save();

                if (!empty($affected_row)) {
                    $response['status'] = true;
                    $response['message'] = __('Password changed successfully.');
                }
            } else {
                $response['status'] = false;
                $response['message'] = __('Incorrect old password');
            }
        } else {
            $response['status'] = false;
            $response['message'] = __('Invalid user');
        }

        return $response;
    }

    // user profile
    public function userProfile($user_id)
    {
        if (isset($user_id)) {
            $user = User::findOrFail($user_id);

            $data['user'] = $user;
            $data['user']->photo = imageSrcUser($user->photo,IMG_USER_VIEW_PATH);
            $data['success'] = true;
            $data['message'] = __('Successfull');
        } else {
            $data= [
                'success' => false,
                'user' => (object)[],
                'message' => __('User not found'),
            ];
        }

        return $data;
    }

}

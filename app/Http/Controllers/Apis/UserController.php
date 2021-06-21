<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getProfile()
    {
        $user = Auth::user();
        $result =new UserResource($user);
        $msg = "";
        return $this->getJsonSuccessResponse($msg,$result);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->all();
        $user = Auth::user();
        if(crypt($data['current_password'], $user->password) != $user->password)
        {
            $msg = "Current Password Is Incorrect";
            return $this->getJsonNotFoundErrorResponse($msg);
        }
        $data['password'] = bcrypt($data['password']);
        User::where("id",$user->id)->update([
            "password" => $data['password']
        ]);
        $msg = "Password Changed Successfully";
        return $this->postJsonSuccessResponse($msg);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $updated_user = User::where("id",$user->id)->update($data);
        $msg = "Profile Updated Successfully";
        $get_user = User::find($user->id);
        $result =new UserResource($get_user);
        return $this->postJsonSuccessResponse($msg,$result);


    }


}

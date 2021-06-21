<?php

namespace App\Http\Controllers\Apis;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginUser;
use App\Http\Requests\RegisterUser;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use HasApiTokens;

    public function register(RegisterUser $request)
    {
        $data = $request->all();

        $data['password'] = Hash::make($data['password']);
        $user =  User::create($data);

        $user->token = $user->createToken('auth_token')->plainTextToken;
        $msg = "User Registered Successfully";
        return $this->postJsonSuccessResponse($msg,$user);
    }

    public function login(LoginUser $request)
    {
        $data = $request->all();
        $user = Auth::attempt($request->only("email","password"));
        if(!$user)
        {
            $msg = "Invalid Email Or Password";
          return  $this->getJsonNotFoundErrorResponse($msg);
        }
        $user = User::where("email",$data['email'])->first();

        if(is_object($user) && $user->is_active == false)
        {
            $msg = "Please Check Your Email For Activation";
           return $this->getJsonNotFoundErrorResponse($msg);
        }
        $user->token = $user->createToken('auth_token')->plainTextToken;
        $result = new UserResource($user);
        $msg = "Logged in Successfully";
        return $this->postJsonSuccessResponse($msg,$result);

    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $data = $request->all();
        $user = User::where("email",$data['email'])->first();

        if(! is_object($user))
        {
            $msg = "This User Is Not Exist";
            return  $this->getJsonNotFoundErrorResponse($msg);
        }
       // $arr["email"] = $user->email;
       // $user->notify(new ResetPassword($user,$arr));
        $msg = "Please Check Your Mail To Reset Your Password";
        return $this->postJsonSuccessResponse($msg);


    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        $msg = "Logged out Successfully";
        return $this->postJsonSuccessResponse($msg);

    }



}

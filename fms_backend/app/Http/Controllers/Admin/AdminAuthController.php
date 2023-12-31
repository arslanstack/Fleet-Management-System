<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Hash, Session, Validator, DB, DateTime, DateInterval;

class AdminAuthController extends Controller
{

    public function __construct()
    {
        // $this->middleware('guest:api')->except('logout');
    }

    public function login(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data,
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );
        if ($validator->fails()) {
            $finalResult = response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
            return $finalResult;
        }

        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(array('msg'=> 'error', 'response' => 'Incorrect email or password.'));
            }
        } catch (JWTException $e) {
            return response()->json(array('msg'=> 'error', 'response' => 'Something went wrong. Please try again.'));
        }
        $user = Auth::user();
        $permissions = PermissionsOfUser($user->role_type);
        return response()->json(array('msg' => 'success', 'response'=>'Logged in successfully', 'permissions' => $permissions, 'access_token'=> $token, 'token_type'=>'bearer', 'data' => $user, 'expires_in' => auth()->factory()->getTTL() * 7200));
    }

    public function logout(Request $request) {
        Session::flush();
        Auth::logout();
        return response()->json(array('msg' => 'success', 'response'=>'Logged out successfully.'));
    }


    public function profile() {
        $user = Auth::user();
        return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $user));
    }


    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'access_token' => Auth::refresh(),
                'token_type' => 'bearer',
            ]
        ]);
    }

}

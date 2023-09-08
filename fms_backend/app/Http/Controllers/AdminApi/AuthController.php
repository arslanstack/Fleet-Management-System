<?php
namespace App\Http\Controllers\AdminApi;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Auth, Session;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required||email',
            'password' => 'required|',
        ]);
        // $credentials = $request->only('email', 'password');
        // $token = Auth::guard('admin')->attempt($credentials);




        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::guard('admin')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }




        // if (!$token) {
        //     return response()->json(array('msg' => 'error', 'response'=>'Incorrect email or password.'));
        // }
        // $user = Auth::guard('admin')->user();
        // return response()->json(array('msg' => 'success', 'response'=>'Logged in successfully', 'token'=> $token, 'type'=>'bearer', 'user' => $user));

    public function logout(Request $request) {
        Session::flush();
        Auth::logout();
        return response()->json(array('msg' => 'success', 'response'=>'Logged out successfully.'));
    }

    // public function refresh()
    // {
    //     return response()->json([
    //         'user' => Auth::user(),
    //         'authorisation' => [
    //             'token' => Auth::refresh(),
    //             'type' => 'bearer',
    //         ]
    //     ]);
    // }
}
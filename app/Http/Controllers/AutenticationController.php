<?php


namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AutenticationController extends Controller
{
    public function __construct()
    {

    }

    public function AuthenticateToken(Request $request)
    {
        $user = Users::where('username', $request->input('username'))->first();
        if (!$user) {
            return response()->json(['status' => 'ERR', 'message' => 'Username does not exist'],400);
        }
        if (Hash::check($request->input('password'), $user->password)) {
            $credentials = $request->only(['username', 'password']);
            if (!$token = Auth::attempt($credentials)) {
                return response()->json(['status' => 'ERR',
                    'message' => 'Unauthorized access. Token is invalid or expired'], 401);
            }
            $getToken = $this->replyWithToken($token);
            $user->api_token = $token;
            $user->save();
            return $getToken;
        } else {
            return response()->json(['status' => 'ERR', 'message' => 'Password does not match'],400);
        }
    }

}

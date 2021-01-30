<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class AutenticationController extends Controller
{
    public function __construct()
    {

    }

    public function generateToken($id) {
        $key = env('APP_KEY');
        $payload = [
            'iss' => 'lumen-jwt',
            'sub' => $id,
            'iat' => time(),
            'exp' => time() + (60 * 60),
        ];
        return JWT::encode($payload, $key);
    }

    public function Authenticate(Request $request) {
        $user = User::where('username', $request->input('username'))->first();
        if (!user) {
            return response()->json([
                'error' => 'Username doesnot exist'
            ], 400);
        }

        if(Hash::check($request->input('password'), $user->password)) {
            $token = $this->generateToken($user->id);
            $user->api_token = $token;
            $user->save();

            return response()->json([
                'token' => $token
            ], 200);
        } else {
            return reponse()->json([
                'error' => 'Password doesnot match'
            ], 400);
        }
    }
}

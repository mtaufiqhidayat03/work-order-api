<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{

    protected function replyWithToken($token)
    {
        return response()->json([
            'token_type' => 'Bearer',
            'token' => $token,
            'expires_in_minutes' => Auth::factory()->getTTL() * 60
        ], 200);
    }

    protected function toTimestamp($date)
    {
        return Carbon::parse($date)->timestamp;
    }
}

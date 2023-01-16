<?php

namespace App\Http\Controllers;

use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class UserAuthenticateController extends LoginController
{
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        /** @var User $user */
        $user = $this->guard()->user();
        return response()
            ->json([
                'phone' => $user->phone,
                'token' => $user->createToken('redemption')->plainTextToken
            ])->setStatusCode(ResponseCode::HTTP_OK);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return response()
        ->json([
            'messages' => [trans('auth.failed')]
        ])->setStatusCode(ResponseCode::HTTP_UNAUTHORIZED);
    }
}

<?php

namespace App\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\Auth\RegisterController;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class UserRegisterController extends RegisterController
{
    public function register(Request $request): Response|JsonResponse
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        return response()->json([
            'message' => __('success'),
            'result' => [
                'phone' => $user->phone,
            ],
            'ts' => Carbon::now('UTC')->timestamp,
        ])->setStatusCode(ResponseCode::HTTP_OK);
    }
}

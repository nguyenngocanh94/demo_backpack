<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\Timezone;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function updateTz(Request $request): Response|JsonResponse
    {
        $tz = $request->get('timezone');
        if (!Timezone::verify($tz)) {
            return response()->json([
                'message'=>__('fail'),
                'result' => [
                    'message' => 'wrong timezone',
                ],
            ])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        User::whereUuid($request->user()->getUuid())->update(['timezone' => $tz]);
        $user = User::whereUuid($request->user()->getUuid())->first();
        return response()->json([
            'message' => __('success'),
            'result' => [
                'phone' => $user->phone,
                'timezone' => $user->timezone,
            ],
            'ts' => Carbon::now('UTC')->timestamp,
        ])->setStatusCode(Response::HTTP_OK);
    }
}

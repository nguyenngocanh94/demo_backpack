<?php

namespace App\Http\Controllers\Redemption;

use App\Http\Controllers\Controller;
use App\Services\LuckyDrawInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class LuckyDrawController extends Controller
{
    public function __construct(private readonly LuckyDrawInterface $luckyDrawService)
    {
    }

    public function drawing(Request $request): JsonResponse
    {
        $user = $request->user();
        $point = $this->luckyDrawService->gainPoint($user);

        return response()->json([
            'message' => __('success'),
            'result' => [
                'point' => $point->point,
                'time' => $point->time,
            ],
            'ts' => Carbon::now('UTC')->timestamp,
        ])->setStatusCode(ResponseCode::HTTP_OK);
    }
}

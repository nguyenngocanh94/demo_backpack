<?php

namespace App\Http\Controllers\Redemption;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\RedemptionInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class RedemptionController extends Controller
{
    public function __construct(private readonly RedemptionInterface $redemption, private readonly Request $request)
    {
    }

    public function redeem(string $couponUuid): JsonResponse
    {
        $user = $this->request->user();
        $coupon = Coupon::whereUuid($couponUuid)->first();
        $redemption = $this->redemption->redeemCoupon($user, $coupon);

        return response()->json([
            'message' => 'success',
            'result' => [
                'qrcode' => $redemption->qrcode
            ],
            'ts' => Carbon::now('UTC')->timestamp
        ])->setStatusCode(ResponseCode::HTTP_OK);
    }
}

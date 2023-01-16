<?php

namespace App\Services\Implements;

use App\Exceptions\Definition\InvalidPointBalanceException;
use App\Models\Coupon;
use App\Models\Redemption;
use App\Models\User;
use App\Services\RedemptionInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\UuidInterface;
use Str;
use Throwable;

final class RedemptionService implements RedemptionInterface
{
    /**
     * @throws Throwable
     * @throws InvalidPointBalanceException
     */
    public function redeemCoupon(User $user, Coupon $coupon): Redemption
    {
        try {
            DB::beginTransaction();

            if (false === $this->canAfford($user, $coupon)){
                throw new InvalidPointBalanceException('user do not have enough point or got exceed coupon quota');
            }
            $redemptionUuid = Str::uuid();
            /** @var Redemption $redemption */
            $redemption = $user->redemptions()->create([
                'uuid' => $redemptionUuid->toString(),
                'user_uuid' => $user->uuid,
                'coupon_uuid' => $coupon->uuid,
                'point' => $coupon->point,
                'qrcode' => hash('md5', sprintf('%s_%s_%s', $redemptionUuid->toString(), $user->uuid, $coupon->uuid))
            ]);
            $user->decrement('point', $coupon->point);
            $coupon->decrement('quota');
            DB::commit();

            return $redemption;
        }catch (Throwable $exception){
            Log::error(sprintf('exception when redeem coupon: %s', $exception->getMessage()));
            DB::rollBack();

            throw $exception;
        }
    }

    public function canAfford(User $user, Coupon $coupon): bool
    {
        return $user->point >= $coupon->point && $coupon->quota >= 1;
    }
}

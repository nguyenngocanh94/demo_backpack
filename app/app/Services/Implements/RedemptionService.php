<?php

namespace App\Services\Implements;

use App\Exceptions\Definition\InvalidPointBalanceException;
use App\Models\Coupon;
use App\Models\Redemption;
use App\Models\User;
use App\Services\RedemptionInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

            if (false === $this->canAfford($user, $coupon)) {
                throw new InvalidPointBalanceException('user do not have enough point or got exceed coupon quota');
            }
            $redemptionUuid = Str::uuid();
            $redemption = Redemption::createFromFields($redemptionUuid, $user->getUuid(), $coupon->getUuid(), $coupon->point);
            $user->decrement('point', $coupon->point);
            $coupon->decrement('quota');
            DB::commit();

            return $redemption;
        } catch (Throwable $exception) {
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

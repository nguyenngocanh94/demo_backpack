<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Redemption;
use App\Models\User;
use Ramsey\Uuid\UuidInterface;

interface RedemptionInterface
{
    public function redeemCoupon(User $user, Coupon $coupon): Redemption;
}

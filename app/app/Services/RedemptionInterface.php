<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Redemption;
use App\Models\User;

interface RedemptionInterface
{
    public function redeemCoupon(User $user, Coupon $coupon): Redemption;
}

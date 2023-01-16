<?php

declare(strict_types=1);


namespace Tests\Unit;

use App\Exceptions\Definition\InvalidPointBalanceException;
use App\Models\Coupon;
use App\Models\User;
use App\Services\Implements\RedemptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedemptionTest extends TestCase
{
    use RefreshDatabase;

    private function provide(){
        return [
            [
                100,1,90,false
            ],
            [
                100,10,120,true
            ]
        ];
    }

    /**
     * @dataProvider provide
     * @return void
     * @throws \Throwable
     */
    public function testRedeemCoupon($userPoint, $quota, $couponPoint, $preAssert){
        list($user, $coupon) = $this->prepareScenario($userPoint, $quota, $couponPoint);
        $redemptionSv = new RedemptionService();
        if ($preAssert){
            $this->expectException(InvalidPointBalanceException::class);
        }
        $redemption = $redemptionSv->redeemCoupon($user, $coupon);
        $this->assertTrue($user->point === $userPoint - $couponPoint);
        $this->assertTrue($coupon->quota === $quota - 1);
        $this->assertTrue($coupon->quota === $quota - 1);
        $this->assertTrue($redemption->qrcode === sprintf('%s_%s_%s', $redemption->getUuid(), $redemption->user_uuid, $redemption->coupon_uuid));
    }

    private function prepareScenario($userPoint, $quota, $couponPoint): array
    {
        $user = User::create([
            'point' => $userPoint,
            'name' => 'test',
            'password' => 'random',
            'phone' => '192'
        ]);

        $coupon = Coupon::create([
            'quota' => $quota,
            'point' => $couponPoint,
            'name' => 'test',
            'description' => 'test'
        ]);

        return [$user, $coupon];
    }
}

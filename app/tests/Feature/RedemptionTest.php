<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class RedemptionTest extends TestCase
{
    use RefreshDatabase;
    private string $token;
    private Coupon $coupon;
    protected function setUp(): void
    {
        parent::setUp();
        // create user
        $response = $this->postJson('api/register', [
            'name' => 'test',
            'phone' => '088',
            'password'=> '123456',
            'password_confirmation' => '123456',
        ]);

        $response->assertStatus(200);

        $loginResponse = $this->postJson('api/auth', [
            'phone' => '088',
            'password' => '123456',
        ]);
        $loginResponse->assertStatus(Response::HTTP_OK);
        $this->token = 'Bearer '.$loginResponse['token'];

        // adjust point
        User::wherePhone('088')->update(['point' => 100]);

        // create coupon
        $this->coupon = Coupon::create([
            'name' => 'test',
            'description' => 'test',
            'quota' => 1,
            'point' => 100,
        ]);
    }

    public function testNormalRedeem()
    {
        $response = $this->postJson(sprintf('api/coupon/%s/redeem', $this->coupon->getUuid()->toString()), [], [
            'Authorization' => $this->token,
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertTrue(isset($response['result']['qrcode']));
        $this->assertTrue($response['message'] === __('success'));

        $currentUser = User::wherePhone('088')->first();
        $currentCoupon = Coupon::whereUuid($this->coupon->getUuid())->first();
        $this->assertTrue($currentUser->point === 0);
        $this->assertTrue($currentCoupon->quota === 0);
    }

    public function testRedeemOverQuota()
    {
        $this->testNormalRedeem();
        $response = $this->postJson(sprintf('api/coupon/%s/redeem', $this->coupon->getUuid()->toString()), [], [
            'Authorization' => $this->token,
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testRedeemOverBalance()
    {
        $this->adjustBalance(50);
        $response = $this->postJson(sprintf('api/coupon/%s/redeem', $this->coupon->getUuid()->toString()), [], [
            'Authorization' => $this->token,
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    private function adjustBalance(int $point)
    {
        User::wherePhone('088')->update(['point' => $point]);
    }
}

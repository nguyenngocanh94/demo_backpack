<?php

declare(strict_types=1);


namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LuckyDrawingTest extends TestCase
{

    use RefreshDatabase;
    private string $token;
    protected function setUp(): void
    {
        parent::setUp();
        $response = $this->postJson('api/register', [
            'name' => 'test',
            'phone' => '088',
            'password'=> '123456',
            'password_confirmation' => '123456'
        ]);

        $response->assertStatus(200);

        $loginResponse = $this->postJson('api/auth', [
            'phone' => '088',
            'password' => '123456'
        ]);
        $loginResponse->assertStatus(Response::HTTP_OK);
        $this->token = 'Bearer '.$loginResponse['token'];
    }

    public function testNormalLuckyDrawing(){
        $response = $this->postJson('api/lucky-drawing', [], [
            'Authorization' => $this->token
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertTrue(is_numeric($response['result']['point']));
        $this->assertTrue(Carbon::createFromTimestamp($response['result']['time'])->day === Carbon::now('UTC')->day);
    }

    public function testTwiceLuckyDrawingInDay(){
        $response = $this->postJson('api/lucky-drawing', [], [
            'Authorization' => $this->token
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertTrue(is_numeric($response['result']['point']));
        $this->assertTrue(Carbon::createFromTimestamp($response['result']['time'])->day === Carbon::now('UTC')->day);

        // try again.
        $secondTry = $this->postJson('api/lucky-drawing', [], [
            'Authorization' => $this->token
        ]);
        $secondTry->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}

<?php

declare(strict_types=1);


namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserTest extends TestCase
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

    public function testUpdateTz(){
        $response = $this->patchJson('api/user/timezone', ['timezone' => 'Asia/Saigon'], [
            'Authorization' => $this->token
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertTrue($response['result']['timezone'] === 'Asia/Saigon');
    }


    public function testUpdateWrongTz(){
        $response = $this->patchJson('api/user/timezone', ['timezone' => 'cambodia'], [
            'Authorization' => $this->token
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}

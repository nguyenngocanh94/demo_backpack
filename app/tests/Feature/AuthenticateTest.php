<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUnAuthorization()
    {
        $response = $this->postJson('api/lucky-drawing');

        $response->assertStatus(401);
    }

    public function testRegister()
    {
        $response = $this->postJson('api/register', [
            'name' => 'test',
            'phone' => '088',
            'password'=> '123456',
            'password_confirmation' => '123456'
        ]);

        $response->assertStatus(200);
        $this->assertTrue($response['result']['phone'] === '088');
    }

    public function testRegisterDuplicate()
    {
        $response = $this->postJson('api/register', [
            'name' => 'test',
            'phone' => '088',
            'password'=> '123456',
            'password_confirmation' => '123456'
        ]);

        $response->assertStatus(200);
        $this->assertTrue(json_decode($response->content(), true)['result']['phone'] === '088');

        $response = $this->postJson('api/register', [
            'name' => 'test',
            'phone' => '088',
            'password'=> '123456',
            'password_confirmation' => '123456'
        ]);
        $response->assertStatus(400);
    }

    public function testIssueToken(){
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
        $this->assertTrue($loginResponse['token'] !== '');
    }
}

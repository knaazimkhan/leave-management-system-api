<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = new User([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin'
        ]);

        $user->save();
    }

    public function testListUser()
    {
        $response = $this->post('api/login', [
            'email' => 'admin@admin.com',
            'password' => 'admin'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);

        $responseJSON = json_decode($response->getContent(), true);
        $token = $responseJSON['access_token'];

        // $this->get('api/admin/users?token=' . $token, [], [])->assertJson([
        //     'users'
        // ])
        // ->assertStatus(200)
        // ->isOk();
    }

    public function testLeaveApprove()
    {
        $response = $this->post('api/login', [
            'email' => 'admin@admin.com',
            'password' => 'admin'
        ]);

        $response->assertStatus(200);

        $responseJSON = json_decode($response->getContent(), true);
        $token = $responseJSON['access_token'];

        $response = $this->post('api/admin/approve', [
            'id'       => 3,
            'token'     => $token
        ]);

        
        // $response->assertJson([
        //     'success',
        //     'user'
        // ]);
        $response->assertStatus(401);
    }

    public function testLeaveReject()
    {
        $response = $this->post('api/login', [
            'email' => 'admin@admin.com',
            'password' => 'admin'
        ]);

        $response->assertStatus(200);

        $responseJSON = json_decode($response->getContent(), true);
        $token = $responseJSON['access_token'];

        $response = $this->post('api/admin/reject', [
            'id'       => 3,
            'token'     => $token
        ]);

        
        // $response->assertJson([
        //     'success',
        //     'user'
        // ]);
        $response->assertStatus(401);
    }
}

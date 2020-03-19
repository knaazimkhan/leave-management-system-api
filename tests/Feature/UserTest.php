<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = new User([
            'name' => 'Test',
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $user->save();
    }

    public function testUser()
    {
        $response = $this->post('api/login', [
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $response->assertStatus(200);

        $responseJSON = json_decode($response->getContent(), true);
        $token = $responseJSON['access_token'];

        $this->post('api/user?token=' . $token, [], [])->assertJsonStructure([
            'user'
        ])
        ->assertStatus(200)
        ->isOk();
    }

    public function testLeave()
    {
        $response = $this->post('api/login', [
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $response->assertStatus(200);

        $responseJSON = json_decode($response->getContent(), true);
        $token = $responseJSON['access_token'];

        $response = $this->post('api/user/leave', [
            'leave_type'       => 'CL',
            'start_date '       => '19-03-2020',
            'end_date'       => '26-03-2020',
            'description' => 'This is a description',
            'token'     => $token
        ]);

        
        // $response->assertJsonStructure([
        //     'success',
        //     'user'
        // ]);
        $response->assertStatus(200);
    }
}

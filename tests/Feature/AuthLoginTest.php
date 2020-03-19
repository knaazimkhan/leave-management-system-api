<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = new User([
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => '123456'
        ]);

        $user->save();
    }

    public function testLoginSuccessfully()
    {
        $this->post('api/login', [
            'email' => 'test@test.com',
            'password' => '123456'
        ])->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ])->isOk();
    }

    public function testLoginWithReturnsWrongCredentialsError()
    {
        $this->post('api/login', [
            'email' => 'unknown@email.com',
            'password' => '123456'
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(401);
    }

    public function testLoginWithReturnsValidationError()
    {
        $this->post('api/login', [
            'email' => 'test@email.com'
        ])->assertStatus(200);
    }
}

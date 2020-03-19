<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterSuccessfully()
    {
        $this->post('api/register', [
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => '123456'
        ])->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ])->assertStatus(200);
    }

    public function testRegisterReturnsValidationError()
    {
        $this->post('api/register', [
            'name' => 'Test User',
            'email' => 'test@email.com'
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(200);
    }
}

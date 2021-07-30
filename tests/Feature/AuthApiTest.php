<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthApiTest extends TestCase
{
    /**
     * Check login with invalid credentials.
     * @test
     * @return void
     */
    public function try_login_with_invalid_credentials()
    {
        $credentials = [
            'email' => 'lablablaa@somthing.com',
            'password' => 'lablablaa',
            'remember' => false,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];
        $response = $this->post('/api/auth/login', $credentials, $headers);

        $response->assertStatus(401);
    }

    /**
     * Check login with valid credentials.
     * @test
     * @return void
     */
    public function login_with_valid_credentials()
    {
        $credentials = [
            'email' => 'eshtiaghi.amin@gmail.com',
            'password' => 'pleasechangeme',
            'remember' => false,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];
        $response = $this->post('/api/auth/login', $credentials, $headers);

        $response->assertOk();

        $loginResponseStructure = [
            'token',
            'expires_at',
            'name',
        ];
        $response->assertJsonStructure($loginResponseStructure);
    }

    /**
     * Check logout with valid token.
     * @test
     * @return void
     */
    public function logout_with_valid_token()
    {
        $credentials = [
            'email' => 'eshtiaghi.amin@gmail.com',
            'password' => 'pleasechangeme',
            'remember' => false,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];
        $response = $this->post('/api/auth/login', $credentials, $headers);

        $token = $response->json('token');

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ];
        $response = $this->post('/api/auth/logout', [], $headers);
        $response->assertOk();
    }

    /**
     * Check Logout action for unknown users.
     * @test
     * @return void
     */
    public function prevent_logout_for_unknown_users()
    {
        $headers = [
            'Accept' => 'application/json'
        ];
        $response = $this->post('/api/auth/logout', [], $headers);

        $response->assertStatus(401);
    }
}

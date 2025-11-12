<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExternalTest extends TestCase
{
    /**
     * Test login request.
     *
     * @return void
     */
    public function test_login_api_externa()
    {
        $url = 'https://ioc.ferter.es/api/users/login';
        $requestBody = ['email' => 'user@user.com', 'password' => 'user123'];
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $response = $this->post($url, $requestBody, $headers);

        $response->assertStatus(200);

        $data = json_decode($response->getContent(), true);
        print_r($data);
    }
}
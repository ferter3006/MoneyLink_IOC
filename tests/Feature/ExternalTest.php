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
        $requestBody = ["email" => "user@user.com", "password" => "user123"];
        $client = new \GuzzleHttp\Client();

        $response = $client->post($url, [
            'json' => $requestBody,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        
    }
}
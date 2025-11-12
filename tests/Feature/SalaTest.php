<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SalaTest extends TestCase
{
    /**
     * Funcion para comprobar que la ruta salas es privada
     */
    public function test_salas_route_is_private(): void
    {
        $response = $this->get('/api/salas/me');        

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}

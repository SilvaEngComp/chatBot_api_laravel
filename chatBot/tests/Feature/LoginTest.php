<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_route_login_reject()
    {
        // Rota do Login
        $response = $this->post('/api/v2/auth/login');


        $response->assertStatus(400);
    }

    public function test_route_login_accept()
    {
        $data = [ 'email' => 'admin@ufba.br','password' => 'admin1' ];
        // Rota do Login
        $response = $this->post('/api/v2/auth/login', $data);


        $response->assertStatus(200);
        $json = $response->json();

    }
}

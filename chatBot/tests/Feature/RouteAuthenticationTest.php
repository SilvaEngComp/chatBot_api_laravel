<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class RouterAuthenticationTest extends TestCase
{
    private $data;
    private $token;
    private $headers;


    public function init()
    {
        $this->data = [
            'email' => 'admin@ufba.br',
            'password' => 'admin1',
        ];

        $response = $this->post('/api/v1/auth/login', $this->data);
        $responseJson = $response->json();
        $this->token = $responseJson['data']['token'];
        $this->headers = [
            'accept' => 'application/json',
            'authentication' => 'Bearer ' . $this->token,
        ];
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function tes_update_user_password()
    {
        //Arrange
        // $this->init();
        //Act
        $response = $this->patch('/api/v1/auth/updatePassword/user/1/password/suport@enginysystem@1');
        $responseJson = $response->json();
        //Assert
        // dd($response);

        $response->assertStatus(200);
        $this->assertArrayHasKey('message', $responseJson);
        $this->assertEquals('Senha  atualizado(a) com sucesso', $responseJson['message']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_authentication_acess_with_login_method()
    {
        //Arrange
        $this->data = [
            'email' => 'admin@ufba.br',
            'password' => 'admin1',
        ];
        //Act
        $response = $this->post('/api/v2/auth/login', $this->data);
        $responseJson = $response->json();
        //Assert
        // dd($responseJson);

        $response->assertStatus(200);
        $this->assertArrayHasKey('token', $responseJson['data']);
        $this->assertCount(3, $responseJson);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function tes_revoke_authentication_acess_with_logout_method()
    {
        //arrange
        $this->init();
        //Act
        $response = $this->withHeaders(
            $this->headers
        )
            ->post('/api/v2/auth/logout', []);
        $responseJson = $response->json();
        //Assert
        // dd($response);
        $response->assertStatus(200);
        $this->assertArrayHasKey('message', $responseJson);
        $this->assertCount(3, $responseJson);
        $this->assertEquals('Tokens Revoked Operação realizada com sucesso', $responseJson['message']);
    }
}

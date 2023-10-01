<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    private $user;
    private $token;
    private $headers;
    public function init()
    {
        $this->user = [
            'email' => 'admin@ufba.br',
            'password' => 'admin1',
        ];

        $response = $this->post('/api/v2/auth/login', $this->user);
        $responseJson = $response->json();
        $this->token = $responseJson['data']['token'];
        $this->headers = [
            'accept' => 'application/json',
            'authentication' => 'Bearer ' . $this->token,
        ];
    }

    private $json_structure_return = [
        [
            "id",
            "name",
            "email",
            "email_verified_at",
            "password",
            "created_at",
            "updated_at",

        ]
    ];

    private $userRequested = [
        "id" => 1,
        "email" => "admin@ufba.br",
    ];


    public function test_get_all_users()
    {
        $this->init();
        $response = $this->get('/api/v3/users');
        //assert
        $response->assertJsonStructure($this->json_structure_return);

    }

    public function test_store_user(){
        $this->init();


        $new_user = [

                "name" => "TestNome",
                "email" => "123@ufba.br",
                "password" => "12345",

            ];
        $response = $this->withHeaders($this->headers)->post('/api/v3/users', $new_user);
        $responseJson = $response->json();
        $response->assertStatus(201);

    }

    public function test_store_user_error(){
        $this->init();


        $new_user = [
            [
                "name" => "",
                "email" => "",
                "password" => "",
            ]
            ];
        $response = $this->withHeaders($this->headers)->post('/api/v3/users', $new_user);
        $response->assertStatus(400);

    }

    public function test_show_an_especific_user(){
        $this->init();
        $response = $this->get('/api/v3/users/' . $this->userRequested['id']);
        $responseJson = $response->json();
        $this->assertEquals($responseJson['email'], "admin@ufba.br");

    }




}

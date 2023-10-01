<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NlpTest extends TestCase
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


        $response = $this->post('/api/v2/auth/login', $this->data);
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
    public function tes_consult_anser_by_nlp()
    {

        //arg
        $this->init();
        $data = [
            "text" => "direção"
        ];
        //act
        $response = $this->withHeaders($this->headers)
            ->post('/api/v3/nlp', $data);

        $responseJson = $response->json();
        #print_r($responseJson);
        //assert
        $response->assertStatus(200);
    }
}

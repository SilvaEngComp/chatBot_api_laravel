<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopicTest extends TestCase
{
    private $user;
    private $token;
    private $headers;

    // data
    private $existent_topic = '27';
    private $non_existent_topic = '500';
    private $regular_topic = [
        "name" => "Regular Topic"
    ];

    // returns
    private $not_found_return = [
        "status" => "Error",
        "message" => "Topic not found",
        "data" => null
    ];
    private $parent_not_found_return = [
        "status" => "Error",
        "message" => "Parent not found",
        "data" => null
    ];
    private $json_structure_return = [
        [
            "id",
            "name",
            "questions" => [
                '*' => [
                    "id",
                    "topic_id",
                    "description",
                    "answer"
                ]
            ],
            "children" => [
                '*' => []
            ]
        ]
    ];
    private $success_on_creation_return = [
        "status" => "Success",
        "message" => "Topic registred",
        "data" => 201
    ];
    private $success_on_deletion_return = [
        "status" => "Success",
        "message" => "Topic deleted",
        "data" => 200
    ];

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

    // GET /api/v1/topics/
    public function test_v1_get_root_topics_returned()
    {
        //arg

        //act
        $response = $this->get('/api/v1/topics/');

        //assert
        $response->assertOk();
        $response->assertJsonStructure($this->json_structure_return);

        for ($i = 0; $i < count($response->json()); $i++){
            $response->assertJsonCount(0, $i.'.children');
        }
    }

    // GET /api/v1/topics/{topic}
    public function test_v1_topic_subtree_returned()
    {
        //arg

        //act
        $response = $this->get('/api/v1/topics/' . $this->existent_topic);

        //assert
        $response->assertOk();
        $response->assertJsonStructure($this->json_structure_return);
    }

    // GET /api/v1/topics/{topic}
    public function test_v1_topic_not_found()
    {
        //arg

        //act
        $response = $this->get('/api/v1/topics/' . $this->non_existent_topic);

        //assert
        $response->assertNotFound();
        $response->assertExactJson($this->not_found_return);
    }

    // GET /api/v3/topics/
    public function test_v3_full_topic_tree_returned()
    {
        //arg
        $this->init();

        //act
        $response = $this->withHeaders($this->headers)
        ->get('/api/v3/topics/');

        //assert
        $response->assertOk();
        $response->assertJsonStructure($this->json_structure_return);
    }

    // GET /api/v3/topics/{topic}
    public function test_v3_topic_subtree_returned()
    {
        //arg
        $this->init();

        //act
        $response = $this->withHeaders($this->headers)
            ->get('/api/v3/topics/' . $this->existent_topic);

        //assert
        $response->assertOk();
        $response->assertJsonStructure($this->json_structure_return);
    }

    // GET /api/v3/topics/{topic}
    public function test_v3_topic_not_found()
    {
        //arg
        $this->init();

        //act
        $response = $this->withHeaders($this->headers)
            ->get('/api/v3/topics/' . $this->non_existent_topic);

        //assert
        $response->assertNotFound();
        $response->assertExactJson($this->not_found_return);
    }

    // POST /api/v3/topics/
    public function test_v3_create_root_topic()
    {
        //arg
        $this->init();

        //act
        $response = $this->withHeaders($this->headers)
            ->post('/api/v3/topics/', $this->regular_topic);

        //assert
        $response->assertOk();
        $response->assertExactJson($this->success_on_creation_return);
    }

    // DELETE /api/v3/topics/{topic}
    public function test_v3_delete_root_topic()
    {
        //arg
        $this->init();

        $topic_id = 0;
        $root_topics = $this->withHeaders($this->headers)
            ->get('/api/v3/topics/');

        for ($i = (count($root_topics->json())-1); $i >= 0; $i--){
            if($root_topics[$i]["name"] == $this->regular_topic["name"]){
                $topic_id = $root_topics[$i]["id"];
                break;
            }
        }

        //act
        $response = $this->withHeaders($this->headers)
            ->delete('/api/v3/topics/'. $topic_id);

        //assert
        $response->assertOk();
        $response->assertExactJson($this->success_on_deletion_return);
    }

    // POST /api/v3/topics/{topic}
    public function test_v3_create_child_to_topic()
    {
        //arg
        $this->init();

        //act
        $response = $this->withHeaders($this->headers)
            ->post('/api/v3/topics/' . $this->existent_topic, $this->regular_topic);

        //assert
        $response->assertOk();
        $response->assertExactJson($this->success_on_creation_return);
    }

    // DELETE /api/v3/topics/{topic}
    public function test_v3_delete_child_topic()
    {
        //arg
        $this->init();

        $topic_id = 0;
        $root_topics = $this->withHeaders($this->headers)
            ->get('/api/v3/topics/' . $this->existent_topic);

        $rtj = $root_topics->json();
        $existent_topic_children = $rtj[0]["children"];
        for ($i = (count($existent_topic_children)-1); $i >= 0; $i--){
            if($existent_topic_children[$i]["name"] == $this->regular_topic["name"]){
                $topic_id = $existent_topic_children[$i]["id"];
                break;
            }
        }

        //act
        $response = $this->withHeaders($this->headers)
            ->delete('/api/v3/topics/'. $topic_id);

        //assert
        $response->assertOk();
        $response->assertExactJson($this->success_on_deletion_return);
    }

    // POST /api/v3/topics/{topic}
    public function test_v3_parent_topic_not_found()
    {
        //arg
        $this->init();

        //act
        $response = $this->withHeaders($this->headers)
            ->post('/api/v3/topics/' . $this->non_existent_topic, $this->regular_topic);

        //assert
        $response->assertNotFound();
        $response->assertExactJson($this->parent_not_found_return);
    }

    // DELETE /api/v3/topics/{topic}
    public function test_v3_try_to_delete_non_existent_topic()
    {
        //arg
        $this->init();

        //act
        $response = $this->withHeaders($this->headers)
            ->delete('/api/v3/topics/'. $this->non_existent_topic);

        //assert
        $response->assertNotFound();
        $response->assertExactJson($this->not_found_return);
    }
}

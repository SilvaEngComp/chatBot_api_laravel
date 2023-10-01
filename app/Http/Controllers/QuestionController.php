<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Traits\ApiResponser;
use App\Models\Question;
use Illuminate\Http\Request;
use Throwable;

class QuestionController extends Controller
{

    use ApiResponser;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions =  Question::get();

        return $questions->map(function ($question) {
            return $question->build();
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        if ($question) {
            return $question->build();
        }

        return $this->error('Question not founded', 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        try {
            $question = Question::create([
                "description" => $request["description"],
                "answer" => $request["answer"],
                "topic_id" => $request["topic_id"]
            ]);
            return $this->success('New question registred', $question, 201);
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        if ($question) {
            try {
                $question->description = $request->input('description');

                $question->answer = $request->input('answer');


                $question->update();
                return $this->success('Question updated.', $this->show($question));
            } catch (Throwable $e) {
                return $this->error('Erro: ' + $e, 500);
            }
        } else {
            return $this->error('Question not found.', 404);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        if ($question) {
            try {
                $question->delete();
                return $this->success('Question destroyed');
            } catch (Throwable $e) {
                return $this->error('Erro: ' + $e, 500);
            }
        } else
            return $this->error('Question not found.', 404);
    }
}


//CommitTestDaniel

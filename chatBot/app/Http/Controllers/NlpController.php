<?php

namespace App\Http\Controllers;

use App\Http\Requests\NlpRequest;
use App\Models\Question;
use App\Models\Topic;
use App\Traits\ApiResponser;

class NlpController extends Controller
{

    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Requests\NlpRequest
     */
    public function index(NlpRequest $request)
    {

        $entitiesName = $this->getEntities($request->input('text'));


        $answers = $this->getByAnswers($entitiesName);
        if (count($answers) > 0) {
            return $answers;
        }
        $questions = $this->getByAnswers($entitiesName, 'description');
        if (count($questions) > 0) {
            return $questions;
        }

        $topics = $this->getByTopics($entitiesName);
        if (count($topics) > 0) {
            return $topics;
        }

        return $this->error('Not found', 404);
    }



    private function getByAnswers($entitiesName, $type = 'answer'): array
    {
        $query  = null;
        $queryentitiesNameAux = $entitiesName;
        while (True) {
            if (count($entitiesName) > 0) {
                foreach ($entitiesName as $value) {
                    if (!isset($query)) {
                        $query = Question::whereRaw("LOWER($type) LIKE '%" . strtolower($value) . "%'");
                    }
                    $query =  $query->whereRaw("LOWER($type) LIKE '%" . strtolower($value) . "%'");
                }

                $response = $query->get();
                if (count($response->toArray()) > 0) {
                    return $response->toArray();
                }
                $query  = null;
                array_pop($entitiesName);
            } else {
                break;
            }
        }

        if (count($queryentitiesNameAux) > 0) {
            foreach ($entitiesName as $value) {
                $query =  Question::whereRaw("LOWER($type) LIKE '%" . strtolower($value) . "%'");
                if (count($query->toArray()) > 0) {
                    return $query->toArray();
                }
            }
        }

        return array();
    }

    private function getByTopics($entitiesName): array
    {
        $query  = null;
        $queryentitiesNameAux = $entitiesName;
        while (True) {
            if (count($entitiesName) > 0) {
                foreach ($entitiesName as $value) {
                    if (!isset($query)) {
                        $query = Topic::whereRaw("LOWER(name) LIKE '%" . strtolower($value) . "%'");
                    }
                    $query =  $query->whereRaw("LOWER(name) LIKE '%" . strtolower($value) . "%'");
                }

                $response = $query->get();
                if (count($response->toArray()) > 0) {
                    return $response->toArray();
                }
                $query  = null;
                array_pop($entitiesName);
            } else {
                break;
            }
        }

        if (count($queryentitiesNameAux) > 0) {
            foreach ($entitiesName as $value) {
                $query =  Question::whereRaw("LOWER(name) LIKE '%" . strtolower($value) . "%'");
                if (count($query->toArray()) > 0) {
                    return $query->toArray();
                }
            }
        }

        return array();
    }


    public function getEntities($text): array
    {
        $tokens = explode(' ', $text);
        $prepositions = [
            'por', 'a', 'para', 'de', 'em', 'o', 'pelo', 'ao', 'pro', 'do',
            'no', 'a', 'pela', 'à', 'pra', 'da', 'na', 'os', 'pelos', 'aos', 'pros',
            'dos', 'nos', 'as', 'pelas', 'às', 'pras', 'das', 'nas', 'um',
            'numas', 'dum', 'num', 'uma', 'duma', 'numa', 'uns', 'duns', 'nuns',
            'umas', 'dumas', 'ele', 'dele', 'nele', 'ela', 'dela', 'nela', 'eles',
            'deles', 'neles', 'elas', 'delas', 'nelas', 'este', 'deste', 'neste', 'isto',
            'disto', 'nisto', 'esse', 'desse', 'nesse', 'isso', 'disso', 'nisso', 'aquele',
            'àquele', 'praquele', 'daquele', 'naquele', 'aquilo', 'àquilo', 'praquilo', 'daquilo',
            'naquilo'
        ];

        $entities = array();
        foreach ($tokens as $token) {
            if (!in_array($token, $prepositions)) {
                array_push($entities, $token);
            }
        }

        return array_unique($entities);
    }
}

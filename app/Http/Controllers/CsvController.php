<?php

namespace App\Http\Controllers;

use App\Models\CsvQuestion;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CsvController extends Controller
{

    use ApiResponser;
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $file = $request->file('questions');
        if ($file) {
            $path = $request->file('questions')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $csv_data = array_slice($data, 0, count($data));
            unset($csv_data[0]);

            $csv_data = $this->toUtf8($csv_data);
            $csvQuestions = $this->toCsvQuestion($csv_data);
            return MenuController::build($csvQuestions);
        }

        return $this->error('Not file founded', 404);
    }

    public function toUtf8($csv_data): array
    {
        $utfEncoded = array();

        foreach ($csv_data as $data) {
            for ($i = 0; $i < count($data); $i++) {
                $data[$i] = utf8_encode($data[$i]);
            }
            array_push($utfEncoded, $data);
        }

        return $utfEncoded;
    }
    public function toCsvQuestion($csv_data): array
    {
        $csvDescriptions = array();

        foreach ($csv_data as $data) {
            $newCsvQuestion = new CsvQuestion($data);
            array_push($csvDescriptions, $newCsvQuestion->build());
        }

        return $csvDescriptions;
    }


    public function readLocally()
    {
        $path = Storage::path('bot_question.csv');
        $data = array_map('str_getcsv', file($path));
        $csv_data = array_slice($data, 0, count($data));
        unset($csv_data[0]);

        $csv_data = CsvQuestion::toUtf8($csv_data);
        $csvQuestions = CsvQuestion::toCsvQuestion($csv_data);
        MenuController::build($csvQuestions);
    }
}

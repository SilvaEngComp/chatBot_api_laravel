<?php

namespace Database\Seeders;

use App\Http\Controllers\MenuController;
use App\Models\CsvQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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

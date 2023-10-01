<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CsvUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_csv_file_questions_exist()
    {
        //arg
        $fileName = 'bot_question.csv';
        //act
        $path = Storage::path($fileName);

        //assert
        $this->assertTrue(strlen($path) > 0);
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */


    public function test_csv_file_is_been_mappad_to_array()
    {
        //arg
        $fileName = 'bot_question.csv';
        //act
        $path = Storage::path($fileName);
        $data = array_map('str_getcsv', file($path));
        //assert
        $this->assertTrue(is_array($data));
        $this->assertTrue(count($data) > 0);
    }
}

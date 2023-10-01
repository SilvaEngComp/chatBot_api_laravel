<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CsvQuestion
{

    private string $description;
    private string $answer;
    private array $path;

    function __construct(array $csvData)
    {
        if (count($csvData) >= 3) {
            $this->setDescription($csvData[0]);
            $this->setAnsware($csvData[1]);
            $this->setPath($csvData[2]);
        } else {
            $this->setDescription('');
            $this->setAnsware('');
            $this->setPath('');
        }
    }

    public function build()
    {
        return [
            "description" => $this->getDescription(),
            "answer" => $this->getAnsware(),
            "path" => $this->getPath(),
        ];
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of answer
     */
    public function getAnsware()
    {
        return $this->answer;
    }

    /**
     * Set the value of answer
     *
     * @return  self
     */
    public function setAnsware($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get the value of path
     */
    public function getPath(): array
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @return  self
     */
    public function setPath($path)
    {

        $this->path = explode('/', $path);

        return $this;
    }

    public static function toUtf8($csv_data): array
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
    public static function toCsvQuestion($csv_data): array
    {
        $csvDescriptions = array();

        foreach ($csv_data as $data) {
            $newCsvQuestion = new CsvQuestion($data);
            array_push($csvDescriptions, $newCsvQuestion->build());
        }

        return $csvDescriptions;
    }
}

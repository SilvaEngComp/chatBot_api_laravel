<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    protected $fillable = [
        "description",
        "answer",
        "topic_id"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function parents()
    {
        return Topic::ancestorsAndSelf($this->topic_id);
    }

    public function build(): array
    {
        return [
            "id" => $this->id,
            "description" => $this->description,
            "answer" => $this->answer,
            "parents" => $this->parents(),
        ];
    }
}

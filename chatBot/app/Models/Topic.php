<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Topic extends Model
{
    use NodeTrait;


    protected $fillable = [
        "name",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        '_lft', '_rgt', 'parent_id', 'created_at', 'updated_at',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}

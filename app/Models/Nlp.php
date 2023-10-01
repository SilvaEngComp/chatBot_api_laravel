<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Nlp extends Model
{
    public static function filter(Request $request)
    {
        $answares = Topic::where();
    }
}

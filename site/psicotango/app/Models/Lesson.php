<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lesson extends Model
{
    protected $table = 'lessons';

    public function course()
    {
        return $this->belongsTo('Models\Course');
    }
}

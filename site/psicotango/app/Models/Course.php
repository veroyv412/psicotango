<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    protected $table = 'courses';

    public function plans()
    {
        return $this->belongsToMany('Models\Plan');
    }

    public function lessons()
    {
        return $this->hasMany('Models\Lesson');
    }
    
    public function getLessons(){
        return $this->lessons;
    }
}

<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plan extends Model
{
    protected $table = 'plans';

    public function courses()
    {
        return $this->belongsToMany('Models\Course');
    }
}

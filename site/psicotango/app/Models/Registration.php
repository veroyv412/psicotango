<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Registration extends Model
{
    protected $table = 'registrations';

    public function plan()
    {
        return $this->belongsTo('Models\Plan');
    }

    public function user()
    {
        return $this->belongsTo('Models\User');
    }
}

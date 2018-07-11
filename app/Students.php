<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    public $table = 'students';
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'phone', 'username',
    ];
}


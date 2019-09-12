<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'parent_id', 'user_id', 'title', 'point', 'is_done', 'email'
    ];

    protected $hidden = ['email'];

}

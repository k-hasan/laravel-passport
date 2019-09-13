<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Task extends Model
{

    protected $fillable = [
        'parent_id', 'user_id', 'title', 'point', 'is_done', 'email'
    ];

    protected $hidden = ['email'];

    public function userModel()
    {
        return $this->hasOne('App\User','id','user_id');
    }

}

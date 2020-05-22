<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['creator_id', 'title'];

    public function message()
    {
        return $this->hasMany('App\Message');
    }
}

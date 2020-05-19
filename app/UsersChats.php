<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersChats extends Model
{
    protected $fillable = ['user_id', 'chat_id'];
}

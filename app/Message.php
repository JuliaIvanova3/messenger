<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['text', 'user_id', 'chat_id', 'read'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

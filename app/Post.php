<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'body'];

    protected $hidden = ['created_at', 'updated_at'];

    public function user() 
    {
        return $this->belongsTo('App\User');
    }
}

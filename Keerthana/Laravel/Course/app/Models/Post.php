<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content'];

    public static function scopeLatest($query){   //query scopes
        return $query->orderBy('created_at','desc')->get();
    }
}

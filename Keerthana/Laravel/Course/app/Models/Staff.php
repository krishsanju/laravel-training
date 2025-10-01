<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['staff_name'];
    public function photos(){
        return $this->morphMany('App\Models\Photo', 'imageable');
    }
}

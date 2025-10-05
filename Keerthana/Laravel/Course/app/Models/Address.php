<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [ 'name' ];

//ONE TO ONE
    public function user(){
        return $this ->belongsTo('App\Models\User');
    }
}

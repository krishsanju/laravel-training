<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['post_id','description'];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    // public static function createArticle(array $data)
    // {
    //     return self::create([
    //         'post_id' => $data['post_id'],
    //         'description' => $data['description'],
    //     ]);
    // }

}

<?php

namespace App\Models;

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [ 'user_id', 'title','image_path','tags'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function article(){
        return $this->hasMany(Article::class);
    }

    public static function createPost(array $data){
        return self::create([
            'title' => $data['title'],
            'image_path' => $data['image_path'],
            'tags' => $data['tags'],
            'user_id' => $data['user_id'],
        ]);
    }
}

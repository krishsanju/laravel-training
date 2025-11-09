<?php

namespace App\Models;

use App\Models\Reviews;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'api_book_id',
        'title',
        'author',
        'publisher',
        'publish_date',
        'number_of_pages',
        'description',
    ];

    protected $table = 'books';

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}

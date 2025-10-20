<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GnewsTop extends Model
{
    protected $fillable = [
        'article_id',
        'title',
        'category',
        'description',
        'content',
        // 'url',
        // 'image',
        'published_at',
        'language',
        'source_id',
        'source_name',
        // 'source_url',
        'source_country',
    ];

    // protected $casts = [
    //     'published_at' => 'datetime',
    // ];


    public static function storeArticles($articles, $category)
    {
        $data = array_map(function ($article) use ( $category) {
            return [
                'article_id'      => $article['id'],
                'title'           => $article['title'] ?? null,
                'category'        => $category ?? null,
                'description'     => $article['description'] ?? null,
                'content'         => $article['content'] ?? null,
                // 'url'             => $article['url'] ?? null,
                // 'image'           => $article['image'] ?? null,
                'published_at'    => $article['publishedAt'] ?? null,
                'language'        => $article['lang'] ?? null,
                'source_id'       => $article['source']['id'] ?? null,
                'source_name'     => $article['source']['name'] ?? null,
                // 'source_url'      => $article['source']['url'] ?? null,
                'source_country'  => $article['source']['country'] ?? null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }, $articles);
        

        self::upsert(
        $data,
        ['article_id'],
        [               
            'title',
            'category',
            'description',
            'content',
            // 'url',
            // 'image',
            'published_at',
            'language',
            'source_id',
            'source_name',
            // 'source_url',
            'source_country',
            'updated_at'
        ]
    );
        
        
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    protected $fillable = [
        'page', 'title', 'description', 'keywords', 'canonical_url',
        'og_title', 'og_description', 'og_image',
        'twitter_title', 'twitter_description', 'twitter_image',
        'schema_markup', 'head_scripts', 'body_scripts',
    ];

    public static function getForPage(string $page): ?self
    {
        return static::where('page', $page)->first();
    }
}

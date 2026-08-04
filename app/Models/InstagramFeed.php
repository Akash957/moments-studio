<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InstagramFeed extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'media_url',
        'thumbnail_url',
        'media_type',
        'caption',
        'permalink',
        'like_count',
        'comments_count',
        'posted_at',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
        'like_count'  => 'integer',
        'comments_count' => 'integer',
        'posted_at'   => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->post_id)) {
                $model->post_id = 'insta_' . time() . '_' . Str::random(6);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }
}

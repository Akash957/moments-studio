<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'author_id', 'title', 'slug', 'excerpt', 'content',
        'featured_image', 'featured_image_alt', 'reading_time', 'status',
        'published_at', 'is_featured', 'allow_comments', 'views',
        'meta_title', 'meta_description', 'meta_keywords', 'og_image',
    ];

    protected $casts = [
        'is_featured'    => 'boolean',
        'allow_comments' => 'boolean',
        'views'          => 'integer',
        'published_at'   => 'datetime',
    ];

    public static function generateUniqueSlug(string $title, int|null $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        if (empty($baseSlug)) {
            $baseSlug = 'blog-' . time();
        }
        $slug = $baseSlug;
        $count = 1;

        while (static::withTrashed()->where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($m) {
            if (empty($m->slug) || static::withTrashed()->where('slug', $m->slug)->exists()) {
                $m->slug = static::generateUniqueSlug($m->title ?? 'blog');
            }
            if ($m->status === 'published' && !$m->published_at) {
                $m->published_at = now();
            }
            if (!$m->reading_time) {
                $m->reading_time = max(1, (int) ceil(str_word_count(strip_tags($m->content)) / 200));
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_tag', 'blog_id', 'blog_tag_id');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class)->where('is_approved', true)->whereNull('parent_id');
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        if (!$this->featured_image) return 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=800';
        return str_starts_with($this->featured_image, 'http') ? $this->featured_image : asset('storage/' . $this->featured_image);
    }

    public function getExcerptLimitedAttribute(): string
    {
        return Str::limit($this->excerpt ?? strip_tags($this->content), 150);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->published();
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }
}

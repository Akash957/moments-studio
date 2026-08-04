<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Album extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'service_id', 'title', 'slug', 'description', 'cover_image',
        'location', 'event_date', 'couple_names', 'client_name', 'videographer', 'photographer',
        'is_featured', 'is_active', 'is_published', 'sort_order', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'is_featured'  => 'boolean',
        'is_active'    => 'boolean',
        'is_published' => 'boolean',
        'event_date'   => 'date',
    ];

    public function getClientNameAttribute(): ?string
    {
        return $this->attributes['couple_names'] ?? null;
    }

    public function setClientNameAttribute($value): void
    {
        $this->attributes['couple_names'] = $value;
    }

    public static function generateUniqueSlug(string $title, int|null $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        if (empty($baseSlug)) {
            $baseSlug = 'album-' . time();
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
                $m->slug = static::generateUniqueSlug($m->title ?? 'album');
            }
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class);
    }

    public function images()
    {
        return $this->hasMany(AlbumImage::class)->orderBy('sort_order');
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function getCoverImageUrlAttribute(): string
    {
        if (!$this->cover_image) return 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800';
        return str_starts_with($this->cover_image, 'http') ? $this->cover_image : asset('storage/' . $this->cover_image);
    }

    public function getImageCountAttribute(): int
    {
        return $this->images()->count();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'tagline', 'short_description',
        'long_description', 'icon', 'featured_image', 'banner_image',
        'gallery_images', 'features', 'includes', 'starting_price',
        'is_featured', 'is_active', 'sort_order',
        'meta_title', 'meta_description', 'meta_keywords',
    ];

    protected $casts = [
        'gallery_images'  => 'array',
        'features'        => 'array',
        'includes'        => 'array',
        'is_featured'     => 'boolean',
        'is_active'       => 'boolean',
        'starting_price'  => 'decimal:2',
    ];

    public function getTimeSlotsAttribute(): array
    {
        $feat = $this->features;
        if (is_array($feat) && isset($feat['time_slots']) && is_array($feat['time_slots'])) {
            return array_values(array_filter($feat['time_slots']));
        }
        return [];
    }

    public static function generateUniqueSlug(string $name, int|null $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        if (empty($baseSlug)) {
            $baseSlug = 'service-' . time();
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
        static::creating(function ($s) {
            if (empty($s->slug) || static::withTrashed()->where('slug', $s->slug)->exists()) {
                $s->slug = static::generateUniqueSlug($s->name ?? 'service');
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        $img = $this->featured_image;
        if (!$img) {
            return 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800';
        }
        if (str_starts_with($img, 'http')) {
            return $img;
        }
        if (file_exists(public_path('storage/' . $img))) {
            return asset('storage/' . $img);
        }
        if (file_exists(public_path($img))) {
            return asset($img);
        }
        return 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800';
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

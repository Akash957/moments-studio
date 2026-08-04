<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'title', 'description', 'image', 'webp_image',
        'thumbnail', 'width', 'height', 'file_size', 'alt_text',
        'photographer', 'is_featured', 'is_active', 'watermarked',
        'download_protected', 'views', 'sort_order',
    ];

    protected $casts = [
        'is_featured'        => 'boolean',
        'is_active'          => 'boolean',
        'watermarked'        => 'boolean',
        'download_protected' => 'boolean',
        'width'              => 'integer',
        'height'             => 'integer',
        'file_size'          => 'integer',
        'views'              => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class);
    }

    public function getImageUrlAttribute(): string
    {
        $img = $this->image;
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

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail && str_starts_with($this->thumbnail, 'http')) return $this->thumbnail;
        if ($this->thumbnail) return asset('storage/' . $this->thumbnail);
        return $this->image_url;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }
}

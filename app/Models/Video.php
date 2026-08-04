<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'album_id', 'title', 'slug', 'description', 'thumbnail',
        'video_url', 'video_type', 'duration', 'location', 'event_date',
        'is_featured', 'is_active', 'views', 'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'event_date'  => 'date',
        'views'       => 'integer',
    ];

    public static function generateUniqueSlug(string $title, int|null $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        if (empty($baseSlug)) {
            $baseSlug = 'video-' . time();
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
                $m->slug = static::generateUniqueSlug($m->title ?? 'video');
            }
        });
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function getEmbedUrlAttribute(): string
    {
        return match($this->video_type) {
            'youtube' => 'https://www.youtube.com/embed/' . $this->getYouTubeId(),
            'vimeo'   => 'https://player.vimeo.com/video/' . $this->getVimeoId(),
            default   => $this->video_url,
        };
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            if (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://')) {
                return $this->thumbnail;
            }
            if (str_starts_with($this->thumbnail, 'uploads/')) {
                return asset($this->thumbnail);
            }
            return asset('storage/' . $this->thumbnail);
        }
        $ytId = $this->getYouTubeId();
        if ($this->video_type === 'youtube' && !empty($ytId)) {
            return 'https://img.youtube.com/vi/' . $ytId . '/hqdefault.jpg';
        }
        return 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?w=800';
    }

    private function getYouTubeId(): string
    {
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->video_url, $matches);
        return $matches[1] ?? '';
    }

    private function getVimeoId(): string
    {
        preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches);
        return $matches[1] ?? '';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class HeroSlider extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'title', 'subtitle', 'description', 'image', 'video_url', 'media_type',
        'button_text', 'button_url', 'button_text_2', 'button_url_2',
        'overlay_color', 'overlay_opacity', 'text_color', 'text_position',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'overlay_opacity'=> 'decimal:2',
        'sort_order'     => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['title', 'is_active'])->logOnlyDirty();
    }

    public function getImageUrlAttribute(): string
    {
        return str_starts_with($this->image, 'http') ? $this->image : asset('storage/' . $this->image);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}

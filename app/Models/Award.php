<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Award extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'organization', 'year', 'description', 'image', 'certificate_url', 'is_featured', 'is_active', 'sort_order'];
    protected $casts = ['is_featured' => 'boolean', 'is_active' => 'boolean'];

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) return 'https://images.unsplash.com/photo-1567095761054-7a02e69e5c43?w=400';
        return str_starts_with($this->image, 'http') ? $this->image : asset('storage/' . $this->image);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderByDesc('year')->orderBy('sort_order');
    }
}

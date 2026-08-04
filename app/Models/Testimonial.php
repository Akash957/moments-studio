<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_name', 'client_email', 'client_image', 'wedding_location',
        'wedding_date', 'review', 'rating', 'source', 'source_url',
        'is_featured', 'is_approved', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'rating'      => 'decimal:1',
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
        'is_active'   => 'boolean',
        'wedding_date'=> 'date',
    ];

    public function getClientImageUrlAttribute(): string
    {
        if ($this->client_image) {
            return str_starts_with($this->client_image, 'http') ? $this->client_image : asset('storage/' . $this->client_image);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->client_name) . '&color=c9a96e&background=1a1a1a&size=80';
    }

    public function getStarsAttribute(): string
    {
        $full = floor($this->rating);
        $html = str_repeat('<i class="fas fa-star text-gold"></i>', $full);
        if ($this->rating - $full >= 0.5) {
            $html .= '<i class="fas fa-star-half-alt text-gold"></i>';
        }
        return $html;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('is_approved', true)->orderBy('sort_order');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true)->where('is_approved', true);
    }
}

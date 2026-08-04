<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'designation', 'bio', 'image', 'email', 'phone',
        'instagram', 'facebook', 'linkedin', 'specializations',
        'experience_years', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active'       => 'boolean',
        'specializations' => 'array',
    ];

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=c9a96e&background=1a1a1a&size=300';
        return str_starts_with($this->image, 'http') ? $this->image : asset('storage/' . $this->image);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}

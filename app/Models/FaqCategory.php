<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'is_active', 'sort_order'];
    protected $casts = ['is_active' => 'boolean'];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}

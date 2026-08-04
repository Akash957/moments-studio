<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use SoftDeletes;

    protected $fillable = ['category_id', 'question', 'answer', 'is_active', 'sort_order'];
    protected $casts = ['is_active' => 'boolean'];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}

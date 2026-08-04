<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ServiceCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'icon', 'image', 'is_active', 'sort_order'];
    protected $casts = ['is_active' => 'boolean'];

    public static function generateUniqueSlug(string $name, int|null $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        if (empty($baseSlug)) {
            $baseSlug = 'category-' . time();
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
                $m->slug = static::generateUniqueSlug($m->name ?? 'category');
            }
        });
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}

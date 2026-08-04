<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_id', 'name', 'slug', 'tagline', 'description', 'image', 'price', 'original_price', 'currency',
        'price_label', 'badge', 'badge_color', 'hours', 'edited_photos',
        'photographers', 'includes_video', 'includes_drone', 'includes_album',
        'is_featured', 'is_popular', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'price'          => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_featured'    => 'boolean',
        'is_popular'     => 'boolean',
        'is_active'      => 'boolean',
        'includes_video' => 'boolean',
        'includes_drone' => 'boolean',
        'includes_album' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
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

    public function getDiscountPercentageAttribute(): int
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return (int) round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    public function getSavingsAmountAttribute(): float
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return (float) ($this->original_price - $this->price);
        }
        return 0;
    }

    public function getFormattedOriginalPriceAttribute(): ?string
    {
        if (!$this->original_price) return null;
        return '₹' . number_format($this->original_price, 0, '.', ',');
    }

    public static function generateUniqueSlug(string $name, int|null $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        if (empty($baseSlug)) {
            $baseSlug = 'package-' . time();
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
        
        if (!\Illuminate\Support\Facades\Schema::hasColumn('packages', 'image')) {
            try {
                \Illuminate\Support\Facades\Schema::table('packages', function (\Illuminate\Database\Schema\Blueprint $table) {
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('packages', 'image')) {
                        $table->string('image')->nullable()->after('description');
                    }
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('packages', 'original_price')) {
                        $table->decimal('original_price', 10, 2)->nullable()->after('price');
                    }
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('packages', 'service_id')) {
                        $table->foreignId('service_id')->nullable()->after('id')->constrained('services')->nullOnDelete();
                    }
                });
            } catch (\Throwable $e) {
                // Already updated
            }
        }

        static::creating(function ($m) {
            if (empty($m->slug) || static::withTrashed()->where('slug', $m->slug)->exists()) {
                $m->slug = static::generateUniqueSlug($m->name ?? 'package');
            }
        });
    }

    public function features()
    {
        return $this->hasMany(PackageFeature::class)->orderBy('sort_order');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->currency === 'INR') {
            return '₹' . number_format($this->price, 0, '.', ',');
        }
        return '$' . number_format($this->price, 0, '.', ',');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}

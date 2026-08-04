<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumImage extends Model
{
    use HasFactory;

    protected $fillable = ['album_id', 'image', 'thumbnail', 'webp_image', 'caption', 'alt_text', 'sort_order'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function getImageUrlAttribute(): string
    {
        return str_starts_with($this->image, 'http') ? $this->image : asset('storage/' . $this->image);
    }
}

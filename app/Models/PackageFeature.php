<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageFeature extends Model
{
    use HasFactory;

    protected $fillable = ['package_id', 'feature', 'is_included', 'sort_order'];
    protected $casts = ['is_included' => 'boolean'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}

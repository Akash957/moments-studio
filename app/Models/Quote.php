<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quote_number', 'booking_id', 'client_name', 'client_email', 'client_phone',
        'event_type', 'event_date', 'event_location', 'guest_count', 'requirements',
        'base_price', 'discount_amount', 'tax_amount', 'total_amount', 'line_items',
        'terms', 'status', 'sent_at', 'expires_at', 'approved_at', 'rejection_reason', 'admin_notes',
    ];

    protected $casts = [
        'event_date'      => 'date',
        'line_items'      => 'array',
        'sent_at'         => 'datetime',
        'expires_at'      => 'datetime',
        'approved_at'     => 'datetime',
        'base_price'      => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount'      => 'decimal:2',
        'total_amount'    => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($q) {
            $q->quote_number = 'QT-' . strtoupper(Str::random(8));
        });
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'draft'    => '<span class="badge bg-secondary">Draft</span>',
            'sent'     => '<span class="badge bg-info">Sent</span>',
            'viewed'   => '<span class="badge bg-warning">Viewed</span>',
            'approved' => '<span class="badge bg-success">Approved</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            'expired'  => '<span class="badge bg-dark">Expired</span>',
            default    => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}

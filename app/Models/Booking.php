<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_number', 'user_id', 'service_id', 'package_id',
        'client_name', 'client_email', 'client_phone',
        'event_type', 'event_date', 'event_time', 'event_location', 'event_city',
        'guest_count', 'special_requirements', 'reference_images',
        'quoted_price', 'advance_paid', 'total_amount', 'discount_amount', 'tax_amount',
        'coupon_code', 'status', 'payment_status', 'payment_method', 'transaction_id',
        'admin_notes', 'cancellation_reason', 'confirmed_at', 'completed_at',
    ];

    protected $casts = [
        'reference_images' => 'array',
        'event_date'       => 'date',
        'confirmed_at'     => 'datetime',
        'completed_at'     => 'datetime',
        'quoted_price'     => 'decimal:2',
        'advance_paid'     => 'decimal:2',
        'total_amount'     => 'decimal:2',
        'discount_amount'  => 'decimal:2',
        'tax_amount'       => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($booking) {
            $booking->booking_number = 'MS-' . strtoupper(Str::random(8));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function quote()
    {
        return $this->hasOne(Quote::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'     => '<span class="badge bg-warning">Pending</span>',
            'confirmed'   => '<span class="badge bg-success">Confirmed</span>',
            'in_progress' => '<span class="badge bg-info">In Progress</span>',
            'completed'   => '<span class="badge bg-primary">Completed</span>',
            'cancelled'   => '<span class="badge bg-secondary">Cancelled</span>',
            'rejected'    => '<span class="badge bg-danger">Rejected</span>',
            default       => '<span class="badge bg-secondary">' . ucfirst($this->status) . '</span>',
        };
    }

    public function getPaymentBadgeAttribute(): string
    {
        return match($this->payment_status) {
            'paid'     => '<span class="badge bg-success">Paid</span>',
            'partial'  => '<span class="badge bg-warning">Partial</span>',
            'refunded' => '<span class="badge bg-info">Refunded</span>',
            default    => '<span class="badge bg-danger">Unpaid</span>',
        };
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now())->orderBy('event_date');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message', 'event_type', 'event_date',
        'source', 'page_url', 'status', 'admin_reply', 'replied_at', 'ip_address', 'user_agent',
    ];

    protected $casts = [
        'event_date' => 'date',
        'replied_at' => 'datetime',
    ];

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'new'     => '<span class="badge bg-danger">New</span>',
            'read'    => '<span class="badge bg-warning">Read</span>',
            'replied' => '<span class="badge bg-success">Replied</span>',
            'closed'  => '<span class="badge bg-secondary">Closed</span>',
            default   => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeUnread($query)
    {
        return $query->whereIn('status', ['new']);
    }
}

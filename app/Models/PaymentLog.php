<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'gateway_transaction_id',
        'event_type',
        'payload',
        'ip_address',
        'is_verified',
    ];

    protected $casts = [
        'payload'     => 'array',
        'is_verified' => 'boolean',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}

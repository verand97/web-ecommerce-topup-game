<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'product_id',
        'total_price',
        'player_user_id',
        'player_zone_id',
        'player_nickname',
        'status',
        'notes',
        'customer_email',
        'customer_phone',
        'paid_at',
        'completed_at',
    ];

    protected $casts = [
        'total_price'   => 'decimal:2',
        'paid_at'       => 'datetime',
        'completed_at'  => 'datetime',
    ];

    // ─── Status constants ─────────────────────────────────────────────────
    const STATUS_PENDING    = 'pending';
    const STATUS_PAID       = 'paid';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED  = 'completed';
    const STATUS_FAILED     = 'failed';
    const STATUS_CANCELLED  = 'cancelled';
    const STATUS_REFUNDED   = 'refunded';

    // ─── Relationships ────────────────────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    public function paymentLogs(): HasMany
    {
        return $this->hasMany(PaymentLog::class);
    }

    // ─── Scopes ───────────────────────────────────────────────────────────
    public function scopeRecent($query, int $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'paid'       => 'bg-blue-500/20 text-blue-400',
            'processing' => 'bg-yellow-500/20 text-yellow-400',
            'completed'  => 'bg-green-500/20 text-green-400',
            'failed'     => 'bg-red-500/20 text-red-400',
            'cancelled'  => 'bg-gray-500/20 text-gray-400',
            'refunded'   => 'bg-purple-500/20 text-purple-400',
            default      => 'bg-gray-500/20 text-gray-400',
        };
    }

    public static function generateOrderNumber(): string
    {
        $prefix    = 'VS';
        $date      = now()->format('Ymd');
        $random    = strtoupper(substr(uniqid(), -5));
        return "{$prefix}-{$date}-{$random}";
    }
}

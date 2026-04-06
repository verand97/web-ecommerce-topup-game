<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'cover_image',
        'description',
        'publisher',
        'requires_zone_id',
        'user_id_label',
        'zone_id_label',
        'user_id_regex',
        'zone_id_regex',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'requires_zone_id' => 'boolean',
        'is_active'        => 'boolean',
    ];

    // ─── Relationships ────────────────────────────────────────────────────
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // ─── Scopes ───────────────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    // ─── Accessors ────────────────────────────────────────────────────────
    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/placeholder-game.png');
    }
}

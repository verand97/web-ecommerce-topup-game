<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $ml  = Category::where('slug', 'mobile-legends')->first();
        $ff  = Category::where('slug', 'free-fire')->first();
        $pubg = Category::where('slug', 'pubg-mobile')->first();
        $gi  = Category::where('slug', 'genshin-impact')->first();

        $products = [];

        // ── Mobile Legends Diamonds ───────────────────────────────────────
        if ($ml) {
            $mlDiamonds = [
                [3, 'Rp 2.500', 2500, null, 1],
                [5, 'Rp 3.500', 3500, null, 2],
                [12, 'Rp 8.000', 8000, null, 3],
                [19, 'Rp 13.000', 13000, null, 4],
                [28, 'Rp 19.000', 19000, null, 5],
                [50, 'Rp 32.000', 32000, null, 6],
                [86, 'Rp 49.000', 49000, null, 7],
                [172, 'Rp 99.000', 99000, null, 8],
                [257, 'Rp 143.000', 143000, null, 9],
                [344, 'Rp 190.000', 190000, null, 10],
                [514, 'Rp 279.000', 279000, null, 11],
                [706, 'Rp 369.000', 369000, null, 12],
            ];
            foreach ($mlDiamonds as [$amount, $name, $price, $origPrice, $order]) {
                $products[] = [
                    'category_id'    => $ml->id,
                    'name'           => "{$amount} Diamond",
                    'slug'           => "ml-diamond-{$amount}-" . Str::random(4),
                    'type'           => 'diamond',
                    'price'          => $price,
                    'original_price' => $origPrice ?? $price,
                    'amount'         => $amount,
                    'unit'           => 'Diamond',
                    'stock'          => -1,
                    'sort_order'     => $order,
                    'is_active'      => true,
                    'is_featured'    => in_array($amount, [86, 172, 344]),
                ];
            }
        }

        // ── Free Fire Diamonds ──────────────────────────────────────────
        if ($ff) {
            $ffDiamonds = [[5, 3500], [12, 7500], [50, 25000], [100, 49000], [210, 99000], [530, 249000], [1060, 499000]];
            foreach ($ffDiamonds as $i => [$amount, $price]) {
                $products[] = [
                    'category_id'    => $ff->id,
                    'name'           => "{$amount} Diamond",
                    'slug'           => "ff-diamond-{$amount}-" . Str::random(4),
                    'type'           => 'diamond',
                    'price'          => $price,
                    'original_price' => $price,
                    'amount'         => $amount,
                    'unit'           => 'Diamond',
                    'stock'          => -1,
                    'sort_order'     => $i + 1,
                    'is_active'      => true,
                    'is_featured'    => in_array($amount, [210, 530]),
                ];
            }
        }

        // ── PUBG Mobile UC ──────────────────────────────────────────────
        if ($pubg) {
            $pubgUC = [[60, 14000], [180, 41000], [325, 74000], [660, 149000], [1800, 399000]];
            foreach ($pubgUC as $i => [$amount, $price]) {
                $products[] = [
                    'category_id'    => $pubg->id,
                    'name'           => "{$amount} UC",
                    'slug'           => "pubg-uc-{$amount}-" . Str::random(4),
                    'type'           => 'diamond',
                    'price'          => $price,
                    'original_price' => $price,
                    'amount'         => $amount,
                    'unit'           => 'UC',
                    'stock'          => -1,
                    'sort_order'     => $i + 1,
                    'is_active'      => true,
                    'is_featured'    => in_array($amount, [325, 660]),
                ];
            }
        }

        // ── Genshin Impact Genesis Crystals ────────────────────────────
        if ($gi) {
            $giCrystals = [[60, 14000], [330, 74000], [980, 219000], [1980, 439000], [3280, 699000]];
            foreach ($giCrystals as $i => [$amount, $price]) {
                $products[] = [
                    'category_id'    => $gi->id,
                    'name'           => "{$amount} Genesis Crystal",
                    'slug'           => "gi-crystal-{$amount}-" . Str::random(4),
                    'type'           => 'diamond',
                    'price'          => $price,
                    'original_price' => $price,
                    'amount'         => $amount,
                    'unit'           => 'Crystal',
                    'stock'          => -1,
                    'sort_order'     => $i + 1,
                    'is_active'      => true,
                    'is_featured'    => in_array($amount, [330, 980]),
                ];
            }
        }

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

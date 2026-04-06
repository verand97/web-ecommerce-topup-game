<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{

    // ─── Public Methods ───────────────────────────────────────────────────

    public function all(array $filters = [])
    {
        return $this->applyFilters(Product::with('category')->active(), $filters)->get();
    }

    public function findById(int $id)
    {
        return Product::with('category')->findOrFail($id);
    }

    public function findBySlug(string $slug)
    {
        return Product::with('category')->where('slug', $slug)->firstOrFail();
    }

    public function findByCategory(int $categoryId, array $filters = [])
    {
        $query = Product::with('category')
            ->where('category_id', $categoryId)
            ->active();
        return $this->applyFilters($query, $filters)->get();
    }

    public function findFeatured(int $limit = 8)
    {
        return Product::with('category')->featured()->limit($limit)->get();
    }

    /**
     * Binary search on sorted price array to find the closest denomination.
     * Used by voucher denomination selector.
     */
    public function search(string $keyword)
    {
        return Product::with('category')
            ->active()
            ->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhereHas('category', fn ($cq) => $cq->where('name', 'like', "%{$keyword}%"));
            })
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Atomic stock decrement with row-level lock.
     * Returns false if stock is insufficient.
     */
    public function decrementStock(int $productId, int $qty = 1): bool
    {
        return DB::transaction(function () use ($productId, $qty) {
            $product = Product::lockForUpdate()->findOrFail($productId);

            if ($product->stock !== -1 && $product->stock < $qty) {
                return false;
            }

            if ($product->stock !== -1) {
                $product->decrement('stock', $qty);
            }

            return true;
        });
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(int $id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product->fresh();
    }

    public function delete(int $id): bool
    {
        return Product::destroy($id) > 0;
    }

    public function paginate(int $perPage = 20, array $filters = [])
    {
        return $this->applyFilters(Product::with('category'), $filters)->paginate($perPage);
    }

    // ─── Private Helpers ──────────────────────────────────────────────────

    private function applyFilters($query, array $filters)
    {
        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }
        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        if (! empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (! empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }
        return $query->orderBy('sort_order');
    }
}

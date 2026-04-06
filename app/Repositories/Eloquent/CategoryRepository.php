<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class CategoryRepository implements CategoryRepositoryInterface
{
    private const CACHE_KEY = 'categories:active';
    private const CACHE_TTL = 3600;

    public function allActive()
    {
        return Category::active()->get();
    }

    public function findById(int $id)
    {
        return Category::findOrFail($id);
    }

    public function findBySlug(string $slug)
    {
        return Category::where('slug', $slug)->firstOrFail();
    }

    public function create(array $data)
    {
        $cat = Category::create($data);
        $this->invalidateCache();
        return $cat;
    }

    public function update(int $id, array $data)
    {
        $cat = Category::findOrFail($id);
        $cat->update($data);
        $this->invalidateCache();
        return $cat->fresh();
    }

    public function delete(int $id): bool
    {
        $deleted = Category::destroy($id);
        $this->invalidateCache();
        return $deleted > 0;
    }

    public function paginate(int $perPage = 20)
    {
        return Category::orderBy('sort_order')->paginate($perPage);
    }

    private function invalidateCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}

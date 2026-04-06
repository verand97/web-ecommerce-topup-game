<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    public function all(array $filters = []);
    public function findById(int $id);
    public function findBySlug(string $slug);
    public function findByCategory(int $categoryId, array $filters = []);
    public function findFeatured(int $limit = 8);
    public function search(string $keyword);
    public function decrementStock(int $productId, int $qty = 1): bool;
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id): bool;
    public function paginate(int $perPage = 20, array $filters = []);
}

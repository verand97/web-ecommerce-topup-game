<?php

namespace App\Repositories\Contracts;

interface OrderRepositoryInterface
{
    public function findById(int $id);
    public function findByOrderNumber(string $orderNumber);
    public function findByUser(int $userId, int $perPage = 10);
    public function create(array $data);
    public function updateStatus(int $id, string $status, array $extra = []): bool;
    public function recentOrders(int $limit = 10);
    public function todayRevenue(): float;
    public function monthRevenue(): float;
    public function paginate(int $perPage = 20, array $filters = []);
}

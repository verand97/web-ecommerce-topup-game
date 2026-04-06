<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepo,
        private readonly ProductRepositoryInterface  $productRepo,
    ) {}

    public function index()
    {
        $categories = $this->categoryRepo->allActive();
        $featured   = $this->productRepo->findFeatured(8);

        Log::info('Categories first type: ' . gettype($categories->first()));
        Log::info('Featured first type: ' . gettype($featured->first()));
        if (is_scalar($categories->first())) Log::info('Categories first value: ' . $categories->first());
        return view('home.index', compact('categories', 'featured'));
    }
}

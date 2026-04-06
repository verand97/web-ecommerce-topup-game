<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\PlayerValidationService;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepo,
        private readonly ProductRepositoryInterface  $productRepo,
        private readonly PlayerValidationService     $playerValidator
    ) {}

    /**
     * Catalog index — shows all active categories.
     */
    public function index()
    {
        $categories = $this->categoryRepo->allActive();
        return view('catalog.index', compact('categories'));
    }

    /**
     * Show products for a specific game/category.
     */
    public function show(string $slug)
    {
        $category = $this->categoryRepo->findBySlug($slug);
        $products = $this->productRepo->findByCategory($category->id);

        $grouped = $products->groupBy('type'); // diamond, skin, voucher, etc.

        return view('catalog.show', compact('category', 'products', 'grouped'));
    }

    /**
     * AJAX / search endpoint & player validation
     */
    public function search(Request $request)
    {
        if ($request->has('action') && $request->action === 'validate_player') {
            $request->validate([
                'category_slug' => 'required|string',
                'user_id'       => 'required|string',
                'zone_id'       => 'nullable|string',
            ]);

            try {
                $category = $this->categoryRepo->findBySlug($request->category_slug);
                $ign = $this->playerValidator->fetchPlayerName($category, $request->user_id, $request->zone_id);

                if ($ign) {
                    return response()->json(['success' => true, 'ign' => $ign]);
                }
                return response()->json(['success' => false, 'message' => 'Player tidak ditemukan. Pastikan ID dan Zone benar.'], 404);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan.'], 400);
            }
        }

        $request->validate(['q' => 'required|string|min:2|max:100']);
        $results = $this->productRepo->search($request->q);

        return response()->json($results->take(10));
    }
}

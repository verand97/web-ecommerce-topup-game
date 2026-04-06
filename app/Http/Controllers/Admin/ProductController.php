<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepositoryInterface  $productRepo,
        private readonly CategoryRepositoryInterface $categoryRepo,
    ) {}

    public function index(Request $request)
    {
        $filters  = $request->only(['category_id', 'type', 'status']);
        $products = $this->productRepo->paginate(20, $filters);
        $categories = $this->categoryRepo->allActive();
        return view('admin.products.index', compact('products', 'categories', 'filters'));
    }

    public function create()
    {
        $categories = $this->categoryRepo->allActive();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);
        $this->productRepo->create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dibuat.');
    }

    public function edit(int $id)
    {
        $product    = $this->productRepo->findById($id);
        $categories = $this->categoryRepo->allActive();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validateProduct($request);

        if ($request->hasFile('image')) {
            $oldProduct = $this->productRepo->findById($id);
            if ($oldProduct->image) {
                Storage::disk('public')->delete($oldProduct->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $this->productRepo->update($id, $data);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->productRepo->delete($id);
        return redirect()->route('admin.products.index')->with('success', 'Produk dihapus.');
    }

    private function validateProduct(Request $request): array
    {
        return $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|string|max:100',
            'description'    => 'nullable|string',
            'type'           => 'required|in:diamond,skin,voucher,weekly_pass,monthly_pass,other',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'amount'         => 'required|integer|min:0',
            'unit'           => 'required|string|max:30',
            'stock'          => 'required|integer|min:-1',
            'sort_order'     => 'nullable|integer|min:0',
            'is_active'      => 'boolean',
            'is_featured'    => 'boolean',
            'image'          => 'nullable|image|max:2048',
        ]);
    }
}

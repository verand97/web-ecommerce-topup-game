<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepo,
    ) {}

    public function index()
    {
        $categories = $this->categoryRepo->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form');
    }

    public function store(Request $request)
    {
        $data = $this->validateCategory($request);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('categories', 'public');
        }
        $data['slug'] = Str::slug($data['name']);
        $this->categoryRepo->create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dibuat.');
    }

    public function edit(int $id)
    {
        $category = $this->categoryRepo->findById($id);
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validateCategory($request);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        $this->categoryRepo->update($id, $data);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->categoryRepo->delete($id);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori dihapus.');
    }

    private function validateCategory(Request $request): array
    {
        return $request->validate([
            'name'             => 'required|string|max:100',
            'description'      => 'nullable|string',
            'publisher'        => 'nullable|string|max:100',
            'requires_zone_id' => 'boolean',
            'user_id_label'    => 'nullable|string|max:50',
            'zone_id_label'    => 'nullable|string|max:50',
            'user_id_regex'    => 'nullable|string|max:200',
            'zone_id_regex'    => 'nullable|string|max:200',
            'sort_order'       => 'nullable|integer|min:0',
            'is_active'        => 'boolean',
            'image'            => 'nullable|image|max:2048',
            'cover_image'      => 'nullable|image|max:4096',
        ]);
    }
}

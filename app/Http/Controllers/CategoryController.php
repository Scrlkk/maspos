<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category')->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->nama,
                'price' => $product->harga !== null ? 'Rp ' . number_format((float) $product->harga, 0, ',', '.') : null,
                'image' => $product->gambar ? asset('storage/' . $product->gambar) : null,
                'category' => $product->category->nama ?? 'Tanpa Kategori',
                'category_id' => $product->category_id,
                'raw_price' => $product->harga,
            ];
        });

        return Inertia::render('DashboardView', [
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama'
        ], [
            'nama.required' => 'Nama kategori wajib diisi',
            'nama.unique' => 'Nama kategori sudah ada',
            'nama.max' => 'Nama kategori maksimal 255 karakter'
        ]);

        Category::create($validated);

        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::all();

        return Inertia::render('ProductAdd', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:products,nama',
            'harga' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:5120'
        ], [
            'nama.required' => 'Nama produk wajib diisi',
            'nama.unique' => 'Nama produk sudah ada',
            'nama.max' => 'Nama produk maksimal 255 karakter',
            'harga.required' => 'Harga produk wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
            'category_id.required' => 'Kategori wajib dipilih',
            'category_id.exists' => 'Kategori tidak valid',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'gambar.max' => 'Ukuran gambar maksimal 5MB'
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('products', $filename, 'public');
            $validated['gambar'] = $path;
        }

        Product::create($validated);

        return redirect()->route('product.add')->with('success', 'Produk berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()->back();
    }
}

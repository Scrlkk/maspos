<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [

            ['nama' => 'Nasi Goreng', 'harga' => 15000, 'category_name' => 'Makanan'],
            ['nama' => 'Mie Ayam', 'harga' => 12000, 'category_name' => 'Makanan'],
            ['nama' => 'Soto Ayam', 'harga' => 13000, 'category_name' => 'Makanan'],
            ['nama' => 'Gado-gado', 'harga' => 10000, 'category_name' => 'Makanan'],


            ['nama' => 'Es Teh', 'harga' => 3000, 'category_name' => 'Minuman'],
            ['nama' => 'Es Jeruk', 'harga' => 5000, 'category_name' => 'Minuman'],
            ['nama' => 'Kopi Hitam', 'harga' => 8000, 'category_name' => 'Minuman'],
            ['nama' => 'Jus Alpukat', 'harga' => 12000, 'category_name' => 'Minuman'],


            ['nama' => 'Charger HP', 'harga' => 25000, 'category_name' => 'Elektronik'],
            ['nama' => 'Earphone', 'harga' => 35000, 'category_name' => 'Elektronik'],
            ['nama' => 'Power Bank', 'harga' => 150000, 'category_name' => 'Elektronik'],


            ['nama' => 'Kaos Polos', 'harga' => 45000, 'category_name' => 'Pakaian'],
            ['nama' => 'Kemeja', 'harga' => 85000, 'category_name' => 'Pakaian'],
            ['nama' => 'Celana Jeans', 'harga' => 125000, 'category_name' => 'Pakaian'],

            ['nama' => 'Jam Tangan', 'harga' => 200000, 'category_name' => 'Aksesoris'],
            ['nama' => 'Gelang', 'harga' => 50000, 'category_name' => 'Aksesoris'],
            ['nama' => 'Kalung', 'harga' => 75000, 'category_name' => 'Aksesoris'],

            ['nama' => 'Buku Tulis', 'harga' => 5000, 'category_name' => 'Buku & Alat Tulis'],
            ['nama' => 'Pulpen', 'harga' => 2000, 'category_name' => 'Buku & Alat Tulis'],
            ['nama' => 'Penggaris', 'harga' => 3000, 'category_name' => 'Buku & Alat Tulis'],
        ];

        foreach ($products as $productData) {
            $category = Category::where('nama', $productData['category_name'])->first();

            if ($category) {
                Product::create([
                    'nama' => $productData['nama'],
                    'harga' => $productData['harga'],
                    'category_id' => $category->id,
                    'gambar' => null,
                ]);
            }
        }
    }
}
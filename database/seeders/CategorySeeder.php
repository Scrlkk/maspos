<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Makanan',
            'Minuman',
            'Elektronik',
            'Pakaian',
            'Aksesoris',
            'Buku & Alat Tulis',
            'Kesehatan & Kecantikan',
            'Olahraga',
        ];

        foreach ($categories as $category) {
            Category::create([
                'nama' => $category,
            ]);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::create([
            'name' => 'Kategori Default',
        ]);

        Product::create([
            'name' => 'Produk 1',
            'description' => 'Deskripsi produk 1',
            'price' => 100000,
            'stock' => 10,
            'category_id' => $category->id, // ID kategori
        ]);
    }
}

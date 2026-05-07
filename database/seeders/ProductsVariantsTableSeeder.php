<?php

namespace Database\Seeders;

use App\Models\ProductsVariant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsVariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductsVariant::create([
            'product_id' => 1,
            'size' => 'S',
            'price' => 620,
            'stocks' => 100,
        ]);

        ProductsVariant::create([
            'product_id' => 1,
            'size' => 'M',
            'price' => 620,
            'stocks' => 100,
        ]);

        ProductsVariant::create([
            'product_id' => 1,
            'size' => 'L',
            'price' => 620,
            'stocks' => 100,
        ]);
        ProductsVariant::create([
            'product_id' => 1,
            'size' => 'XL',
            'price' => 645,
            'stocks' => 100,
        ]);

        ProductsVariant::create([
            'product_id' => 1,
            'size' => '2XL',
            'price' => 645,
            'stocks' => 100,
        ]);

        ProductsVariant::create([
            'product_id' => 1,
            'size' => '3XL',
            'price' => 645,
            'stocks' => 100,
        ]);

        ProductsVariant::create([
            'product_id' => 1,
            'size' => '4XL',
            'price' => 645,
            'stocks' => 100,
        ]);

        ProductsVariant::create([
            'product_id' => 1,
            'size' => '5XL',
            'price' => 645,
            'stocks' => 100,
        ]);

        ProductsVariant::create([
            'product_id' => 1,
            'size' => '6XL',
            'price' => 645,
            'stocks' => 100,
        ]);
    }
}

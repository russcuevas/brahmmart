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
            'gender' => 'Female',
            'price' => 620,
            'stocks' => 100,
        ]);

        ProductsVariant::create([
            'product_id' => 1,
            'size' => 'M',
            'gender' => 'Female',
            'price' => 620,
            'stocks' => 100,
        ]);

        ProductsVariant::create([
            'product_id' => 1,
            'size' => 'L',
            'gender' => 'Female',

            'price' => 620,
            'stocks' => 100,
        ]);
        ProductsVariant::create([
            'product_id' => 1,
            'size' => 'XL',
            'gender' => 'Female',

            'price' => 645,
            'stocks' => 100,
        ]);

        ProductsVariant::create([
            'product_id' => 1,
            'size' => '2XL',
            'gender' => 'Female',

            'price' => 645,
            'stocks' => 100,
        ]);

        ProductsVariant::create([
            'product_id' => 1,
            'size' => '3XL',
            'gender' => 'Female',

            'price' => 645,
            'stocks' => 100,
        ]);

        ProductsVariant::create([
            'product_id' => 1,
            'size' => '4XL',
            'gender' => 'Female',

            'price' => 645,
            'stocks' => 100,
        ]);

        ProductsVariant::create([
            'product_id' => 1,
            'size' => '5XL',
            'gender' => 'Female',

            'price' => 645,
            'stocks' => 100,
        ]);

        ProductsVariant::create([
            'product_id' => 1,
            'size' => '6XL',
            'gender' => 'Female',

            'price' => 645,
            'stocks' => 100,
        ]);
    }
}

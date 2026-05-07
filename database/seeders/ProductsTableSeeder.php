<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Products::create([
            'category_id' => 1,
            'uniform_category_id' => 3,
            'product_name' => 'Blouse',
            'product_description' => 'The official University of Batangas school polo is crafted from premium cotton-polyester blend for lasting comfort. Features an embroidered UB logo, reinforced stitching, and a classic fit that meets school dress code standards. Designed for everyday wear throughout the academic year.',
            'product_price' => null,
            'product_image' => null,
            'stocks' => null,
            'has_variant' => true,
        ]);

        // Category 2 is school supplies
        Products::create([
            'category_id' => 2,
            'uniform_category_id' => null,
            'product_name' => 'Cattleya Notebook - 100 leaves',
            'product_description' => 'Perfect for note-taking and schoolwork, this notebook features 100 high-quality lined pages, durable cover, and a spiral binding that lays flat for comfortable writing. Ideal for students and professionals who need reliable and practical notebooks for everyday use.',
            'product_price' => 50,
            'product_image' => null,
            'stocks' => 100,
            'has_variant' => false,
        ]);

        // Category 3 is books
        Products::create([
            'category_id' => 3,
            'uniform_category_id' => null,
            'product_name' => 'Computer Programming (2022 Edition)',
            'product_description' => 'This textbook provides a comprehensive introduction to computer programming with a focus on modern programming languages and techniques. It covers fundamental programming concepts, including data structures, algorithms, and software development methodologies. The book includes practical examples, exercises, and real-world case studies to help students develop their programming skills. Ideal for beginners and intermediate programmers looking to enhance their knowledge and expertise in computer programming.',
            'product_price' => 300,
            'product_image' => null,
            'stocks' => 100,
            'has_variant' => false,
        ]);
    }
}

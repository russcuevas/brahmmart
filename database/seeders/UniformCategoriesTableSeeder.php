<?php

namespace Database\Seeders;

use App\Models\UniformCategories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniformCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UniformCategories::create([
            'uniform_name' => 'Junior High School Uniform',
        ]);
        UniformCategories::create([
            'uniform_name' => 'Senior High School Uniform',
        ]);
        UniformCategories::create([
            'uniform_name' => 'College Type A Uniform',
        ]);
        UniformCategories::create([
            'uniform_name' => 'Nursing Uniform',
        ]);
        UniformCategories::create([
            'uniform_name' => 'Medical Technology Uniform',
        ]);
        UniformCategories::create([
            'uniform_name' => 'Tourism Uniform',
        ]);
        UniformCategories::create([
            'uniform_name' => 'CTHM Uniform',
        ]);
        UniformCategories::create([
            'uniform_name' => 'Criminology Uniform',
        ]);
        UniformCategories::create([
            'uniform_name' => 'Others',
        ]);
        UniformCategories::create([
            'uniform_name' => 'Junior/Senior/College PE Uniform',
        ]);
    }
}

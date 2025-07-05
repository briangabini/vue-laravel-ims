<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Peripherals
            ['name' => 'Keyboards', 'slug' => 'keyboards'],
            ['name' => 'Mice', 'slug' => 'mice'],
            ['name' => 'Monitors', 'slug' => 'monitors'],
            ['name' => 'Headsets', 'slug' => 'headsets'],
            ['name' => 'Webcams', 'slug' => 'webcams'],

            // Core Components
            ['name' => 'Graphics Cards', 'slug' => 'graphics-cards'],
            ['name' => 'Processors (CPU)', 'slug' => 'processors-cpu'],
            ['name' => 'Motherboards', 'slug' => 'motherboards'],
            ['name' => 'Memory (RAM)', 'slug' => 'memory-ram'],
            ['name' => 'Storage (SSD, HDD)', 'slug' => 'storage'],
            ['name' => 'Power Supplies (PSU)', 'slug' => 'power-supplies'],
            ['name' => 'PC Cases', 'slug' => 'pc-cases'],

            // Pre-builts & Laptops
            ['name' => 'Laptops', 'slug' => 'laptops'],
            ['name' => 'Desktop PCs', 'slug' => 'desktop-pcs'],

            // Other
            ['name' => 'Gaming Consoles', 'slug' => 'gaming-consoles'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

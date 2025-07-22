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
            ['name' => 'Keyboards', 'slug' => 'keyboards', 'description' => 'High-performance keyboards for every need.'],
            ['name' => 'Mice', 'slug' => 'mice', 'description' => 'Precision mice for gaming and productivity.'],
            ['name' => 'Monitors', 'slug' => 'monitors', 'description' => 'Vibrant displays for immersive experiences.'],
            ['name' => 'Headsets', 'slug' => 'headsets', 'description' => 'Clear audio and comfortable fit headsets.'],
            ['name' => 'Webcams', 'slug' => 'webcams', 'description' => 'High-definition webcams for clear video calls.'],

            // Core Components
            ['name' => 'Graphics Cards', 'slug' => 'graphics-cards', 'description' => 'Powerful graphics cards for ultimate gaming and design.'],
            ['name' => 'Processors (CPU)', 'slug' => 'processors-cpu', 'description' => 'The brain of your computer, delivering raw power.'],
            ['name' => 'Motherboards', 'slug' => 'motherboards', 'description' => 'The foundation for all your PC components.'],
            ['name' => 'Memory (RAM)', 'slug' => 'memory-ram', 'description' => 'Fast memory for smooth multitasking.'],
            ['name' => 'Storage (SSD, HDD)', 'slug' => 'storage', 'description' => 'Reliable storage solutions for all your data.'],
            ['name' => 'Power Supplies (PSU)', 'slug' => 'power-supplies', 'description' => 'Efficient power for stable system performance.'],
            ['name' => 'PC Cases', 'slug' => 'pc-cases', 'description' => 'Stylish and functional cases for your PC build.'],

            // Pre-builts & Laptops
            ['name' => 'Laptops', 'slug' => 'laptops', 'description' => 'Portable computing for work and play.'],
            ['name' => 'Desktop PCs', 'slug' => 'desktop-pcs', 'description' => 'Powerful pre-built systems for any task.'],

            // Other
            ['name' => 'Gaming Consoles', 'slug' => 'gaming-consoles', 'description' => 'Next-gen gaming experiences.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch categories
        $categories = \App\Models\Category::all()->keyBy('slug');

        $products = [
            // Keyboards
            [
                'name' => 'Logitech MX Keys',
                'description' => 'Advanced wireless illuminated keyboard.',
                'price' => 119.99,
                'stock' => 150,
                'category_id' => $categories['keyboards']->id,
            ],
            [
                'name' => 'Razer Huntsman Elite',
                'description' => 'Gaming keyboard with opto-mechanical switches.',
                'price' => 199.99,
                'stock' => 80,
                'category_id' => $categories['keyboards']->id,
            ],
            [
                'name' => 'Corsair K95 RGB Platinum',
                'description' => 'Mechanical gaming keyboard with Cherry MX Speed switches.',
                'price' => 179.99,
                'stock' => 90,
                'category_id' => $categories['keyboards']->id,
            ],

            // Mice
            [
                'name' => 'Logitech MX Master 3S',
                'description' => 'High-precision wireless mouse for creatives and developers.',
                'price' => 99.99,
                'stock' => 200,
                'category_id' => $categories['mice']->id,
            ],
            [
                'name' => 'Razer DeathAdder V2',
                'description' => 'Ergonomic gaming mouse with a 20K DPI optical sensor.',
                'price' => 69.99,
                'stock' => 120,
                'category_id' => $categories['mice']->id,
            ],
            [
                'name' => 'SteelSeries Rival 600',
                'description' => 'Gaming mouse with dual sensor system for true 1-to-1 tracking.',
                'price' => 79.99,
                'stock' => 100,
                'category_id' => $categories['mice']->id,
            ],

            // Monitors
            [
                'name' => 'Dell UltraSharp U2723QE',
                'description' => '27-inch 4K UHD monitor with excellent color accuracy.',
                'price' => 579.99,
                'stock' => 50,
                'category_id' => $categories['monitors']->id,
            ],
            [
                'name' => 'LG 27GL850-B',
                'description' => '27-inch QHD gaming monitor with 144Hz refresh rate.',
                'price' => 449.99,
                'stock' => 60,
                'category_id' => $categories['monitors']->id,
            ],
            [
                'name' => 'ASUS ROG Swift PG259QN',
                'description' => '24.5-inch FHD gaming monitor with a 360Hz refresh rate.',
                'price' => 699.99,
                'stock' => 40,
                'category_id' => $categories['monitors']->id,
            ],

            // Headsets
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Industry-leading noise-canceling wireless headphones.',
                'price' => 399.99,
                'stock' => 70,
                'category_id' => $categories['headsets']->id,
            ],
            [
                'name' => 'SteelSeries Arctis Pro',
                'description' => 'High-fidelity gaming headset with a dedicated DAC.',
                'price' => 249.99,
                'stock' => 80,
                'category_id' => $categories['headsets']->id,
            ],
            [
                'name' => 'HyperX Cloud II',
                'description' => 'Comfortable gaming headset with 7.1 surround sound.',
                'price' => 99.99,
                'stock' => 150,
                'category_id' => $categories['headsets']->id,
            ],

            // Webcams
            [
                'name' => 'Logitech C920 HD Pro',
                'description' => 'Full HD 1080p webcam for video calling and streaming.',
                'price' => 79.99,
                'stock' => 180,
                'category_id' => $categories['webcams']->id,
            ],
            [
                'name' => 'Razer Kiyo Pro',
                'description' => 'Webcam with a high-performance adaptive light sensor.',
                'price' => 199.99,
                'stock' => 60,
                'category_id' => $categories['webcams']->id,
            ],

            // Graphics Cards
            [
                'name' => 'NVIDIA GeForce RTX 4090',
                'description' => 'The ultimate GPU for gamers and creators.',
                'price' => 1599.99,
                'stock' => 20,
                'category_id' => $categories['graphics-cards']->id,
            ],
            [
                'name' => 'NVIDIA GeForce RTX 4070',
                'description' => 'High-performance GPU for 1440p gaming.',
                'price' => 599.99,
                'stock' => 50,
                'category_id' => $categories['graphics-cards']->id,
            ],
            [
                'name' => 'AMD Radeon RX 7900 XTX',
                'description' => 'Flagship AMD GPU for 4K gaming.',
                'price' => 999.99,
                'stock' => 30,
                'category_id' => $categories['graphics-cards']->id,
            ],

            // Processors (CPU)
            [
                'name' => 'Intel Core i9-13900K',
                'description' => 'Top-tier CPU for gaming and content creation.',
                'price' => 589.99,
                'stock' => 40,
                'category_id' => $categories['processors-cpu']->id,
            ],
            [
                'name' => 'AMD Ryzen 9 7950X',
                'description' => '16-core CPU for intensive multitasking and gaming.',
                'price' => 699.99,
                'stock' => 35,
                'category_id' => $categories['processors-cpu']->id,
            ],
            [
                'name' => 'Intel Core i5-13600K',
                'description' => 'Excellent mid-range CPU for gaming.',
                'price' => 319.99,
                'stock' => 70,
                'category_id' => $categories['processors-cpu']->id,
            ],

            // Motherboards
            [
                'name' => 'ASUS ROG Maximus Z790 Hero',
                'description' => 'High-end motherboard for Intel 13th Gen CPUs.',
                'price' => 629.99,
                'stock' => 30,
                'category_id' => $categories['motherboards']->id,
            ],
            [
                'name' => 'Gigabyte X670 AORUS Elite AX',
                'description' => 'Feature-rich motherboard for AMD Ryzen 7000 series.',
                'price' => 289.99,
                'stock' => 50,
                'category_id' => $categories['motherboards']->id,
            ],

            // Memory (RAM)
            [
                'name' => 'Corsair Vengeance LPX 32GB (2x16GB) DDR4 3200MHz',
                'description' => 'High-performance RAM for gaming and multitasking.',
                'price' => 99.99,
                'stock' => 100,
                'category_id' => $categories['memory-ram']->id,
            ],
            [
                'name' => 'G.Skill Trident Z5 RGB 32GB (2x16GB) DDR5 6000MHz',
                'description' => 'Blazing fast DDR5 RAM with RGB lighting.',
                'price' => 179.99,
                'stock' => 80,
                'category_id' => $categories['memory-ram']->id,
            ],

            // Storage (SSD, HDD)
            [
                'name' => 'Samsung 980 Pro 1TB NVMe SSD',
                'description' => 'Lightning-fast PCIe 4.0 NVMe SSD.',
                'price' => 129.99,
                'stock' => 150,
                'category_id' => $categories['storage']->id,
            ],
            [
                'name' => 'Crucial MX500 2TB SATA SSD',
                'description' => 'Reliable and spacious SATA SSD.',
                'price' => 149.99,
                'stock' => 120,
                'category_id' => $categories['storage']->id,
            ],
            [
                'name' => 'Seagate BarraCuda 4TB HDD',
                'description' => 'High-capacity hard drive for mass storage.',
                'price' => 89.99,
                'stock' => 200,
                'category_id' => $categories['storage']->id,
            ],

            // Power Supplies (PSU)
            [
                'name' => 'Corsair RM850x 850W 80+ Gold',
                'description' => 'Fully modular PSU with excellent efficiency.',
                'price' => 159.99,
                'stock' => 90,
                'category_id' => $categories['power-supplies']->id,
            ],
            [
                'name' => 'SeaSonic FOCUS Plus Gold 750W',
                'description' => 'Reliable and efficient PSU for most builds.',
                'price' => 129.99,
                'stock' => 100,
                'category_id' => $categories['power-supplies']->id,
            ],

            // PC Cases
            [
                'name' => 'NZXT H5 Flow',
                'description' => 'Compact ATX mid-tower case with a focus on airflow.',
                'price' => 94.99,
                'stock' => 70,
                'category_id' => $categories['pc-cases']->id,
            ],
            [
                'name' => 'Lian Li PC-O11 Dynamic EVO',
                'description' => 'Stunning and versatile mid-tower case.',
                'price' => 169.99,
                'stock' => 60,
                'category_id' => $categories['pc-cases']->id,
            ],

            // Laptops
            [
                'name' => 'MacBook Pro 16-inch',
                'description' => 'The ultimate pro laptop with M3 Max chip.',
                'price' => 3499.99,
                'stock' => 30,
                'category_id' => $categories['laptops']->id,
            ],
            [
                'name' => 'Dell XPS 17',
                'description' => 'A large and powerful laptop for creative work.',
                'price' => 2399.99,
                'stock' => 40,
                'category_id' => $categories['laptops']->id,
            ],
            [
                'name' => 'Razer Blade 15',
                'description' => 'A thin and powerful gaming laptop.',
                'price' => 2499.99,
                'stock' => 35,
                'category_id' => $categories['laptops']->id,
            ],

            // Desktop PCs
            [
                'name' => 'Alienware Aurora R15',
                'description' => 'High-performance pre-built gaming desktop.',
                'price' => 2999.99,
                'stock' => 25,
                'category_id' => $categories['desktop-pcs']->id,
            ],
            [
                'name' => 'HP OMEN 45L',
                'description' => 'Gaming desktop with a unique cooling chamber.',
                'price' => 2199.99,
                'stock' => 30,
                'category_id' => $categories['desktop-pcs']->id,
            ],

            // Gaming Consoles
            [
                'name' => 'PlayStation 5',
                'description' => 'Sony\'s latest generation gaming console.',
                'price' => 499.99,
                'stock' => 100,
                'category_id' => $categories['gaming-consoles']->id,
            ],
            [
                'name' => 'Xbox Series X',
                'description' => 'Microsoft\'s most powerful gaming console.',
                'price' => 499.99,
                'stock' => 90,
                'category_id' => $categories['gaming-consoles']->id,
            ],
            [
                'name' => 'Nintendo Switch - OLED Model',
                'description' => 'Handheld-hybrid console with a vibrant OLED screen.',
                'price' => 349.99,
                'stock' => 120,
                'category_id' => $categories['gaming-consoles']->id,
            ],
            [
                'name' => 'Steam Deck',
                'description' => 'A powerful, portable PC gaming handheld.',
                'price' => 399.00,
                'stock' => 110,
                'category_id' => $categories['gaming-consoles']->id,
            ],

            // More Peripherals
            [
                'name' => 'Elgato Stream Deck MK.2',
                'description' => '15 customizable LCD keys to control apps and tools.',
                'price' => 149.99,
                'stock' => 80,
                'category_id' => $categories['keyboards']->id,
            ],
            [
                'name' => 'Wacom Intuos Pro',
                'description' => 'Professional creative pen tablet.',
                'price' => 379.95,
                'stock' => 50,
                'category_id' => $categories['mice']->id,
            ],
            [
                'name' => 'BenQ PD3200U',
                'description' => '32-inch 4K monitor for designers.',
                'price' => 699.99,
                'stock' => 40,
                'category_id' => $categories['monitors']->id,
            ],
            [
                'name' => 'Shure SM7B',
                'description' => 'Legendary vocal microphone for streaming and recording.',
                'price' => 399.00,
                'stock' => 60,
                'category_id' => $categories['headsets']->id,
            ],

            // More Components
            [
                'name' => 'AMD Ryzen 7 7800X3D',
                'description' => 'The fastest gaming CPU on the market.',
                'price' => 449.00,
                'stock' => 60,
                'category_id' => $categories['processors-cpu']->id,
            ],
            [
                'name' => 'MSI MAG B650 TOMAHAWK WIFI',
                'description' => 'A popular and reliable motherboard for AMD Ryzen 7000.',
                'price' => 219.99,
                'stock' => 70,
                'category_id' => $categories['motherboards']->id,
            ],
            [
                'name' => 'Samsung 970 EVO Plus 2TB',
                'description' => 'A very popular and reliable NVMe SSD.',
                'price' => 119.99,
                'stock' => 130,
                'category_id' => $categories['storage']->id,
            ],
            [
                'name' => 'be quiet! Dark Power Pro 12 1200W',
                'description' => 'An ultra-quiet, high-performance PSU.',
                'price' => 399.90,
                'stock' => 40,
                'category_id' => $categories['power-supplies']->id,
            ],
            [
                'name' => 'Fractal Design Meshify 2',
                'description' => 'A high-airflow case with a clean aesthetic.',
                'price' => 159.99,
                'stock' => 65,
                'category_id' => $categories['pc-cases']->id,
            ],
        ];

        foreach ($products as $index => $productData) {
            $product = Product::create($productData);
            $product->image = 'product-image-' . ($index + 1) . '.jpeg'; // Assuming images are .jpeg and start from 1
            $product->save();
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            SecurityQuestionSeeder::class,
            CategorySeeder::class,
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $managerRole = Role::where('name', 'manager')->first();
        $customerRole = Role::where('name', 'customer')->first();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role_id' => $adminRole->id,
        ]);

        User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => bcrypt('manager123'),
            'role_id' => $managerRole->id,
        ]);

        User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => bcrypt('customer123'),
            'role_id' => $customerRole->id,
        ]);

        User::factory(15)->create([
            'role_id' => $customerRole->id,
        ]);

        // Create 10 random customers
        $this->call([
            ProductSeeder::class,
            OrderSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Models\Category;
Use App\Models\Brand;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => ' admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin')
        ]);

        $categories = [
            ['name' => 'fruits'],
            ['name' => 'vegetables']
        ];

        foreach($categories as $row)
        {
            Category::create($row);
        }

        $brands = [
            ['name' => 'hp'],
            ['name' => 'dell']
        ];
        
        foreach($brands as $row)
        {
            Brand::create($row);
        }
    }

}

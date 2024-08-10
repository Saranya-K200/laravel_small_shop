<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Models\Category;
Use App\Models\Brand;
use App\Models\Product;
use App\Models\Cart;

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

        $products =[
            [
                'category_id' => 2,
                'brand_id' => 1,
                'name' => 'Tomato',
                'price' => '10',
                'qty' => '900',
                'alert_stock' => '100'
            ],
            [
                'category_id' => 2,
                'brand_id' => 1,
                'name' => 'potato',
                'price' => '12',
                'qty' => '800',
                'alert_stock' => '100'
            ],
            [
                'category_id' => 2,
                'brand_id' => 1,
                'name' => 'carrot',
                'price' => '20',
                'qty' => '1000',
                'alert_stock' => '200'
            ],
        ];

        foreach($products as $row)
        {
            Product::create($row);
        }

        $carts = [
            [
                 'product_id'=>2,
                 'customer_id'=>1,
                 'qty'=>10 
            ]   
        ];

        foreach($carts as $row)
        {
            cart::create($row);
        }

    }

}

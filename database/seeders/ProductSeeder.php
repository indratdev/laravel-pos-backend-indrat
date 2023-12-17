<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::factory(10)->create();

        \App\Models\Product::factory()->create([
            'name' => 'Kopi',
            'description' => '',
            'price' => '10000',
            'stock' => '10',
            'category' => 'drink',
            'image' => '',
        ]);


    }
}

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
        // \App\Models\Product::factory(10)->create();
        // \App\Models\Product::factory()->create([
        //     'name' => 'Cuci & Lipat',
        //     'description' => '',
        //     'price' => '10000',
        //     'working_time' => '1',
        //     'category' => 'kiloan',
        //     'image' => '',
        // ]);

        $productsData = [
            [
                'name' => 'Cuci & Lipat',
                'description' => '',
                'price' => 10000,
                'working_time' => 1,
                'category' => 'kiloan',
                'image' => 'https://via.placeholder.com/640x480.png/009900?text=architecto',
            ],
            [
                'name' => 'Cuci & Seterika Uap',
                'description' => '',
                'price' => 12000,
                'working_time' => 1,
                'category' => 'kiloan',
                'image' => 'https://via.placeholder.com/640x480.png/009900?text=architecto',
            ],
            [
                'name' => 'Handuk & Keset',
                'description' => '',
                'price' => 5000,
                'working_time' => 1,
                'category' => 'satuan',
                'image' => 'https://via.placeholder.com/640x480.png/009900?text=architecto',
            ],
            [
                'name' => 'Jacket Bahan',
                'description' => '',
                'price' => 15000,
                'working_time' => 1,
                'category' => 'satuan',
                'image' => 'https://via.placeholder.com/640x480.png/009900?text=architecto',
            ],
            // Add more data as needed
        ];

        foreach ($productsData as $data) {
            \App\Models\Product::factory()->create($data);
        }
    }
}

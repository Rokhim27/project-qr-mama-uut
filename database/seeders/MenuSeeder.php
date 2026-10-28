<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            [
                'category' => 'Makanan',
                'name' => 'Nasi Goreng',
                'description' => 'Nasi goreng spesial',
                'price' => 15000,
            ],
            [
                'category' => 'Makanan',
                'name' => 'Mie Goreng',
                'description' => 'Mie goreng spesial',
                'price' => 13000,
            ],
            [
                'category' => 'Minuman',
                'name' => 'Es Teh',
                'description' => 'Teh dingin menyegarkan',
                'price' => 5000,
            ],
            [
                'category' => 'Minuman',
                'name' => 'Es Jeruk',
                'description' => 'Jeruk segar dingin',
                'price' => 7000,
            ],
            [
                'category' => 'Camilan',
                'name' => 'Kentang Goreng',
                'description' => 'Kentang goreng renyah',
                'price' => 10000,
            ],
        ];

        foreach ($menus as $item) {
            $category = Category::where(
                'slug',
                Str::slug($item['category'])
            )->firstOrFail();

            Menu::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'image' => null,
                    'is_available' => true,
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Makanan',
                'description' => 'Kategori makanan',
            ],
            [
                'name' => 'Minuman',
                'description' => 'Kategori minuman',
            ],
            [
                'name' => 'Camilan',
                'description' => 'Kategori camilan',
            ],
        ];

        foreach ($categories as $item) {
            $slug = Str::slug($item['name']);

            Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}

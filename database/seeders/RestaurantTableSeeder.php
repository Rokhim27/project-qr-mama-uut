<?php

namespace Database\Seeders;

use App\Models\RestaurantTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RestaurantTableSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $tableNumber = sprintf('Meja %02d', $i);

            RestaurantTable::firstOrCreate(
                ['table_number' => $tableNumber],
                [
                    'qr_token' => (string) Str::uuid(),
                    'is_active' => true,
                ]
            );
        }
    }
}

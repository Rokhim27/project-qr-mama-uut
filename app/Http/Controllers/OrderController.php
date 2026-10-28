<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function store(Request $request, string $token)
    {
        $table = RestaurantTable::where('qr_token', $token)
            ->where('is_active', true)
            ->firstOrFail();

        $validated = $request->validate([
            'customer_name' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.menu_id' => ['required', 'integer', 'distinct'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $order = DB::transaction(function () use ($validated, $table) {
            $quantities = collect($validated['items'])
                ->pluck('quantity', 'menu_id');

            $menus = Menu::whereIn('id', $quantities->keys())
                ->where('is_available', true)
                ->get()
                ->keyBy('id');

            if ($menus->count() !== $quantities->count()) {
                throw ValidationException::withMessages([
                    'items' => 'Ada menu yang tidak tersedia atau tidak ditemukan.',
                ]);
            }

            $order = Order::create([
                'restaurant_table_id' => $table->id,
                'order_number' => 'ORD-' . Str::upper(Str::random(12)),
                'customer_name' => $validated['customer_name'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'total_amount' => 0,
                'status' => 'pending',
            ]);

            $total = 0;

            foreach ($quantities as $menuId => $quantity) {
                $menu = $menus->get($menuId);
                $price = (float) $menu->price;
                $subtotal = round($price * (int) $quantity, 2);

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'quantity' => (int) $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $order->update([
                'total_amount' => $total,
            ]);

            return $order;
        });

        return response()->json([
            'message' => 'Pesanan berhasil dibuat.',
            'order' => $order->load('orderItems.menu'),
        ], 201);
    }
}

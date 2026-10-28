<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function dashboard(): View
{
    $totalOrders = Order::count();

    $newOrders = Order::where('status', 'pending')->count();

    $completedOrders = Order::where('status', 'completed')->count();

    $recentOrders = Order::with('restaurantTable')
        ->latest()
        ->take(5)
        ->get();

    return view('admin.dashboard', compact(
        'totalOrders',
        'newOrders',
        'completedOrders',
        'recentOrders'
    ));
}
    public function index(): View
    {
        $orders = Order::with(['restaurantTable', 'orderItems.menu'])
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'confirmed',
                    'preparing',
                    'completed',
                    'cancelled',
                ]),
            ],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}

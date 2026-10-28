<?php

namespace App\Http\Controllers;

use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class QrMenuController extends Controller
{
    public function show(string $token)
    {
        $table = RestaurantTable::where('qr_token', $token)
            ->where('is_active', true)
            ->firstOrFail();

        $categories = \App\Models\Category::where('is_active', true)
            ->with(['menus' => function ($query) {
                $query->where('is_available', true)
                    ->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        return view('qr.menu', compact('table', 'categories'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\RestaurantTable;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->with(['menus' => function ($query) {
                $query->where('is_available', true)
                    ->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        $table = RestaurantTable::where('is_active', true)
            ->orderBy('id')
            ->first();

        return view('menus.index', compact('categories', 'table'));
    }

    public function show(Menu $menu)
    {
        abort_unless($menu->is_available, 404);

        $menu->load('category');

        return view('menus.show', compact('menu'));
    }
}

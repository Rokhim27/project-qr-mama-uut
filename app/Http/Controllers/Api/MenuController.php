<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    /**
     * Menampilkan kategori aktif dan menu yang tersedia.
     */
    public function index(): JsonResponse
    {
        $categories = Category::where('is_active', true)
            ->with([
                'menus' => function ($query) {
                    $query->where('is_available', true)
                        ->orderBy('name')
                        ->select([
                            'id',
                            'category_id',
                            'name',
                            'slug',
                            'description',
                            'price',
                            'image',
                            'is_available',
                        ]);
                },
            ])
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'slug',
                'description',
                'is_active',
            ]);

        return response()->json([
            'message' => 'Daftar menu berhasil diambil.',
            'data' => $categories,
        ]);
    }

    /**
     * Menampilkan detail satu menu.
     */
    public function show(Menu $menu): JsonResponse
    {
        if (
            !$menu->is_available ||
            !$menu->category ||
            !$menu->category->is_active
        ) {
            return response()->json([
                'message' => 'Menu tidak ditemukan atau tidak tersedia.',
            ], 404);
        }

        $menu->load('category');

        return response()->json([
            'message' => 'Detail menu berhasil diambil.',
            'data' => $menu,
        ]);
    }

    /**
     * Menambahkan menu baru.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:menus,slug',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'image' => [
                'nullable',
                'string',
                'max:255',
            ],
            'is_available' => [
                'sometimes',
                'boolean',
            ],
        ]);

        $category = Category::findOrFail(
            $validated['category_id']
        );

        if (!$category->is_active) {
            return response()->json([
                'message' => 'Kategori tidak aktif.',
            ], 422);
        }

        $menu = Menu::create($validated);

        return response()->json([
            'message' => 'Menu berhasil ditambahkan.',
            'data' => $menu,
        ], 201);
    }

    /**
     * Memperbarui data menu.
     */
    public function update(
        Request $request,
        Menu $menu
    ): JsonResponse {
        $validated = $request->validate([
            'category_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:categories,id',
            ],
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],
            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('menus', 'slug')->ignore($menu->id),
            ],
            'description' => [
                'sometimes',
                'nullable',
                'string',
            ],
            'price' => [
                'sometimes',
                'required',
                'numeric',
                'min:0',
            ],
            'image' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],
            'is_available' => [
                'sometimes',
                'required',
                'boolean',
            ],
        ]);

        $menu->update($validated);
        $menu->refresh();

        return response()->json([
            'message' => 'Menu berhasil diperbarui.',
            'data' => $menu,
        ]);
    }

    /**
     * Menghapus menu jika belum digunakan dalam pesanan.
     */
    public function destroy(Menu $menu): JsonResponse
    {
        try {
            if ($menu->orderItems()->exists()) {
                return response()->json([
                    'message' =>
                        'Menu tidak dapat dihapus karena sudah digunakan dalam pesanan.',
                ], 409);
            }

            $menu->delete();

            return response()->json([
                'message' => 'Menu berhasil dihapus.',
            ]);
        } catch (QueryException $e) {
            if (($e->errorInfo[1] ?? null) === 1451) {
                return response()->json([
                    'message' =>
                        'Menu tidak dapat dihapus karena masih digunakan oleh data lain.',
                ], 409);
            }

            throw $e;
        }
    }
}

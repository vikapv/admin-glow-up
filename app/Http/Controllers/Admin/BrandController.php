<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BrandController extends Controller
{
    // Используется только чтобы дотянуть товары/заказы по бренду из внешнего сервиса
    private string $api = 'http://127.0.0.1:8001/api';

    public function index(Request $request)
    {
        $query = Brand::with('partner');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $brands = $query->latest()->paginate(12)->withQueryString();

        $stats = [
            'total'     => Brand::count(),
            'with_logo' => Brand::whereNotNull('logo')->where('logo', '!=', '')->count(),
        ];

        return view('admin.brands.index', [
            'brands' => $brands,
            'stats'  => $stats,
        ]);
    }

    public function show($id)
    {
        $brand = Brand::with('partner')->findOrFail($id);

        // Товары/заказы/выручка по-прежнему берём из внешнего сервиса,
        // фильтруя по имени бренда (или замените на ID, если внешний API его поддерживает)
        $response = Http::get("{$this->api}/products", [
            'brand' => $brand->name,
        ]);
        $json = $response->successful() ? $response->json() : [];

        $products = collect($json['products'] ?? [])->map(fn($p) => (object) $p);

        $ordersCount = $json['stats']['orders_count'] ?? 0;
        $totalSum    = $json['stats']['total_sum'] ?? 0;
        $avgPrice    = $products->count() > 0
            ? $products->avg('price')
            : 0;

        $brandStats = [
            'products_count' => $products->count(),
            'orders_count'   => $ordersCount,
            'total_sum'      => $totalSum,
            'avg_price'      => $avgPrice,
        ];

        // Показываем максимум 6 товаров на странице бренда (как в Blade)
        $products = $products->take(6);

        return view('admin.brands.show', compact('brand', 'brandStats', 'products'));
    }
}
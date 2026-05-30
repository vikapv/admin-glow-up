<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::withCount('partner')
            ->with('partner');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $brands = $query->latest()->paginate(12);

        $stats = [
            'total'    => Brand::count(),
            'with_logo' => Brand::whereNotNull('logo')->count(),
        ];

        return view('admin.brands.index', compact('brands', 'stats'));
    }

    public function show(Brand $brand)
    {
        $brand->load('partner');

        // статистика бренда
        $brandStats = [
            'products_count' => Product::where('brand', $brand->name)->count(),
            'orders_count'   => OrderItem::where('brand', $brand->name)
                                    ->distinct('order_id')->count('order_id'),
            'total_sum'      => OrderItem::where('brand', $brand->name)
                                    ->sum(DB::raw('price * quantity')),
            'avg_price'      => round(Product::where('brand', $brand->name)->avg('price')),
        ];

        // последние товары бренда
        $products = Product::where('brand', $brand->name)
            ->withCount('reviews')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.brands.show', compact('brand', 'brandStats', 'products'));
    }
}
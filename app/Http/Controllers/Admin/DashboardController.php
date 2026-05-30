<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::query();

        // 🔎 поиск бренда
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $brands = $query->get();

        $data = [];

        foreach ($brands as $brand) {

            $productsQuery = Product::where('brand', $brand->name);
            $orderItemsQuery = OrderItem::where('brand', $brand->name);

            $data[] = [
                'brand' => $brand->name,

                'products_count' => $productsQuery->count(),

                'orders_count' => $orderItemsQuery
                    ->distinct('order_id')
                    ->count('order_id'),

                'total_sum' => $orderItemsQuery
                    ->sum(DB::raw('price * quantity')),

                'average_price' => $productsQuery->avg('price'),
            ];
        }

        return view('admin.dashboard', compact('data'));
    }
}
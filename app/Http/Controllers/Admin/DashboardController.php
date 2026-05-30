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
    $brands = Brand::all();

    $selectedBrand = $request->brand;

    $stats = null;

    if ($selectedBrand) {

        $productsQuery = Product::where('brand', $selectedBrand);

        $orderItemsQuery = OrderItem::where('brand', $selectedBrand);

        $stats = [
            'products_count' => $productsQuery->count(),
            'orders_count' => $orderItemsQuery->distinct('order_id')->count('order_id'),
            'total_sum' => $orderItemsQuery->sum(DB::raw('price * quantity')),
            'average_price' => $productsQuery->avg('price'),
        ];
    }

    return view('admin.dashboard', [
        'brands' => $brands,          
        'stats' => $stats,
        'selectedBrand' => $selectedBrand
    ]);
}
}
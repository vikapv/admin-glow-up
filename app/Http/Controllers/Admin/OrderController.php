<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::all();

        $query = Order::with('items');

        // фильтр по бренду
        if ($request->brand) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('brand', $request->brand);
            });
        }

        $orders = $query->latest()->get();

        // 📊 аналитика
        $stats = [
            'total_orders' => Order::count(),
            'total_sum' => OrderItem::sum(DB::raw('price * quantity')),
            'total_items' => OrderItem::sum('quantity'),
            'avg_order' => Order::avg('total_price'),
        ];

        return view('admin.orders.index', compact('orders', 'brands', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load('items');

        return view('admin.orders.show', compact('order'));
    }
}
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

        // фильтр по статусу
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // поиск по номеру заказа
        if ($request->search) {
            $query->where('id', 'like', '%' . $request->search . '%');
        }

        $orders = $query->latest()->paginate(15);

        $stats = [
            'total_orders' => Order::count(),
            'total_sum'    => OrderItem::sum(DB::raw('price * quantity')),
            'total_items'  => OrderItem::sum('quantity'),
            'avg_order'    => Order::avg('total_price'),
            'processing'   => Order::where('status', 'processing')->count(),
            'completed'    => Order::where('status', 'completed')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'brands', 'stats'));
    }

    public function show(Order $order)
{
    $order->load('items', 'user'); 
    return view('admin.orders.show', compact('order'));
}

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:processing,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Статус заказа #' . $order->id . ' обновлён');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\AdminUser;
use App\Models\PartnerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Глобальные метрики
        $globalStats = [
            'total_orders'     => Order::count(),
            'total_revenue'    => OrderItem::sum(DB::raw('price * quantity')),
            'total_users'      => AdminUser::count(),
            'pending_partners' => PartnerRequest::where('status', 'pending')->count(),
        ];

        // Последние 5 заказов
        $recentOrders = Order::with('items')->latest()->take(5)->get();

        // Ожидающие заявки партнёров
        $pendingPartners = PartnerRequest::where('status', 'pending')
            ->latest()->take(5)->get();

        // Аналитика по брендам (с поиском)
        $query = Brand::query();
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $brands = $query->get();

        $data = [];
        foreach ($brands as $brand) {
            $productsQuery   = Product::where('brand', $brand->name);
            $orderItemsQuery = OrderItem::where('brand', $brand->name);

            $data[] = [
                'brand'          => $brand->name,
                'logo'           => $brand->logo,
                'products_count' => $productsQuery->count(),
                'orders_count'   => (clone $orderItemsQuery)->distinct('order_id')->count('order_id'),
                'total_sum'      => (clone $orderItemsQuery)->sum(DB::raw('price * quantity')),
                'average_price'  => $productsQuery->avg('price'),
            ];
        }

        return view('admin.dashboard', compact(
            'globalStats',
            'recentOrders',
            'pendingPartners',
            'data'
        ));
    }
}
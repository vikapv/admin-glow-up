<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use App\Models\Brand;
use App\Models\PartnerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ГЛОБАЛЬНАЯ СТАТИСТИКА
        $globalStats = [
            'total_orders'     => Order::count(),
            'total_revenue'    => OrderItem::sum(DB::raw('price * quantity')),
            'total_users'      => User::count(),
            'pending_partners' => PartnerRequest::where('status', 'pending')->count(),
        ];

        // ПОСЛЕДНИЕ ЗАКАЗЫ
        $recentOrders = Order::with('items')
            ->latest()
            ->take(5)
            ->get();

        // ОЖИДАЮЩИЕ ЗАЯВКИ ПАРТНЁРОВ
        $pendingPartners = PartnerRequest::where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // ПОИСК ПО БРЕНДАМ (одобренные партнёры = PartnerRequest со статусом approved)
        $search = $request->input('search');

        $partnersQuery = PartnerRequest::where('status', 'approved');
        if ($search) {
            $partnersQuery->where('name', 'like', '%' . $search . '%');
        }
        $approvedPartners = $partnersQuery->get();

        // АНАЛИТИКА БРЕНДОВ
        $data = [];

        foreach ($approvedPartners as $partner) {
            $name = $partner->name;

            $productsCount = Product::where('brand', $name)->count();
            $avgPrice      = Product::where('brand', $name)->avg('price') ?? 0;

            $totalSum = OrderItem::where('brand', $name)
                ->sum(DB::raw('price * quantity'));

            $ordersCount = OrderItem::where('brand', $name)
                ->distinct('order_id')
                ->count('order_id');

            $data[] = [
                'id'             => $partner->id,
                'brand'          => $name,
                'logo'           => $partner->logo,
                'products_count' => $productsCount,
                'orders_count'   => $ordersCount,
                'total_sum'      => $totalSum,
                'average_price'  => round($avgPrice),
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
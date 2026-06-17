<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    private string $apiBase = 'http://127.0.0.1:8001/api';


    public function index(Request $request)
    {

        // API данные

        $partnersResponse = Http::get("{$this->apiBase}/partners")->json();

        $partnerReqs = Http::get(
            "{$this->apiBase}/admin/partner-requests"
        )->json() ?? [];


        $products = Http::get(
            "{$this->apiBase}/products"
        )->json() ?? [];


        $orders = Http::get(
            "{$this->apiBase}/orders"
        )->json() ?? [];



        // пользователи

        $users = Http::get(
            "{$this->apiBase}/users"
        )->json() ?? [];




        // нормализация


        $partnersList =
            $partnersResponse['partners'] ?? [];


        $partnerReqsList =
            $partnerReqs['data'] ?? $partnerReqs;


        $productsList =
            $products['data'] ?? $products;


        $ordersList =
            $orders['data'] ?? $orders;


        $usersList =
            $users['data'] ?? $users;




        // ======================
        // СТАТИСТИКА
        // ======================


        $globalStats = [

            'total_orders' => count($ordersList),


            'total_revenue' =>
                collect($ordersList)
                ->sum('total_price'),


            'total_users' =>
                count($usersList),


            'pending_partners' =>
                collect($partnerReqsList)
                ->where('status','pending')
                ->count(),

        ];





        // последние заказы


        $recentOrders = collect($ordersList)

            ->sortByDesc('created_at')

            ->take(5)

            ->values();





        // заявки партнеров


        $pendingPartners = collect($partnerReqsList)

            ->where('status','pending')

            ->sortByDesc('created_at')

            ->take(5)

            ->values();







        // поиск


        $search = $request->input('search');


        if($search){

            $partnersList = array_filter(
                $partnersList,

                fn($p)=>

                str_contains(
                    strtolower($p['name'] ?? ''),
                    strtolower($search)
                )

            );

        }





        // аналитика брендов


        $data=[];


        foreach($partnersList as $partner){


            $name=$partner['name'] ?? '';



            $brandProducts = collect($productsList)

                ->filter(fn($p)=>

                    ($p['brand'] ?? '') === $name

                );





            $brandOrders = collect($ordersList)

                ->filter(function($order) use ($name){


                    return collect(
                        $order['items'] ?? []
                    )

                    ->contains(fn($item)=>

                        ($item['brand'] ?? '') === $name

                    );


                });





            $totalSum = collect($ordersList)

                ->flatMap(fn($o)=>

                    $o['items'] ?? []

                )

                ->filter(fn($item)=>

                    ($item['brand'] ?? '') === $name

                )

                ->sum(fn($item)=>

                    ($item['price'] ?? 0)
                    *
                    ($item['quantity'] ?? 1)

                );





            $data[]=[


                'id'=>$partner['id'],

                'brand'=>$name,

                'logo'=>$partner['logo'] ?? null,


                'products_count'=>
                    $brandProducts->count(),


                'orders_count'=>
                    $brandOrders->count(),


                'total_sum'=>
                    $totalSum,


                'average_price'=>
                    $brandProducts->avg('price') ?? 0,


            ];

        }





        return view(
            'admin.dashboard',
            compact(
                'globalStats',
                'recentOrders',
                'pendingPartners',
                'data'
            )
        );

    }

}
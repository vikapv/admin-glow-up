<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandController extends Controller
{
    private string $api = 'http://127.0.0.1:8001/api';

    public function index(Request $request)
    {
        $response = Http::get("{$this->api}/brands");
        $json     = $response->json();

        $allBrands = collect($json['brands'] ?? [])
            ->map(fn($b) => (object)$b);

        if ($request->search) {
            $allBrands = $allBrands->filter(fn($b) =>
                str_contains(
                    mb_strtolower($b->name),
                    mb_strtolower($request->search)
                )
            );
        }

        $stats = $json['stats'] ?? [
            'total' => 0,
            'with_logo' => 0,
        ];

        $perPage = 12;
        $currentPage = (int)($request->page ?? 1);

        $paginated = new LengthAwarePaginator(
            $allBrands->values()->slice(
                ($currentPage - 1) * $perPage,
                $perPage
            )->values(),
            $allBrands->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('admin.brands.index', [
            'brands' => $paginated,
            'stats' => $stats,
        ]);
    }

    public function show($id)
    {
        $response = Http::get("{$this->api}/brands/{$id}");
        $json = $response->json();

        $brand = (object)($json['brand'] ?? []);

        $brandStats = $json['stats'] ?? [
            'products_count' => 0,
            'orders_count' => 0,
            'total_sum' => 0,
            'avg_price' => 0,
        ];

        $products = collect($json['products'] ?? [])
            ->map(fn($p) => (object)$p);

        return view('admin.brands.show', compact(
            'brand',
            'brandStats',
            'products'
        ));
    }
}
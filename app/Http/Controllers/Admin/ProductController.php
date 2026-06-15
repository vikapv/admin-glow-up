<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::get('http://127.0.0.1:8001/api/products', [
            'search'   => $request->search,
            'brand'    => $request->brand,
            'category' => $request->category,
            'sort'     => $request->sort,
        ]);

        // Приводим каждый элемент к объекту
        $allProducts = collect($response->json())->map(fn($p) => (object)$p);

        // Фильтрация — обращаемся через -> (объекты)
        if ($request->search) {
            $allProducts = $allProducts->filter(fn($p) =>
                str_contains(mb_strtolower($p->title), mb_strtolower($request->search))
            );
        }
        if ($request->brand) {
            $allProducts = $allProducts->filter(fn($p) => $p->brand === $request->brand);
        }
        if ($request->category) {
            $allProducts = $allProducts->filter(fn($p) => $p->category === $request->category);
        }

        // Сортировка
        $allProducts = match($request->sort) {
            'price_asc'  => $allProducts->sortBy('final_price'),
            'price_desc' => $allProducts->sortByDesc('final_price'),
            default      => $allProducts,
        };

        // Статистика — тоже через ->
        $stats = [
            'total'         => $allProducts->count(),
            'with_discount' => $allProducts->filter(fn($p) => $p->discount > 0)->count(),
            'avg_price'     => $allProducts->avg(fn($p) => $p->final_price) ?? 0,
            'total_reviews' => 0,
        ];

        // Бренды и категории для фильтров
        $brands = $allProducts
            ->map(fn($p) => $p->brand)
            ->unique()->sort()->values()
            ->map(fn($b) => (object)['name' => $b]);

        $categories = $allProducts
            ->map(fn($p) => $p->category)
            ->unique()->sort()->values()
            ->map(fn($c) => (object)['name' => $c]);

        // Ручная пагинация
        $perPage     = 12;
        $currentPage = (int)($request->page ?? 1);
        $paginated   = new LengthAwarePaginator(
            $allProducts->values()->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $allProducts->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.products.index', [
            'products'   => $paginated,
            'brands'     => $brands,
            'categories' => $categories,
            'stats'      => $stats,
        ]);
    }

    public function show(Product $product)
    {
        $product->load('reviews');
        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        if ($product->image && Storage::exists($product->image)) {
            Storage::delete($product->image);
        }
        $product->delete();
        return redirect()->back()
            ->with('success', 'Товар «' . $product->title . '» удалён');
    }
}
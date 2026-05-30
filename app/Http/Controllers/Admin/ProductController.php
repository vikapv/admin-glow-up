<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $brands     = Brand::all();
        $categories = Category::all();
        $brandNames = $brands->pluck('name');

        $query = Product::withCount('reviews')
            ->whereIn('brand', $brandNames);

        if ($request->brand) {
            $query->where('brand', $request->brand);
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // сортировка
        match($request->sort ?? '') {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'reviews'    => $query->orderByDesc('reviews_count'),
            default      => $query->latest(),
        };

        $products = $query->paginate(12);

        $stats = [
            'total'          => Product::whereIn('brand', $brandNames)->count(),
            'with_discount'  => Product::whereIn('brand', $brandNames)
                                    ->whereNotNull('discount')
                                    ->where('discount', '!=', '')
                                    ->count(),
            'avg_price'      => round(Product::whereIn('brand', $brandNames)->avg('price')),
            'total_reviews'  => Product::whereIn('brand', $brandNames)
                                    ->withCount('reviews')
                                    ->get()
                                    ->sum('reviews_count'),
        ];

        return view('admin.products.index', compact(
            'products', 'brands', 'categories', 'stats'
        ));
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
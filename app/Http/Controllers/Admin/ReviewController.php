<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::all();
        $brandNames = $brands->pluck('name');

        $query = Product::withCount('reviews')
            ->has('reviews')
            ->whereIn('brand', $brandNames);

        if ($request->brand) {
            $query->where('brand', $request->brand);
        }

        // поиск по названию товара
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // сортировка — сначала с наибольшим числом отзывов
        $products = $query->orderByDesc('reviews_count')->paginate(12);

        // общая статистика
        $stats = [
            'total_reviews'   => Review::count(),
            'total_products'  => Product::has('reviews')->count(),
            'avg_per_product' => round(Review::count() / max(Product::has('reviews')->count(), 1), 1),
        ];

        return view('admin.reviews.index', compact('products', 'brands', 'stats'));
    }

    public function show(Product $product)
    {
        $product->load('reviews');
        return view('admin.reviews.show', compact('product'));
    }

    public function destroy(Review $review)
    {
        $productId = $review->product_id;
        $review->delete();
        return back()->with('success', 'Отзыв удалён');
    }
}
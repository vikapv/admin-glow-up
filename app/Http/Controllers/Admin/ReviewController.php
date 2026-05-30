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

    $products = Product::withCount('reviews')
        ->has('reviews')
        ->whereIn('brand', $brandNames);

    if ($request->brand) {
        $products->where('brand', $request->brand);
    }

    $products = $products->get();

    return view('admin.reviews.index', compact(
        'products',
        'brands'
    ));
}

    public function show(Product $product)
    {
        $product->load('reviews');

        return view('admin.reviews.show', compact('product'));
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with(
            'success',
            'Отзыв удалён'
        );
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $brands = \App\Models\Brand::all();

    $query = Product::query();

    // ФИЛЬТР ПО БРЕНДУ
    if ($request->brand) {
        $query->where('brand', $request->brand);
    }

    $products = $query->get();

    return view('admin.products.index', compact('products', 'brands'));
}

    
}

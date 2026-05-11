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
    $brands = Brand::all();

    // берём названия существующих брендов
    $brandNames = $brands->pluck('name');

    // показываем товары только существующих брендов
    $query = Product::whereIn('brand', $brandNames);

    // фильтр
    if ($request->brand) {
        $query->where('brand', $request->brand);
    }

    $products = $query->get();

    return view('admin.products.index', compact('products', 'brands'));
}

    public function destroy(Product $product)
{
    // удалить фото если есть
    if ($product->image && Storage::exists($product->image)) {
        Storage::delete($product->image);
    }

    $product->delete();

    return redirect()->back();
}
    
}

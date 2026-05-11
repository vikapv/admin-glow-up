<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // список брендов (только approved если нужно)
    public function index(Request $request)
    {
        $query = Brand::query();

        // ПОИСК
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $brands = $query->get();

        return view('admin.brands.index', compact('brands'));
    }

    // 👇 ВОТ ЭТОГО У ТЕБЯ НЕ ХВАТАЛО
    public function show(Brand $brand)
    {
        return view('admin.brands.show', compact('brand'));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;

class BrandController extends Controller
{
    // список брендов (только approved если нужно)
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    // 👇 ВОТ ЭТОГО У ТЕБЯ НЕ ХВАТАЛО
    public function show(Brand $brand)
    {
        return view('admin.brands.show', compact('brand'));
    }
}
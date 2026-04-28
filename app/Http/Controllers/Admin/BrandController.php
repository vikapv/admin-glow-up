<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
{
    $brands = Brand::with('partner')
        ->get()
        ->filter(function ($brand) {
            return $brand->partner && $brand->partner->status === 'approved';
        });

    return view('admin.brands.index', compact('brands'));
}
}
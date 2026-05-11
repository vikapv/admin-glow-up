<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Http\Requests\PromoCodeRequest;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promos = PromoCode::all();
        return view('admin.promocodes.index', compact('promos'));
    }

    public function store(PromoCodeRequest $request)
{
    PromoCode::create([
        'code' => strtoupper($request->code), 
        'discount' => $request->discount,
        'limit' => $request->limit,
        'is_active' => true,
    ]);

    return redirect()->back()->with('success', 'Промокод добавлен');
}

    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();

        return redirect()->back();
    }
}
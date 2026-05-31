<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Http\Requests\PromoCodeRequest;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promos = PromoCode::latest()->paginate(15);

        $stats = [
            'total'    => PromoCode::count(),
            'active'   => PromoCode::where('is_active', true)->count(),
            'inactive' => PromoCode::where('is_active', false)->count(),
        ];

        return view('admin.promocodes.index', compact('promos', 'stats'));
    }

    public function store(PromoCodeRequest $request)
    {
        // проверяем что такой код ещё не существует
        if (PromoCode::where('code', strtoupper($request->code))->exists()) {
            return redirect()->back()
                ->withErrors(['code' => 'Промокод с таким кодом уже существует'])
                ->withInput();
        }

        PromoCode::create([
            'code'      => strtoupper($request->code),
            'discount'  => $request->discount,
            'limit'     => $request->limit ?: null,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Промокод «' . strtoupper($request->code) . '» добавлен');
    }

    public function toggleActive(PromoCode $promoCode)
    {
        $promoCode->update(['is_active' => !$promoCode->is_active]);

        $status = $promoCode->is_active ? 'активирован' : 'отключён';

        return redirect()->back()->with('success', 'Промокод «' . $promoCode->code . '» ' . $status);
    }

    public function destroy(PromoCode $promoCode)
    {
        $code = $promoCode->code;
        $promoCode->delete();

        return redirect()->back()->with('success', 'Промокод «' . $code . '» удалён');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Http\Requests\PromotionRequest;
use App\Models\Category;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->paginate(10);

        $stats = [
            'total'        => Promotion::count(),
            'max_discount' => Promotion::max('discount') ?? 0,
            'avg_discount' => round(Promotion::avg('discount') ?? 0),
        ];

        return view('admin.promotions.index', compact('promotions', 'stats'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.promotions.create', compact('categories'));
    }

    public function store(PromotionRequest $request)
    {
        Promotion::create($request->validated());

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Акция «' . $request->title . '» добавлена');
    }

    public function edit(Promotion $promotion)
    {
        $categories = Category::all();

        return view('admin.promotions.edit', compact(
            'promotion',
            'categories'
        ));
    }

    public function update(PromotionRequest $request, Promotion $promotion)
    {
        $promotion->update($request->validated());

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Акция «' . $promotion->title . '» обновлена');
    }

    public function destroy(Promotion $promotion)
    {
        $title = $promotion->title;
        $promotion->delete();

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Акция «' . $title . '» удалена');
    }
}
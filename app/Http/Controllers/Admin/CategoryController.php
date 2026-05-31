<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('products');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate(20);

        $stats = [
            'total'        => Category::count(),
            'with_products' => Category::has('products')->count(),
            'empty'        => Category::doesntHave('products')->count(),
        ];

        return view('admin.categories.index', compact('categories', 'stats'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ], [
            'name.unique' => 'Категория с таким названием уже существует'
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория «' . $request->name . '» добавлена');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id
        ], [
            'name.unique' => 'Категория с таким названием уже существует'
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория обновлена');
    }

    public function destroy(Category $category)
    {
        // проверяем есть ли товары в этой категории
        $productsCount = Product::where('category', $category->name)->count();

        if ($productsCount > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Нельзя удалить категорию «' . $category->name . '» — в ней ' . $productsCount . ' товаров');
        }

        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория «' . $name . '» удалена');
    }
}
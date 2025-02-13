<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return Inertia::render('MasterData/Categories/Index', compact('categories'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Category::create($request->all());
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }
    public function edit(Category $category)
    {
        //
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $category->update($request->all());
        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}
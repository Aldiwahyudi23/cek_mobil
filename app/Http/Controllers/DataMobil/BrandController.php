<?php

namespace App\Http\Controllers\DataMobil;

use App\Http\Controllers\Controller;
use App\Models\DataMobil\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrandController extends Controller
{
    public function index()
    {
        $brand = Brand::latest()->get();
        return Inertia::render('MasterData/DataMobil/Brand/Index', compact('brand'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:brands,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'name.required' => "Merek Wajib diisi !",
            'name.max' => "Merek Tidak Boleh Lebih Dari 50 !",
            'name.unique' => "Nama merk sudah ada, silakan gunakan nama yang lain.",
        ]);

        Brand::create($request->all());
        return redirect()->back()->with('success', 'Merk berhasil ditambahkan.');
    }
    public function edit(Brand $brand)
    {
        //
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'name.required' => "Merek Wajib diisi !",
            'name.max' => "Merek Tidak Boleh Lebih Dari 50 !",
            'name.unique' => 'Nama merk sudah ada, silakan gunakan nama yang lain.',
        ]);

        $brand->update($request->all());
        return redirect()->back()->with('success', 'Merk berhasil diperbarui.');
    }
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->back()->with('success', 'Merk berhasil dihapus.');
    }
}

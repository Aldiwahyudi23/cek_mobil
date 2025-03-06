<?php

namespace App\Http\Controllers\DataMobil;

use App\Http\Controllers\Controller;
use App\Models\DataMobil\Brand;
use App\Models\DataMobil\CarModel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $CarModel = CarModel::with('brand')->latest()->get();
        $brand = Brand::all();
        return Inertia::render('MasterData/DataMobil/Model/Index', compact('CarModel', 'brand'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        CarModel::create($request->all());
        return redirect()->back()->with('success', 'Model Mobil berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarModel $Model)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $Model->update($request->all());
        return redirect()->back()->with('success', 'Model Mobil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarModel $Model)
    {
        $Model->delete();
        return redirect()->back()->with('success', 'Model Mobil berhasil dihapus.');
    }
}
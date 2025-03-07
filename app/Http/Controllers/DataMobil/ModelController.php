<?php

namespace App\Http\Controllers\DataMobil;

use App\Http\Controllers\Controller;
use App\Models\DataMobil\Brand;
use App\Models\DataMobil\CarModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $request->validate(
            [
                'brand_id' => 'required|exists:brands,id', // Pastikan brand_id ada di tabel brands
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    // Validasi kombinasi unik untuk brand_id dan name
                    Rule::unique('car_models')->where(function ($query) use ($request) {
                        return $query->where('brand_id', $request->brand_id)
                            ->where('name', $request->name);
                    }),
                ],
                'is_active' => 'boolean',
            ],
            [
                'name.required' => 'Nama Model Mobil sudah ada sesuai merek.',
            ]
        );

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
            'brand_id' => 'required|exists:brands,id', // Pastikan brand_id ada di tabel brands
            'name' => [
                'required',
                'string',
                'max:255',
                // Validasi kombinasi unik untuk brand_id dan name, kecuali untuk ID yang sedang diperbarui
                Rule::unique('car_models')->where(function ($query) use ($request) {
                    return $query->where('brand_id', $request->brand_id)
                        ->where('name', $request->name);
                })->ignore($Model->id), // Abaikan record dengan ID yang sedang diperbarui
            ],
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

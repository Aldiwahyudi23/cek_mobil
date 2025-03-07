<?php

namespace App\Http\Controllers\DataMobil;

use App\Http\Controllers\Controller;
use App\Models\DataMobil\CarModel;
use App\Models\DataMobil\CarType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CarTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carTypes = CarType::with('carModel')->latest()->get();
        $carModels = CarModel::all();
        return Inertia::render('MasterData/DataMobil/CarType/Index', compact('carTypes', 'carModels'));
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
            'car_model_id' => 'required|exists:car_models,id',
            'name' => [
                'required',
                'string',
                'max:255',
                // Validasi kombinasi unik untuk car_model_id dan name
                Rule::unique('car_types')->where(function ($query) use ($request) {
                    return $query->where('car_model_id', $request->car_model_id)
                        ->where('name', $request->name);
                }),
            ],

            'description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        CarType::create($request->all());

        return redirect()->back()->with('success', 'Type Mobil berhasil ditambahkan.');
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
    public function update(Request $request, CarType $carType)
    {
        $request->validate([
            'car_model_id' => 'required|exists:car_models,id',
            'name' => [
                'required',
                'string',
                'max:255',
                // Validasi kombinasi unik untuk car_model_id dan name, kecuali untuk ID yang sedang diperbarui
                Rule::unique('car_types')->where(function ($query) use ($request) {
                    return $query->where('car_model_id', $request->car_model_id)
                        ->where('name', $request->name);
                })->ignore($carType->id), // Abaikan record dengan ID yang sedang diperbarui
            ],
            'description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $carType->update($request->all());

        return redirect()->back()->with('success', 'Type Mobil berhasil diperbaharui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarType $carType)
    {
        $carType->delete();
        return redirect()->back()->with('success', 'Type Mobil berhasil dihapus.');
    }
}

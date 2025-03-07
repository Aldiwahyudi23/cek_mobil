<?php

namespace App\Http\Controllers\DataMobil;

use App\Http\Controllers\Controller;
use App\Models\DataMobil\Brand;
use App\Models\DataMobil\Car;
use App\Models\DataMobil\CarModel;
use App\Models\DataMobil\CarType;
use App\Models\DataMobil\EngineCapacity;
use App\Models\DataMobil\FuelType;
use App\Models\DataMobil\Transmission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Method Index
    public function index()
    {
        $cars = Car::with(['brand', 'carModel', 'carType', 'engineCapacity', 'transmission', 'fuelType'])
            ->latest()
            ->get();

        $brands = Brand::all();
        $carModels = CarModel::all();
        $carTypes = CarType::all();
        $engineCapacities = EngineCapacity::all();
        $transmissions = Transmission::all();
        $fuelTypes = FuelType::all();

        return Inertia::render('MasterData/DataMobil/Car/Index', [
            'cars' => $cars,
            'brands' => $brands,
            'carModels' => $carModels,
            'carTypes' => $carTypes,
            'engineCapacities' => $engineCapacities,
            'transmissions' => $transmissions,
            'fuelTypes' => $fuelTypes,
        ]);
    }

    // Method Store
    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_type_id' => 'required|exists:car_types,id',
            'year' => 'required|integer|min:1999|max:' . date('Y'),
            'engine_capacity_id' => 'required|exists:engine_capacities,id',
            'transmission_id' => 'required|exists:transmissions,id',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'production_period_start' => 'required|integer|min:1999|max:' . date('Y'),
            'production_period_end' => 'required|integer|min:1999|max:' . date('Y'),
        ]);

        // Gabungkan tahun awal dan akhir menjadi production_period
        $productionPeriod = $request->production_period_start . '-' . $request->production_period_end;

        Car::create([
            'brand_id' => $request->brand_id,
            'car_model_id' => $request->car_model_id,
            'car_type_id' => $request->car_type_id,
            'year' => $request->year,
            'engine_capacity_id' => $request->engine_capacity_id,
            'transmission_id' => $request->transmission_id,
            'fuel_type_id' => $request->fuel_type_id,
            'production_period' => $productionPeriod,
        ]);

        return redirect()->back()->with('success', 'Data mobil berhasil ditambahkan.');
    }

    // Method Update
    public function update(Request $request, Car $car)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_type_id' => 'required|exists:car_types,id',
            'year' => 'required|integer|min:1999|max:' . date('Y'),
            'engine_capacity_id' => 'required|exists:engine_capacities,id',
            'transmission_id' => 'required|exists:transmissions,id',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'production_period_start' => 'required|integer|min:1999|max:' . date('Y'),
            'production_period_end' => 'required|integer|min:1999|max:' . date('Y'),
        ]);

        // Gabungkan tahun awal dan akhir menjadi production_period
        $productionPeriod = $request->production_period_start . '-' . $request->production_period_end;

        $car->update([
            'brand_id' => $request->brand_id,
            'car_model_id' => $request->car_model_id,
            'car_type_id' => $request->car_type_id,
            'year' => $request->year,
            'engine_capacity_id' => $request->engine_capacity_id,
            'transmission_id' => $request->transmission_id,
            'fuel_type_id' => $request->fuel_type_id,
            'production_period' => $productionPeriod,
        ]);

        return redirect()->back()->with('success', 'Data mobil berhasil diperbarui.');
    }

    // Method Destroy
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->back()->with('success', 'Data mobil berhasil dihapus.');
    }
}

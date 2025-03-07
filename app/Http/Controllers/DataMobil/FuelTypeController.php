<?php

namespace App\Http\Controllers\DataMobil;

use App\Http\Controllers\Controller;
use App\Models\DataMobil\FuelType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FuelTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data bahan bakar dari database
        $fuelTypes = FuelType::orderBy('name', 'asc')->get();

        // Kirim data ke view menggunakan Inertia
        return Inertia::render('MasterData/DataMobil/FuelType/Index', [
            'fuelTypes' => $fuelTypes, // Pastikan nama prop sesuai
        ]);
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
            'name' => 'required|string|unique:fuel_types,name',
        ], [
            'name.required' => 'Nama bahan bakar harus diisi.',
            'name.unique' => 'Nama bahan bakar sudah ada.',
        ]);

        FuelType::create($request->all());
        return redirect()->back()->with('success', 'Bahan bakar berhasil ditambahkan.');
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
    public function update(Request $request, FuelType $bahan_bakar)
    {
        $request->validate([
            'name' => 'required|string|unique:fuel_types,name,' . $bahan_bakar->id,
        ], [
            'name.required' => 'Nama bahan bakar harus diisi.',
            'name.unique' => 'Nama bahan bakar sudah ada.',
        ]);

        // Update data
        $bahan_bakar->update($request->all());

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Bahan bakar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FuelType $bahan_bakar)
    {
        // Hapus data
        $bahan_bakar->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Bahan bakar berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\DataMobil;

use App\Http\Controllers\Controller;
use App\Models\DataMobil\EngineCapacity;
use Faker\Provider\ar_EG\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EngineCapacityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $capacities = EngineCapacity::orderBy('value', 'asc')->get();
        return Inertia::render('MasterData/DataMobil/EngineCapacity/Index', compact('capacities'));
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
            'value' => 'required|unique:engine_capacities,value',
        ], [
            'value.required' => 'CC Harus diIsi.',
            'value.unique' => 'CC Sudah Ada, cari nama lain..',
        ]);

        EngineCapacity::create($request->all());

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
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
    public function update(Request $request, EngineCapacity $capacity)
    {
        $request->validate([
            'value' => 'required|unique:engine_capacities,value,' . $capacity->id,
        ], [
            'value.required' => 'CC Harus diIsi.',
            'value.unique' => 'CC Sudah Ada, cari nama lain..',
        ]);

        $capacity->update($request->all());
        return redirect()->back()->with('success', 'Kapasitas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EngineCapacity $capacity)
    {
        $capacity->delete();
        return redirect()->back()->with('success', 'Kapasitas Berhasil dihapus');
    }
}

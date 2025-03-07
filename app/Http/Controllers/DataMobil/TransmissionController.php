<?php

namespace App\Http\Controllers\DataMobil;

use App\Http\Controllers\Controller;
use App\Models\DataMobil\Transmission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transmissions = Transmission::orderBy('type', 'asc')->get();
        return Inertia::render('MasterData/DataMobil/Transmission/Index', compact('transmissions'));
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
            'type' => 'required|string|unique:transmissions,type',
        ],  [
            'type.required' => 'Transmisi Harus diIsi.',
            'type.unique' => 'Transmisi Sudah Ada, cari nama lain..',
        ]);

        Transmission::create($request->all());
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
    public function update(Request $request, Transmission $transmission)
    {
        // Validasi data
        $request->validate([
            'type' => 'required|string|unique:transmissions,type,' . $transmission->id,
        ], [
            'type.required' => 'Transmisi Harus diIsi.',
            'type.unique' => 'Transmisi Sudah Ada, cari nama lain..',
        ]);

        // Update data
        $transmission->update($request->all());

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transmission $transmission)
    {
        $transmission->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
<?php

namespace App\Http\Controllers\Inspection;

use App\Http\Controllers\Controller;
use App\Models\Inspek\DetailKendaraan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DetailKendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kendaraans = DetailKendaraan::latest()->get();
        return Inertia::render('Inspection/Create/DetailKendaraan', compact('kendaraans'));
    }

    /**
     * Show the form for creating a new resource.
     */


    public function store(Request $request)
    {
        $request->validate([
            'nopol' => 'required|string|unique:detail_kendaraans,nopol|max:255',
            'merek' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
            'model' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'cc' => 'required|integer|min:500|max:8000',
            'transmition' => 'required|in:AT,MT',
            'bahan_bakar' => 'required|string|max:255',
            'periode' => 'required|string|max:255',
            'warna' => 'required|string|max:255',
        ]);

        DetailKendaraan::create($request->all());

        return redirect()->back()->with('success', 'Data kendaraan berhasil ditambahkan.');
    }

    /**
     * Store a newly created resource in storage.
     */


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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
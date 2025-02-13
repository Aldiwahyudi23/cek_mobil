<?php

namespace App\Http\Controllers\Inspection;

use App\Http\Controllers\Controller;
use App\Models\Inspek\InspectionResult;
use App\Models\MasterData\Category;
use Illuminate\Http\Request;

class CekMobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Tampilkan halaman inspeksi
    public function index()
    {
        // Ambil hanya kategori yang aktif, dan hanya inspection points yang aktif
        $categories = Category::where('is_active', true)
            ->with(['inspection_points' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();

        return inertia('Inspection/Create/Start', [
            'categories' => $categories
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
    // Simpan hasil inspeksi
    public function store(Request $request)
    {
        $request->validate([
            'inspection_results' => 'required|array',
        ]);

        foreach ($request->inspection_results as $pointId => $value) {
            InspectionResult::updateOrCreate(
                [
                    'inspection_point_id' => $pointId,
                    'user_id' => auth()->id(), // Simpan berdasarkan user yang melakukan inspeksi
                ],
                ['value' => $value]
            );
        }

        return redirect()->route('inspection.start')->with('success', 'Inspeksi berhasil disimpan!');
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
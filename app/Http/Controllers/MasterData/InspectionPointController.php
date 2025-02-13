<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Category;
use App\Models\MasterData\InspectionPoint;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InspectionPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inspectionPoints = InspectionPoint::with('category')->latest()->get();
        $categories = Category::all();
        return Inertia::render('MasterData/InspectionPoints/Index', compact('inspectionPoints', 'categories'));
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
            'categories_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type_input' => 'required|string',
            'is_active' => 'boolean',
        ]);

        InspectionPoint::create($request->all());
        return redirect()->back()->with('success', 'Inspection Point berhasil ditambahkan.');
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
    public function update(Request $request, InspectionPoint $inspectionPoint)
    {
        $request->validate([
            'categories_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type_input' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $inspectionPoint->update($request->all());
        return redirect()->back()->with('success', 'Inspection Point berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspectionPoint $inspectionPoint)
    {
        $inspectionPoint->delete();
        return redirect()->back()->with('success', 'Inspection Point berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{
    /**
     * Display a listing of the Medicines.
     */
    public function index()
    {
        $medicines = Medicine::with('category')->latest()->paginate(10);
        return view('medicines.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new Medicine.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('medicines.create', compact('categories'));
    }

    /**
     * Store a newly created medicine in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'unit_price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'pack_size' => 'required|integer|min:1',
            'pack_unit' => 'required|string|max:50',
            'low_stock_threshold' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('image');

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        Medicine::create($data);
        return redirect()->route('medicines.index')->with('success', 'Medicine added successfully!');

    }

    /**
     * Display single medicine.
     */
    public function show(Medicine $medicine)
    {
        $medicine->load('category', 'batches.supplier');
        return view('medicines.show', compact('medicine'));
    }

    /**
     * Show the form for editing the medicine.
     */
    public function edit(Medicine $medicine)
    {
        $categories = Category::orderBy('name')->get();
        return view('medicines.edit', compact('medicine', 'categories'));
    }

    /**
     * Update the specified medicine in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'unit_price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'pack_size' => 'required|integer|min:1',
            'pack_unit' => 'required|string|max:50',
            'low_stock_threshold' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('image');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($medicine->image && Storage::disk('public')->exists($medicine->image)) {
                Storage::disk('public')->delete($medicine->image);
            }
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        $medicine->update($data);
        return redirect()->route('medicines.index')->with('success', 'Medicine updated successfully!');
    }

    /**
     * Remove the specified medicine from storage.
     */
    public function destroy(string $id)
    {
        // Delete image if exists
        if ($medicine->image && Storage::disk('public')->exists($medicine->image)) {
            Storage::disk('public')->delete($medicine->image);
        }
        $medicine->delete();
        return redirect()->route('medicines.index')->with('success', 'Medicine deleted successfully!');
    }
}

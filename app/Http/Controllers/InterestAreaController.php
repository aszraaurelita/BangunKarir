<?php

namespace App\Http\Controllers;

use App\Models\InterestArea;
use Illuminate\Http\Request;

class InterestAreaController extends Controller
{
    // Tampilkan semua minat karier
    public function index()
    {
        $interests = InterestArea::all();
        return view('interest_areas.index', compact('interests'));
    }

    // Form tambah minat
    public function create()
    {
        return view('interest_areas.create');
    }

    // Simpan minat baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_minat' => 'required|string|max:255',
        ]);

        InterestArea::create([
            'nama_minat' => $request->nama_minat,
        ]);

        return redirect()->route('interest-areas.index')->with('success', 'Minat berhasil ditambahkan.');
    }

    // Form edit minat
    public function edit(InterestArea $interestArea)
    {
        return view('interest_areas.edit', compact('interestArea'));
    }

    // Update minat
    public function update(Request $request, InterestArea $interestArea)
    {
        $request->validate([
            'nama_minat' => 'required|string|max:255',
        ]);

        $interestArea->update([
            'nama_minat' => $request->nama_minat,
        ]);

        return redirect()->route('interest-areas.index')->with('success', 'Minat berhasil diperbarui.');
    }

    // Hapus minat
    public function destroy(InterestArea $interestArea)
    {
        $interestArea->delete();
        return redirect()->route('interest-areas.index')->with('success', 'Minat berhasil dihapus.');
    }
}

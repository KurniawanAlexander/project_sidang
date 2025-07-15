<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    // Menampilkan daftar ruangan
    public function index()
    {
        $ruangan = ruangan::all(); // Ambil semua data ruangan
        return view('admin.ruangan.index', compact('ruangan'));
    }

    // Menampilkan form untuk menambahkan ruangan
    public function create()
    {
        return view('admin.ruangan.create');
    }

    // Menyimpan ruangan baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_ruangan' => 'required',
            'ruangan' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
            'keterangan' => 'nullable',
        ]);

        ruangan::create($request->all());
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    // Menampilkan ruangan tertentu
    public function show(ruangan $ruangan)
    {
        return view('admin.ruangan.show', compact('ruangan'));
    }

    // Menampilkan form untuk mengedit ruangan
    public function edit(ruangan $ruangan)
    {
        return view('admin.ruangan.edit', compact('ruangan'));
    }

    // Memperbarui ruangan yang sudah ada
    public function update(Request $request, ruangan $ruangan)
    {
        $request->validate([
            'kode_ruangan' => 'required',
            'ruangan' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
            'keterangan' => 'nullable',
        ]);

        $ruangan->update($request->all());
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    // Menghapus ruangan
    public function destroy(ruangan $ruangan)
    {
        $ruangan->delete();
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}

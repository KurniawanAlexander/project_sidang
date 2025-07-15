<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    // Menampilkan daftar jabatan
    public function index()
    {
        $jabatan = jabatan::all(); // Ambil semua data jabatan
        return view('admin.jabatan.index', compact('jabatan'));
    }

    // Menampilkan form untuk menambahkan jabatan
    public function create()
    {
        return view('admin.jabatan.create');
    }

    // Menyimpan jabatan baru
    public function store(Request $request)
    {
        $request->validate([
            'jabatan' => 'required',
            'keterangan' => 'required',
        ]);

        jabatan::create($request->all());
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    // Menampilkan jabatan tertentu
    public function show(jabatan $jabatan)
    {
        return view('admin.jabatan.show', compact('jabatan'));
    }

    // Menampilkan form untuk mengedit jabatan
    public function edit(jabatan $jabatan)
    {
        return view('admin.jabatan.edit', compact('jabatan'));
    }

    // Memperbarui jabatan yang sudah ada
    public function update(Request $request, jabatan $jabatan)
    {
        $request->validate([
            'jabatan' => 'required',
            'keterangan' => 'required',
        ]);

        $jabatan->update($request->all());
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diperbarui.');
    }

    // Menghapus jabatan
    public function destroy(jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus.');
    }
}

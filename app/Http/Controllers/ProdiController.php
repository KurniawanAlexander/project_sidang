<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    // Menampilkan daftar Prodi
    public function index()
    {
        $prodi = Prodi::all(); // Ambil semua data prodi
        return view('admin.prodi.index', compact('prodi'));
    }

    // Menampilkan form untuk menambahkan prodi
    public function create()
    {
        return view('admin.prodi.create');
    }

    // Menyimpan prodi baru
    public function store(Request $request)

    {
        $request->validate([
            'kode_prodi' => 'required',
            'nama_prodi' => 'required',
            'jenjang' => 'required',
            'akreditasi' => 'required',
            'tahunberdiri' => 'required',
            'keterangan' => 'nullable',
        ]);

        Prodi::create($request->all());
        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil ditambahkan.');
    }

    // Menampilkan prodi tertentu
    public function show(Prodi $prodi)
    {
        return view('admin.prodi.show', compact('prodi'));
    }

    // Menampilkan form untuk mengedit prodi
    public function edit(Prodi $prodi)
    {
        return view('admin.prodi.edit', compact('prodi'));
    }

    // Memperbarui prodi yang sudah ada
    public function update(Request $request, Prodi $prodi)
    {
        $request->validate([
            'kode_prodi' => 'required',
            'nama_prodi' => 'required',
            'jenjang' => 'required',
            'akreditasi' => 'required',
            'tahunberdiri' => 'required',
            'keterangan' => 'nullable',
        ]);

        $prodi->update($request->all());
        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil diperbarui.');
    }

    // Menghapus prodi
    public function destroy(Prodi $prodi)
    {
        $prodi->delete();
        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil dihapus.');
    }
}

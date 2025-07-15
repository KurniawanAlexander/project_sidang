<?php

namespace App\Http\Controllers;

use App\Models\Bidangkeahlian;
use Illuminate\Http\Request;

class BidangkeahlianController extends Controller
{
    // Menampilkan Daftar Bidang Keahlian
    public function index()
    {
        $bidangkeahlian = Bidangkeahlian::all();
        return view('admin.bidangkeahlian.index', compact('bidangkeahlian'));
    }

    // Menampilkan Form Tambah Bidang Keahlian
    public function create()
    {
        return view('admin.bidangkeahlian.create');
    }

    // Menyimpan Bidang Keahlian Baru
    public function store(Request $request)
    {
        $request->validate([
            'bidangkeahlian' => 'required',
            'keterangan' => 'required',
        ]);

        Bidangkeahlian::create($request->all());

        return redirect()->route('bidangkeahlian.index')
            ->with('success', 'Bidang Keahlian berhasil ditambahkan');
    }

    // Menampilkan Form Edit
    public function edit(Bidangkeahlian $bidangkeahlian)
    {
        return view('admin.bidangkeahlian.edit', compact('bidangkeahlian'));
    }

    // Mengupdate Data Bidang Keahlian
    public function update(Request $request, Bidangkeahlian $bidangkeahlian)
    {
        $request->validate([
            'bidangkeahlian' => 'required|unique:bidangkeahlians,bidangkeahlian,' . $bidangkeahlian->id,
            'keterangan' => 'required',
        ]);

        $bidangkeahlian->update($request->all());

        return redirect()->route('bidangkeahlian.index')
            ->with('success', 'Bidang Keahlian berhasil diubah');
    }

    // Menghapus Data Bidang Keahlian
    public function destroy(Bidangkeahlian $bidangkeahlian)
    {
        $bidangkeahlian->delete();

        return redirect()->route('bidangkeahlian.index')
            ->with('success', 'Bidang Keahlian berhasil dihapus');
    }
}

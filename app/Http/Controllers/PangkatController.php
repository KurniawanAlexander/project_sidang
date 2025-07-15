<?php
namespace App\Http\Controllers;

use App\Models\Pangkat;
use Illuminate\Http\Request;

class PangkatController extends Controller
{
    // Menampilkan daftar pangkat
    public function index()
    {
        $pangkat = pangkat::all(); // Ambil semua data pangkat
        return view('admin.pangkat.index', compact('pangkat'));
    }

    // Menampilkan form untuk menambahkan pangkat
    public function create()
    {
        return view('admin.pangkat.create');
    }

    // Menyimpan pangkat baru
    public function store(Request $request)
    {
        $request->validate([
            'pangkat' => 'required',
        ]);

        pangkat::create($request->all());
        return redirect()->route('pangkat.index')->with('success', 'Pangkat berhasil ditambahkan.');
    }

    // Menampilkan pangkat tertentu
    public function show(pangkat $pangkat)
    {
        return view('admin.pangkat.show', compact('pangkat'));
    }

    // Menampilkan form untuk mengedit pangkat
    public function edit(pangkat $pangkat)
    {
        return view('admin.pangkat.edit', compact('pangkat'));
    }

    // Memperbarui pangkat yang sudah ada
    public function update(Request $request, pangkat $pangkat)
    {
        $request->validate([
            'pangkat' => 'required',
        ]);

        $pangkat->update($request->all());
        return redirect()->route('pangkat.index')->with('success', 'Pangkat berhasil diperbarui.');
    }

    // Menghapus pangkat
    public function destroy(pangkat $pangkat)
    {
        $pangkat->delete();
        return redirect()->route('pangkat.index')->with('success', 'Pangkat berhasil dihapus.');
    }
}

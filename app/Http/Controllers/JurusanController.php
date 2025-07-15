<?php
namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    // Menampilkan daftar jurusan
    public function index()
    {
        $jurusan = Jurusan::all(); // Ambil semua data jurusan
        return view('admin.jurusan.index', compact('jurusan'));
    }

    // Menampilkan form untuk menambahkan jurusan
    public function create()
    {
        return view('admin.jurusan.create');
    }

    // Menyimpan jurusan baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_jurusan' => 'required',
            'jurusan' => 'required',
            'keterangan' => 'nullable',
        ]);

        Jurusan::create($request->all());
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    // Menampilkan jurusan tertentu
    public function show(Jurusan $jurusan)
    {
        return view('admin.jurusan.show', compact('jurusan'));
    }

    // Menampilkan form untuk mengedit jurusan
    public function edit(Jurusan $jurusan)
    {
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    // Memperbarui jurusan yang sudah ada
    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'kode_jurusan' => 'required',
            'jurusan' => 'required',
            'keterangan' => 'nullable',
        ]);

        $jurusan->update($request->all());
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    // Menghapus jurusan
    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}

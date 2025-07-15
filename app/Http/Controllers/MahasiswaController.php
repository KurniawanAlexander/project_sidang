<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    // Menampilkan daftar Mahasiswa
    public function index(Request $request)
    {
        $search = $request->input('search'); // Ambil query pencarian dari input

        // Jika ada input pencarian, cari berdasarkan nama mahasiswa
        if ($search) {
            $mahasiswa = Mahasiswa::where('nama', 'like', '%' . $search . '%')->paginate(5); // Ganti 10 dengan jumlah yang diinginkan
        } else {
            $mahasiswa = Mahasiswa::paginate(5); // Jika tidak ada pencarian, tampilkan semua mahasiswa
        }

        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }


    public function detail($id)
    {
        $mahasiswa = mahasiswa::find($id);

        return view('mahasiswa.detail', compact('mahasiswa'));
    }

    // Menampilkan form untuk menambahkan mahasiswa
    public function create()
    {
        $jurusan = Jurusan::all();
        $prodi = Prodi::all();
        return view('admin.mahasiswa.create', compact('jurusan', 'prodi'));
    }

    // Menyimpan mahasiswa baru
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'nama' => 'required|max:255',
            'nim' => 'required|unique:mahasiswas,nim',
            'kelas' => 'required',
            'kode_jurusan' => 'required',
            'kode_prodi' => 'required',
            'gender' => 'required|in:Laki-laki,Perempuan', // Validasi gender
            'email' => 'required|max:255|unique:users,email',
            'no_telp' => 'required|max:15',
        ]);

        $tambahuser = user::create([
            'name' => $request['nama'],
            'email' => $request['email'],
            'password' => Hash::make('12345678'),
            'role' => 'Mahasiswa'
        ]);

        // Tambahkan user_id ke dalam data mahasiswa
        $validatedData = $request->all();
        $validatedData['user_id'] = $tambahuser->id;

        // Simpan foto ke folder storage/foto
        $path = $request->file('foto')->store('foto', 'public');
        $validatedData['foto'] = $path;

        // Simpan data mahasiswa ke tabel mahasiswas
        $mahasiswa = Mahasiswa::create($validatedData);

        // Cek apakah data berhasil disimpan
        if (!$mahasiswa) {
            return back()->with('Failed', 'Data gagal ditambahkan');
        }

        // Redirect dengan pesan sukses
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }


    // Menampilkan mahasiswa tertentu
    public function show(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.detail', compact('mahasiswa'));
    }

    // Menampilkan form untuk mengedit mahasiswa
    public function edit(Mahasiswa $mahasiswa)
    {
        $jurusan = Jurusan::all();
        $prodi = Prodi::all();
        return view('admin.mahasiswa.edit', compact('mahasiswa', 'jurusan', 'prodi'));
    }

    // Memperbarui mahasiswa yang sudah ada
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas,nim,' . $mahasiswa->id, // Pastikan NIM unik kecuali untuk mahasiswa ini
            'kode_jurusan' => 'required',
            'kode_prodi' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required',
        ]);

        // Jika ada foto baru, hapus foto lama dan simpan yang baru
        if ($request->hasFile('foto')) {
            if ($mahasiswa->foto && Storage::exists('public/' . $mahasiswa->foto)) {
                Storage::delete('public/' . $mahasiswa->foto);
            }
            $path = $request->file('foto')->store('foto', 'public');
            $mahasiswa->foto = $path;
        }

        // Update data lain di model
        $mahasiswa->update($request->except('foto'));

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui!');
    }

    // Menghapus data mahasiswa
    public function destroy(Mahasiswa $mahasiswa)
    {
        if ($mahasiswa->foto && Storage::exists('public/' . $mahasiswa->foto)) {
            Storage::delete('public/' . $mahasiswa->foto);
        }

        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }
}

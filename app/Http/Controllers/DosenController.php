<?php

namespace App\Http\Controllers;

use View; // Menggunakan huruf kapital 'V' untuk View
use App\Models\User;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Jurusan;
use App\Models\Bidangkeahlian;
use App\Models\Jabatan; // Menambahkan model Jabatan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    // Menampilkan daftar Dosen
    public function index(Request $request)
    {
        // $dosen = Dosen::all(); // Ambil semua data dosen
        $search = $request->input('search'); // Ambil query pencarian dari input

        // Jika ada input pencarian, cari berdasarkan nama mahasiswa
        if ($search) {
            $dosen = Dosen::where('nama_dosen', 'like', '%' . $search . '%')->paginate(5); // Ganti 10 dengan jumlah yang diinginkan
        } else {
            $dosen = Dosen::paginate(5); // Jika tidak ada pencarian, tampilkan semua mahasiswa
        }
        return view('admin.dosen.index', compact('dosen'));
    }



    public function detail($id)
    {
        $dosen = dosen::find($id);

        return view('dosen.detail', compact('dosen'));
    }

    // Menampilkan form untuk menambahkan dosen
    public function create()
    {
        $jurusan = Jurusan::all();
        $prodi = Prodi::all();
        $bidangkeahlian = Bidangkeahlian::all();
        $jabatan = Jabatan::all(); // Mengambil data jabatan
        return view('admin.dosen.create', compact('jurusan', 'prodi', 'bidangkeahlian', 'jabatan'));
    }

    // Menyimpan dosen baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_dosen' => 'required',
            'nip' => 'required|unique:dosens,nip', // Pastikan NIP unik
            'nidn' => 'required',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'kode_jurusan' => 'required',
            'kode_prodi' => 'required',
            'jabatan' => 'required',
            'bidangkeahlian' => 'required',
            'jabatan_id' => 'required', // Validasi untuk jabatan_id
            'email' => 'required|unique:users,email',
            'no_telp' => 'required',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Membuat user terlebih dahulu
        $tambahuser = User::create([
            'name' => $request['nama_dosen'],
            'email' => $request['email'],
            'password' => Hash::make('12345678'),
            'role' => '-' // Sesuaikan role jika perlu
        ]);

        // Simpan foto ke folder storage/foto
        $path = $request->file('foto')->store('foto', 'public');

        // Membuat data dosen dengan menambahkan user_id
        $validatedData = $request->all();
        $validatedData['user_id'] = $tambahuser->id; // Menambahkan user_id
        $validatedData['foto'] = $path;

        // Simpan data dosen ke database
        $dosen = Dosen::create($validatedData);

        // Cek apakah data berhasil disimpan
        if (!$dosen) {
            return back()->with('Failed', 'Data gagal ditambahkan');
        }

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil ditambahkan.');
    }


    // Menampilkan dosen tertentu
    public function show(Dosen $dosen)
    {
        return view('admin.dosen.detail', compact('dosen'));
    }

    // Menampilkan form untuk mengedit dosen
    public function edit(Dosen $dosen)
    {
        $jurusan = Jurusan::all();
        $prodi = Prodi::all();
        $bidangkeahlian = Bidangkeahlian::all();
        $jabatan = Jabatan::all(); // Mengambil data jabatan
        return view('admin.dosen.edit', compact('dosen', 'jurusan', 'prodi', 'bidangkeahlian', 'jabatan'));
    }

    // Memperbarui dosen yang sudah ada
    public function update(Request $request, Dosen $dosen)
    {
        $request->validate([
            'nama_dosen' => 'required',
            'nip' => 'required|unique:dosens,nip,' . $dosen->id, // Pastikan NIP unik kecuali untuk yang sama
            'nidn' => 'required',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'kode_jurusan' => 'required',
            'kode_prodi' => 'required',
            'jabatan' => 'required',
            'bidangkeahlian' => 'required',
            'jabatan_id' => 'required', // Validasi untuk jabatan_id
            'email' => 'required|email',
            'no_telp' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika ada foto baru, hapus foto lama dan simpan yang baru
        if ($request->hasFile('foto')) {
            if ($dosen->foto && Storage::exists('public/' . $dosen->foto)) {
                Storage::delete('public/' . $dosen->foto);
            }
            $path = $request->file('foto')->store('foto', 'public');
            $dosen->foto = $path;
        }

        // Update data lain di model
        $dosen->update($request->except('foto'));

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil diperbarui!');
    }

    // Menghapus data dosen
    public function destroy(Dosen $dosen)
    {
        if ($dosen->foto && Storage::exists('public/' . $dosen->foto)) {
            Storage::delete('public/' . $dosen->foto);
        }

        $dosen->delete();
        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index(Request $request)
    {
        // Ambil input pencarian
        $search = $request->input('search');

        if ($search) {
            $users = User::where('name', 'like', '%' . $search . '%')->paginate(10); // Ganti 10 dengan jumlah yang diinginkan
        } else {
            $users = User::paginate(10); // Jika tidak ada pencarian, tampilkan semua mahasiswa
        }

        // Kirim data ke view
        return view('admin.user.index', compact('users'));
    }


    // Menampilkan formulir untuk menambah pengguna
    public function create()
    {
        return view('admin.user.create');
    }

    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password), // Hashing password untuk keamanan
        ]);

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    // Menampilkan pengguna tertentu
    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    // Menampilkan formulir untuk mengedit pengguna
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    // Memperbarui pengguna
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:Superadmin,Admin,Kajur,Kaprodi,Dosen,Mahasiswa',
            'password' => 'nullable|string|min:8|confirmed', // Password dapat dikosongkan
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) { // Memastikan password hanya di-update jika diisi
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    // Menghapus pengguna
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}

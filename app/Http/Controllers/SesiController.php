<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use Illuminate\Http\Request;

class SesiController extends Controller
{
    public function index()
    {
        $data = Sesi::all();
        return view("admin.sesi.sesi", ['data' => $data]);
    }

    public function create()
    {
        $data = Sesi::all();
        return view('admin.pages.sesi.sesicreate', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'namasesi' => 'required|max:255',
            'waktumulai' => 'required',
            'waktuakhir' => 'required',
        ]);
        $tambahdata = Sesi::create($validatedData);
        if (!$tambahdata) {
            return redirect('/admin/session')->with('failed', 'Data gagal ditambahkan');
        }
        return redirect('/admin/session')->with('success', 'Data created successfully');
    }

    public function edit(Sesi $sesi)
    {
        $data = Sesi::all();
        return view('admin.pages.sesi.sesiedit', ['data' => $data, 'sesi' => $sesi]);
    }

    public function update(Request $request, Sesi $sesi)
    {
        $validatedData = $request->validate([
            'namasesi' => 'required|max:255',
            'waktumulai' => 'required',
            'waktuakhir' => 'required',
        ]);
        $sesi->update($validatedData);
        return redirect('/admin/session')->with('success', 'Data has been updated');
    }

    public function destroy(Sesi $sesi)
    {
        $sesi->delete();
        return redirect('/admin/session')->with('success', 'Data has been deleted');
    }
}

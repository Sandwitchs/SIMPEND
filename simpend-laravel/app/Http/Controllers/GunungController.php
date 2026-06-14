<?php

namespace App\Http\Controllers;

use App\Models\Gunung;
use Illuminate\Http\Request;

class GunungController extends Controller
{
    public function index()
    {
        $gunung = Gunung::all();
        return view('admin.gunung.index', compact('gunung'));
    }

    public function create()
    {
        return view('admin.gunung.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_gunung' => 'required|string|max:255',
            'jalur' => 'required|string|max:255',
            'kuota_maks' => 'required|integer|min:1',
            'harga_per_orang' => 'required|integer|min:0',
            'harga_per_orang_tektok' => 'required|integer|min:0',
        ]);

        Gunung::create($data);
        return redirect()->route('admin.gunung.index')->with('success', 'Data gunung berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $gunung = Gunung::findOrFail($id);
        return view('admin.gunung.edit', compact('gunung'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_gunung' => 'required|string|max:255',
            'jalur' => 'required|string|max:255',
            'kuota_maks' => 'required|integer|min:1',
            'harga_per_orang' => 'required|integer|min:0',
            'harga_per_orang_tektok' => 'required|integer|min:0',
        ]);

        Gunung::findOrFail($id)->update($data);
        return redirect()->route('admin.gunung.index')->with('success', 'Data gunung berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Gunung::findOrFail($id)->delete();
        return redirect()->route('admin.gunung.index')->with('success', 'Data gunung berhasil dihapus!');
    }
}

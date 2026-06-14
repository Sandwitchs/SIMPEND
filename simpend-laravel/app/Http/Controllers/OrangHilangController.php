<?php

namespace App\Http\Controllers;

use App\Models\OrangHilang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrangHilangController extends Controller
{
    // Halaman Publik
    public function publicIndex()
    {
        $orangHilang = OrangHilang::orderBy('tanggal_hilang', 'desc')->get();
        return view('orang_hilang.index', compact('orangHilang'));
    }

    // Admin List
    public function index()
    {
        $orangHilang = OrangHilang::orderBy('created_at', 'desc')->get();
        return view('admin.orang_hilang.index', compact('orangHilang'));
    }

    // Admin Create Form
    public function create()
    {
        return view('admin.orang_hilang.create');
    }

    // Admin Store
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer|min:1',
            'lokasi_terakhir' => 'required|string|max:255',
            'tanggal_hilang' => 'required|date',
            'deskripsi_terakhir' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:belum ditemukan,ditemukan',
            'kontak_keluarga' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('orang_hilang', 'public');
        }

        OrangHilang::create($data);

        return redirect()->route('admin.orang-hilang.index')->with('success', 'Data orang hilang berhasil ditambahkan!');
    }

    // Admin Edit Form
    public function edit($id)
    {
        $orangHilang = OrangHilang::findOrFail($id);
        return view('admin.orang_hilang.edit', compact('orangHilang'));
    }

    // Admin Update
    public function update(Request $request, $id)
    {
        $orangHilang = OrangHilang::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer|min:1',
            'lokasi_terakhir' => 'required|string|max:255',
            'tanggal_hilang' => 'required|date',
            'deskripsi_terakhir' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:belum ditemukan,ditemukan',
            'kontak_keluarga' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($orangHilang->foto) {
                Storage::disk('public')->delete($orangHilang->foto);
            }
            $data['foto'] = $request->file('foto')->store('orang_hilang', 'public');
        }

        $orangHilang->update($data);

        return redirect()->route('admin.orang-hilang.index')->with('success', 'Data orang hilang berhasil diperbarui!');
    }

    // Admin Delete
    public function destroy($id)
    {
        $orangHilang = OrangHilang::findOrFail($id);

        if ($orangHilang->foto) {
            Storage::disk('public')->delete($orangHilang->foto);
        }

        $orangHilang->delete();

        return redirect()->route('admin.orang-hilang.index')->with('success', 'Data orang hilang berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use Illuminate\Http\Request;

class BlacklistController extends Controller
{
    public function index()
    {
        $blacklist = Blacklist::all();
        return view('admin.blacklist.index', compact('blacklist'));
    }

    public function create()
    {
        return view('admin.blacklist.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:20|unique:blacklist,no_ktp',
            'alasan' => 'required|string',
        ]);

        Blacklist::create($data);

        return redirect()->route('admin.blacklist.index')->with('success', 'Data blacklist berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $blacklist = Blacklist::findOrFail($id);
        return view('admin.blacklist.edit', compact('blacklist'));
    }

    public function update(Request $request, $id)
    {
        $blacklist = Blacklist::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:20|unique:blacklist,no_ktp,' . $blacklist->id,
            'alasan' => 'required|string',
        ]);

        $blacklist->update($data);

        return redirect()->route('admin.blacklist.index')->with('success', 'Data blacklist berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Blacklist::findOrFail($id)->delete();
        return redirect()->route('admin.blacklist.index')->with('success', 'Data blacklist berhasil dihapus!');
    }
}

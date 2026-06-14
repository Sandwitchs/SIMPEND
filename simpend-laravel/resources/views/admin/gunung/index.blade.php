@extends('layouts.admin')

@section('title', 'Data Gunung')

@section('content')
<h1 style="margin-bottom: 24px;">Manajemen Data Gunung</h1>

<a href="{{ route('admin.gunung.create') }}" class="btn btn-primary" style="margin-bottom: 16px;">+ Tambah Gunung</a>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Nama Gunung</th>
                <th>Jalur</th>
                <th>Kuota Maks</th>
                <th>Harga Camp</th>
                <th>Harga Tektok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gunung as $g)
            <tr>
                <td><strong>{{ $g->nama_gunung }}</strong></td>
                <td>{{ $g->jalur }}</td>
                <td>{{ $g->kuota_maks }} orang</td>
                <td>Rp {{ number_format($g->harga_per_orang, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($g->harga_per_orang_tektok, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('admin.gunung.edit', $g->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.gunung.destroy', $g->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

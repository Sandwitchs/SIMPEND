@extends('layouts.admin')

@section('title', 'Daftar Blacklist')

@section('content')
<h1 style="margin-bottom: 24px;">Manajemen Daftar Hitam (Blacklist)</h1>

<a href="{{ route('admin.blacklist.create') }}" class="btn btn-primary" style="margin-bottom: 16px;">+ Tambah Blacklist</a>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>No. KTP</th>
                <th>Alasan</th>
                <th>Tanggal Blacklist</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($blacklist as $b)
            <tr>
                <td><strong>{{ $b->nama }}</strong></td>
                <td>{{ $b->no_ktp }}</td>
                <td>{{ $b->alasan }}</td>
                <td>{{ $b->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('admin.blacklist.edit', $b->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.blacklist.destroy', $b->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus dari blacklist?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #6b7280; padding: 24px;">Tidak ada data pendaki yang di-blacklist.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Daftar Orang Hilang')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h1>Manajemen Orang Hilang</h1>
    <a href="{{ route('admin.orang-hilang.create') }}" class="btn btn-primary">+ Tambah Data</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Umur</th>
                <th>Lokasi Terakhir</th>
                <th>Tanggal Hilang</th>
                <th>Kontak Keluarga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orangHilang as $oh)
            <tr>
                <td><strong>{{ $oh->nama }}</strong></td>
                <td>{{ $oh->umur }} th</td>
                <td>{{ $oh->lokasi_terakhir }}</td>
                <td>{{ $oh->tanggal_hilang->format('d/m/Y') }}</td>
                <td>{{ $oh->kontak_keluarga ?? '-' }}</td>
                <td>
                    @if($oh->status == 'belum ditemukan')
                        <span class="badge badge-pending">BELUM DITEMUKAN</span>
                    @else
                        <span class="badge badge-disetujui">DITEMUKAN</span>
                    @endif
                </td>
                <td style="display: flex; gap: 6px;">
                    <a href="{{ route('admin.orang-hilang.edit', $oh->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.orang-hilang.destroy', $oh->id) }}" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #6b7280; padding: 32px;">
                    👤 Belum ada data orang hilang.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

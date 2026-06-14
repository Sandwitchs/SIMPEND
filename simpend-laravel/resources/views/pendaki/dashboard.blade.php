@extends('layouts.app')

@section('title', 'Dashboard Pendaki')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h1>Dashboard Pendaki</h1>
    <a href="{{ route('pendaki.pendaftaran.create') }}" class="btn btn-primary">+ Daftar Pendakian Baru</a>
</div>

<div class="card">
    <h2 style="margin-bottom: 16px;">Riwayat Pendaftaran</h2>
    @if($pendaftaran->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>ID Booking</th>
                <th>Gunung & Jalur</th>
                <th>Tanggal Pendakian</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftaran as $p)
            <tr>
                <td><strong>{{ $p->id_booking }}</strong></td>
                <td>{{ $p->gunung->nama_gunung }} ({{ $p->gunung->jalur }})</td>
                <td>{{ date('d/m/Y', strtotime($p->tanggal_pendakian)) }}</td>
                <td><span class="badge badge-{{ $p->status_verifikasi }}">{{ strtoupper($p->status_verifikasi) }}</span></td>
                <td>
                    <a href="{{ route('pendaki.pendaftaran.show', $p->id) }}" class="btn btn-primary btn-sm">Detail</a>
                    @if($p->status_verifikasi == 'pending')
                    <a href="{{ route('pendaki.pendaftaran.edit', $p->id) }}" class="btn btn-success btn-sm">Edit</a>
                    <form method="POST" action="{{ route('pendaki.pendaftaran.cancel', $p->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan?')">Batal</button>
                    </form>
                    @endif
                    @if($p->status_verifikasi == 'disetujui')
                    <a href="{{ route('pendaki.pendaftaran.cetak', $p->id) }}" class="btn btn-success btn-sm" target="_blank">Cetak</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Belum ada pendaftaran. <a href="{{ route('pendaki.pendaftaran.create') }}">Daftar sekarang</a>!</p>
    @endif
</div>
@endsection
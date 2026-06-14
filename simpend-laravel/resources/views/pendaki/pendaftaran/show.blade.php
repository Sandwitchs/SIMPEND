@extends('layouts.app')

@section('title', 'Detail Pendaftaran')

@section('content')
<h1 style="margin-bottom: 24px;">Detail Pendaftaran {{ $pendaftaran->id_booking }}</h1>

<div class="card" style="margin-bottom: 16px;">
    <h3 style="margin-bottom: 16px;">Informasi Pendaftaran</h3>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div><strong>Nama Ketua:</strong> {{ $pendaftaran->nama_ketua }}</div>
        <div><strong>Tanggal Pendakian:</strong> {{ date('d/m/Y', strtotime($pendaftaran->tanggal_pendakian)) }}</div>
        <div><strong>Gunung & Jalur:</strong> {{ $pendaftaran->gunung->nama_gunung }} ({{ $pendaftaran->gunung->jalur }})</div>
        <div><strong>Jumlah Anggota:</strong> {{ $pendaftaran->jumlah_anggota }}</div>
        <div><strong>Jenis Pendakian:</strong> {{ strtoupper($pendaftaran->jenis_pendakian) }}</div>
        <div><strong>Total Harga:</strong> Rp {{ number_format($pendaftaran->total_harga, 0, ',', '.') }}</div>
        <div><strong>Status Verifikasi:</strong> <span class="badge badge-{{ $pendaftaran->status_verifikasi }}">{{ strtoupper($pendaftaran->status_verifikasi) }}</span></div>
        <div><strong>Status Pembayaran:</strong> 
            @if($pendaftaran->status_pembayaran == 'paid')
                <span class="badge badge-disetujui">LUNAS</span>
            @elseif($pendaftaran->status_pembayaran == 'pending')
                <span class="badge badge-pending">MENUNGGU PEMBAYARAN</span>
            @elseif($pendaftaran->status_pembayaran == 'failed')
                <span class="badge badge-ditolak">GAGAL</span>
            @elseif($pendaftaran->status_pembayaran == 'expired')
                <span class="badge badge-ditolak">KADALUARSA</span>
            @endif
        </div>
        <div><strong>Waktu Daftar:</strong> {{ $pendaftaran->created_at->format('d/m/Y H:i') }}</div>
    </div>
    @if($pendaftaran->alasan_penolakan)
    <div style="margin-top: 16px; background: #fee2e2; padding: 16px; border-radius: 8px;">
        <strong>Alasan Penolakan:</strong><br>
        {{ $pendaftaran->alasan_penolakan }}
    </div>
    @endif
    <div style="margin-top: 16px;">
        <strong>Dokumen KTP:</strong> <a href="{{ route('document.secure', ['type' => 'ktp', 'id' => $pendaftaran->id]) }}" target="_blank">Lihat Dokumen</a><br>
        <strong>Dokumen Sehat:</strong> <a href="{{ route('document.secure', ['type' => 'sehat', 'id' => $pendaftaran->id]) }}" target="_blank">Lihat Dokumen</a>
    </div>
</div>

<div class="card" style="margin-bottom: 16px;">
    <h3 style="margin-bottom: 16px;">Daftar Anggota</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>No. KTP</th>
                <th>Usia</th>
                <th>No. HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftaran->anggota as $a)
            <tr>
                <td>{{ $a->nama }}</td>
                <td>{{ $a->no_ktp }}</td>
                <td>{{ $a->usia }}</td>
                <td>{{ $a->no_hp }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="display: flex; gap: 8px; flex-wrap: wrap;">
    <a href="{{ route('pendaki.dashboard') }}" class="btn btn-outline">← Kembali ke Dashboard</a>
    @if($pendaftaran->status_pembayaran == 'pending')
    <a href="{{ route('pendaki.pendaftaran.payment', $pendaftaran->id) }}" class="btn btn-success">💳 Bayar Sekarang</a>
    <form method="POST" action="{{ route('pendaki.pendaftaran.payment.check', $pendaftaran->id) }}" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-primary">🔄 Cek Status Pembayaran</button>
    </form>
    @endif
    @if($pendaftaran->status_verifikasi == 'pending')
    <a href="{{ route('pendaki.pendaftaran.edit', $pendaftaran->id) }}" class="btn btn-primary">Edit Pendaftaran</a>
    <form method="POST" action="{{ route('pendaki.pendaftaran.cancel', $pendaftaran->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin membatalkan?')">Batalkan Pendaftaran</button>
    </form>
    @endif
    @if($pendaftaran->status_verifikasi == 'disetujui' && $pendaftaran->status_pembayaran == 'paid')
    <a href="{{ route('pendaki.pendaftaran.cetak', $pendaftaran->id) }}" class="btn btn-success" target="_blank">🖨️ Cetak Bukti Pendaftaran</a>
    @endif
</div>
@endsection
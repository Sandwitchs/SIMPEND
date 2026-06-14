@extends('layouts.admin')

@section('title', 'Cetak Manifes Pendaki')

@section('content')
<style>
    .filter-card {
        background: rgba(17, 24, 39, 0.75);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        padding: 24px;
        margin-bottom: 24px;
    }
    .filter-grid {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 16px;
        align-items: flex-end;
    }
    .manifes-header {
        display: none;
        text-align: center;
        margin-bottom: 24px;
        border-bottom: 3px double #1e293b;
        padding-bottom: 12px;
    }
    .manifes-header h1 {
        font-size: 24px;
        color: #1f2937;
        margin-bottom: 4px;
    }
    .manifes-header p {
        color: #4b5563;
        font-size: 14px;
    }
    .no-print-btn {
        margin-bottom: 16px;
    }
    
    h1 {
        background: linear-gradient(135deg, #ffffff, #9ca3af);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    @media print {
        body {
            background: white !important;
            color: black !important;
        }
        .sidebar, .filter-card, .no-print-btn, form, header, footer {
            display: none !important;
        }
        .main {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }
        .card {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
            color: black !important;
        }
        .manifes-header {
            display: block !important;
        }
        .table {
            border: 1px solid #000 !important;
        }
        .table th, .table td {
            border: 1px solid #000 !important;
            padding: 8px !important;
            font-size: 12px !important;
            color: black !important;
            background: transparent !important;
        }
        .badge {
            border: 1px solid #000 !important;
            background: transparent !important;
            color: black !important;
            padding: 2px 6px !important;
        }
    }
</style>

<div class="no-print-btn">
    <h1 style="margin-bottom: 8px; font-weight: 800; font-size: 28px;">📋 Cetak Manifes Pendaki</h1>
    <p style="color: #9ca3af; margin-bottom: 24px;">Pilih tanggal pendakian dan gunung untuk menyaring dan mencetak manifes resmi.</p>
</div>

<div class="filter-card">
    <form action="{{ route('admin.manifes') }}" method="GET">
        <div class="filter-grid">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="tanggal">Tanggal Pendakian</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ $filterTanggal ?? date('Y-m-d') }}" required>
            </div>
            
            <div class="form-group" style="margin-bottom: 0;">
                <label for="gunung_id">Gunung & Jalur</label>
                <select id="gunung_id" name="gunung_id" required>
                    <option value="">-- Pilih Gunung --</option>
                    @foreach($gunung as $g)
                        <option value="{{ $g->id }}" {{ (isset($filterGunung) && $filterGunung == $g->id) ? 'selected' : '' }}>
                            {{ $g->nama_gunung }} ({{ $g->jalur }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary" style="height: 42px; padding: 0 24px;">🔍 Filter</button>
        </div>
    </form>
</div>

@if($filterTanggal && $filterGunung)
    @php
        $selectedGunung = $gunung->firstWhere('id', $filterGunung);
    @endphp
    
    <div class="manifes-header">
        <h1>MANIFES RESMI PENDAKIAN GUNUNG</h1>
        <p><strong>SIMPEND (Sistem Informasi Pendaftaran Pendakian)</strong></p>
        <p style="margin-top: 8px; font-size: 15px;">
            Gunung: <strong>{{ $selectedGunung ? $selectedGunung->nama_gunung : '-' }} (Jalur {{ $selectedGunung ? $selectedGunung->jalur : '-' }})</strong> 
            &nbsp;|&nbsp; 
            Tanggal: <strong>{{ date('d F Y', strtotime($filterTanggal)) }}</strong>
        </p>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;" class="no-print-btn">
            <h2 style="font-size: 18px; font-weight: 700; color: #ffffff;">Hasil Filter: {{ $pendaftaran->count() }} Rombongan Terdaftar</h2>
            @if($pendaftaran->count() > 0)
                <button onclick="window.print()" class="btn btn-success">🖨️ Cetak Manifes (PDF / Kertas)</button>
            @endif
        </div>
        
        @if($pendaftaran->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>ID Booking</th>
                        <th>Nama Ketua</th>
                        <th>Jenis</th>
                        <th>Jumlah Anggota</th>
                        <th>Status Pendakian</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaran as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $p->id_booking }}</strong></td>
                            <td>
                                {{ $p->nama_ketua }}
                                <div style="font-size: 11px; color: #9ca3af;" class="no-print-btn">
                                    NIK: {{ $p->anggota[0]->no_ktp ?? '-' }}
                                </div>
                            </td>
                            <td>{{ ucfirst($p->jenis_pendakian) }}</td>
                            <td>{{ $p->jumlah_anggota }} Orang</td>
                            <td>
                                @if($p->status_pendakian == 'belum_mendaki')
                                    <span class="badge" style="background: rgba(255, 255, 255, 0.08); color: #d1d5db; border: 1px solid rgba(255, 255, 255, 0.15);">Belum Naik</span>
                                @elseif($p->status_pendakian == 'sedang_mendaki')
                                    <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);">Di Gunung</span>
                                @elseif($p->status_pendakian == 'selesai')
                                    <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);">Sudah Turun</span>
                                @elseif($p->is_overdue)
                                    <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3);">Overdue (Terlambat)</span>
                                @else
                                    <span class="badge" style="background: rgba(255, 255, 255, 0.08); color: #d1d5db;">{{ $p->status_pendakian }}</span>
                                @endif
                            </td>
                            <td>{{ $p->tanggal_check_in ? date('d/m/Y H:i', strtotime($p->tanggal_check_in)) : '-' }}</td>
                            <td>{{ $p->tanggal_check_out ? date('d/m/Y H:i', strtotime($p->tanggal_check_out)) : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align: center; padding: 40px 20px; color: #9ca3af;">
                <div style="font-size: 48px; margin-bottom: 12px;">🔍</div>
                <h3>Tidak ada data manifes pendaki untuk tanggal dan gunung yang dipilih.</h3>
                <p style="margin-top: 4px;">Pastikan pendaftaran pendaki telah disetujui (Approved) oleh admin.</p>
            </div>
        @endif
    </div>
@else
    <div class="card" style="text-align: center; padding: 60px 20px; color: #9ca3af;">
        <div style="font-size: 64px; margin-bottom: 16px;">📋</div>
        <h2>Silakan pilih Tanggal Pendakian dan Gunung terlebih dahulu.</h2>
        <p style="margin-top: 8px;">Gunakan form filter di atas untuk menampilkan daftar manifes.</p>
    </div>
@endif

@endsection

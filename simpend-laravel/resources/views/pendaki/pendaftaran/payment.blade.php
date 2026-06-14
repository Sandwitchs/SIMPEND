@extends('layouts.app')

@section('title', 'Pembayaran Pendaftaran')

@section('content')
<h1 style="margin-bottom: 24px;">Pembayaran Pendaftaran {{ $pendaftaran->id_booking }}</h1>

<div class="card">
    <h3 style="margin-bottom: 16px;">Detail Pembayaran</h3>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
        <div><strong>ID Booking:</strong> {{ $pendaftaran->id_booking }}</div>
        <div><strong>Total Harga:</strong> Rp {{ number_format($pendaftaran->total_harga, 0, ',', '.') }}</div>
        <div><strong>Gunung & Jalur:</strong> {{ $pendaftaran->gunung->nama_gunung }} ({{ $pendaftaran->gunung->jalur }})</div>
        <div><strong>Tanggal Pendakian:</strong> {{ date('d/m/Y', strtotime($pendaftaran->tanggal_pendakian)) }}</div>
        <div><strong>Jumlah Anggota:</strong> {{ $pendaftaran->jumlah_anggota }} orang</div>
    </div>
    
    <button id="pay-button" class="btn btn-primary btn-lg" style="width: 100%; font-size: 18px;">Bayar Sekarang</button>
    <div style="margin-top: 16px; text-align: center;">
        <a href="{{ route('pendaki.pendaftaran.show', $pendaftaran->id) }}" class="btn btn-outline">Kembali</a>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                window.location.href = '{{ route('pendaki.pendaftaran.payment.success', $pendaftaran->id) }}';
            },
            onPending: function(result){
                window.location.href = '{{ route('pendaki.pendaftaran.show', $pendaftaran->id) }}';
            },
            onError: function(result){
                window.location.href = '{{ route('pendaki.pendaftaran.show', $pendaftaran->id) }}';
            },
            onClose: function(){
                window.location.href = '{{ route('pendaki.pendaftaran.show', $pendaftaran->id) }}';
            }
        });
    };
</script>
@endsection

@extends('layouts.app')

@section('title', 'Notifikasi Saya')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h1>Pemberitahuan / Notifikasi</h1>
    @if(Auth::user()->unreadNotifications->count() > 0)
    <form method="POST" action="{{ route('pendaki.notifications.readAll') }}">
        @csrf
        <button type="submit" class="btn btn-outline btn-sm">✓ Tandai Semua Terbaca</button>
    </form>
    @endif
</div>

<div class="card">
    @forelse($notifications as $notification)
        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: start; gap: 12px; background: {{ $notification->unread() ? '#eff6ff' : 'white' }};">
            <div style="font-size: 20px;">
                @if($notification->data['type'] == 'disetujui' || $notification->data['type'] == 'check_out')
                    🟢
                @elseif($notification->data['type'] == 'ditolak')
                    🔴
                @else
                    🔵
                @endif
            </div>
            <div style="flex: 1;">
                <div style="font-weight: {{ $notification->unread() ? '700' : 'normal' }}; color: #1f2937;">
                    {{ $notification->data['message'] }}
                </div>
                <div style="font-size: 12px; color: #6b7280; margin-top: 4px; display: flex; justify-content: space-between; align-items: center;">
                    <span>{{ $notification->created_at->diffForHumans() }} ({{ $notification->created_at->format('d/m/Y H:i') }})</span>
                    <a href="{{ route('pendaki.pendaftaran.show', $notification->data['pendaftaran_id']) }}" style="color: #2563eb; text-decoration: none; font-weight: 600;">Lihat Detail Booking →</a>
                </div>
            </div>
        </div>
    @empty
        <div style="text-align: center; color: #6b7280; padding: 32px;">
            Belum ada notifikasi untuk Anda.
        </div>
    @endforelse
</div>
@endsection

@extends('layouts.app')

@section('content')
@include('partials.ledger-style')

<div class="container" style="max-width: 700px; margin-top: 20px; margin-bottom: 40px;">
<div class="ledger-page">

    <a href="{{ route('setoran.index') }}" class="lg-back">&larr; Kembali</a>

    @if(session('success'))
        <div class="lg-alert lg-alert-success">{{ session('success') }}</div>
    @endif

    <div class="lg-section" style="position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap;">
            <div>
                <div class="lg-eyebrow">Ayat {{ $setoran->ayat_mulai }}&ndash;{{ $setoran->ayat_selesai }}</div>
                <p class="lg-surah-name" style="font-size: 28px;">{{ $setoran->surah->nama_latin ?? '-' }}</p>
                <p class="lg-subtitle">
                    Disetor oleh <b>{{ $setoran->santri->name }}</b> pada {{ $setoran->created_at->format('d M Y, H:i') }}
                </p>
            </div>
            <div class="lg-stamp-wrap">
                @if($setoran->status === 'dinilai')
                    <div class="lg-stamp lg-dinilai lg-large">
                        <span class="lg-score">{{ $setoran->nilai->nilai_total }}</span>
                        <span class="lg-label">dinilai</span>
                    </div>
                @else
                    <div class="lg-stamp lg-menunggu lg-large">
                        <span class="lg-label">menunggu<br>dinilai</span>
                    </div>
                @endif
            </div>
        </div>

        @if($setoran->catatan)
            <p class="lg-catatan" style="margin-top: 16px;">Catatan santri: "{{ $setoran->catatan }}"</p>
        @endif

        <audio controls>
            <source src="{{ asset('storage/' . $setoran->audio_path) }}" type="audio/webm">
            Browser Anda tidak mendukung pemutar audio.
        </audio>
    </div>

    @if($setoran->nilai)
        <div class="lg-section">
            <p class="lg-section-title">Hasil penilaian</p>
            <table class="lg-nilai-table">
                <tr><td>Kelancaran</td><td>{{ $setoran->nilai->kelancaran }}</td></tr>
                <tr><td>Tajwid</td><td>{{ $setoran->nilai->tajwid }}</td></tr>
                <tr><td>Makhraj</td><td>{{ $setoran->nilai->makhraj }}</td></tr>
                <tr><td><b>Nilai akhir</b></td><td>{{ $setoran->nilai->nilai_total }}</td></tr>
            </table>
            @if($setoran->nilai->catatan)
                <p class="lg-catatan">Catatan guru: "{{ $setoran->nilai->catatan }}"</p>
            @endif
            <p style="font-size: 12px; color: var(--lg-ink-soft);">Dinilai oleh {{ $setoran->nilai->guru->name }}</p>
        </div>
    @else
        <div class="lg-alert lg-alert-info">Setoran ini belum dinilai.</div>
        @if(auth()->user()->hasRole('guru'))
            <a href="{{ route('nilai.create', $setoran->id) }}" class="lg-btn lg-btn-solid">Beri nilai</a>
        @endif
    @endif

</div>
</div>
@endsection
@extends('layouts.app')

@section('content')
@include('partials.ledger-style')

<div class="container" style="max-width: 780px; margin-top: 20px; margin-bottom: 40px;">
<div class="ledger-page">

    <div class="lg-eyebrow">Guru · Penilaian</div>
    <div class="lg-header-row">
        <div>
            <h1 class="lg-title">Setoran Menunggu Nilai</h1>
            <p class="lg-subtitle">Daftar setoran hafalan santri yang belum dinilai.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="lg-alert lg-alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="lg-ledger">
        @forelse($setorans as $setoran)
            <div class="lg-card">
                <div class="lg-card-main">
                    <p class="lg-surah-name">{{ $setoran->surah }}</p>
                    <div class="lg-meta-row">
                        @if($setoran->ayat_mulai && $setoran->ayat_selesai)
                            <span>Ayat <b>{{ $setoran->ayat_mulai }}&ndash;{{ $setoran->ayat_selesai }}</b></span>
                        @endif
                        <span>{{ $setoran->created_at->format('d M Y') }}</span>
                        <span>Santri <b>{{ $setoran->santri->name }}</b></span>
                    </div>
                    <p class="lg-catatan">
                        {{ $setoran->catatan ? '"'.$setoran->catatan.'"' : 'Belum ada catatan.' }}
                    </p>
                    <a href="{{ route('nilai.create', $setoran->id) }}" class="lg-detail-link">
                        Beri nilai &rarr;
                    </a>
                </div>
                <div class="lg-stamp-wrap">
                    <div class="lg-stamp lg-menunggu">
                        <span class="lg-label">menunggu<br>dinilai</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="lg-empty">Semua setoran sudah dinilai. 🎉</div>
        @endforelse
    </div>

    <div>{{ $setorans->links() }}</div>

</div>
</div>
@endsection
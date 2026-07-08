@extends('layouts.app')

@section('content')
@include('partials.ledger-style')

<div class="container" style="max-width: 900px; margin-top: 20px; margin-bottom: 40px;">
<div class="ledger-page">

    <div class="lg-eyebrow">Antrian penilaian</div>
    <h1 class="lg-title" style="font-size: 28px;">Penilaian Setoran</h1>
    <p class="lg-subtitle" style="margin-bottom: 24px;">Daftar setoran santri yang belum dinilai.</p>

    <div class="lg-ledger">
        @forelse ($setorans as $setoran)
            <div class="lg-card">
                <div class="lg-card-main">
                    <p class="lg-surah-name">{{ $setoran->surah->nama_latin ?? '-' }}</p>
                    <div class="lg-meta-row">
                        <span>Ayat <b>{{ $setoran->ayat_mulai }}&ndash;{{ $setoran->ayat_selesai }}</b></span>
                        <span>{{ $setoran->created_at->format('d M Y, H:i') }}</span>
                        <span>Santri <b>{{ $setoran->santri->name }}</b></span>
                    </div>
                </div>
                <div class="lg-stamp-wrap">
                    <a href="{{ route('nilai.create', $setoran->id) }}" class="lg-btn lg-btn-solid">Nilai sekarang</a>
                </div>
            </div>
        @empty
            <div class="lg-empty">Tidak ada setoran yang menunggu penilaian.</div>
        @endforelse
    </div>

    <div>{{ $setorans->links() }}</div>

</div>
</div>
@endsection
@extends('layouts.app')

@section('content')
@include('partials.ledger-style')

<div class="container" style="max-width: 900px; margin-top: 20px; margin-bottom: 40px;">
<div class="ledger-page">

    <div class="lg-header-row">
        <div>
            <div class="lg-eyebrow">
                Buku catatan &middot; {{ auth()->user()->hasRole('guru') ? 'seluruh santri' : auth()->user()->name }}
            </div>
            <h1 class="lg-title">Setoran Hafalan</h1>
            <p class="lg-subtitle">
                @if(auth()->user()->hasRole('guru'))
                    Pantau riwayat setoran hafalan santri dan beri penilaian.
                @else
                    Rekam bacaanmu, kirim untuk dikoreksi, dan lihat catatan penilaian dari ustadz pembimbing.
                @endif
            </p>
        </div>
        <div class="lg-actions">
            @if(auth()->user()->hasRole('santri'))
                <a href="{{ route('setoran.progress') }}" class="lg-btn lg-btn-ghost">Progress saya</a>
                <a href="{{ route('setoran.create') }}" class="lg-btn lg-btn-solid">+ Setor hafalan</a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="lg-alert lg-alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="lg-alert lg-alert-info">{{ session('info') }}</div>
    @endif

    <div class="lg-tabs">
        <a href="{{ route('setoran.index') }}" class="lg-tab {{ request('status') ? '' : 'active' }}">Semua</a>
        <a href="{{ route('setoran.index', ['status' => 'menunggu']) }}" class="lg-tab {{ request('status') === 'menunggu' ? 'active' : '' }}">Menunggu</a>
        <a href="{{ route('setoran.index', ['status' => 'dinilai']) }}" class="lg-tab {{ request('status') === 'dinilai' ? 'active' : '' }}">Dinilai</a>
    </div>

    <div class="lg-ledger">
        @forelse ($setorans as $setoran)
            <div class="lg-card">
                <div class="lg-card-main">
                    <p class="lg-surah-name">{{ $setoran->surah->nama_latin ?? '-' }}</p>
                    <div class="lg-meta-row">
                        <span>Ayat <b>{{ $setoran->ayat_mulai }}&ndash;{{ $setoran->ayat_selesai }}</b></span>
                        <span>{{ $setoran->created_at->format('d M Y') }}</span>
                        @if(auth()->user()->hasRole('guru'))
                            <span>Santri <b>{{ $setoran->santri->name }}</b></span>
                        @endif
                    </div>
                    <p class="lg-catatan">{{ $setoran->catatan ? '"'.$setoran->catatan.'"' : 'Belum ada catatan tambahan.' }}</p>
                    <a href="{{ route('setoran.show', $setoran->id) }}" class="lg-detail-link">Lihat detail &rarr;</a>
                    @if(auth()->user()->hasRole('guru') && $setoran->status !== 'dinilai')
                        &nbsp;&middot;&nbsp;
                        <a href="{{ route('nilai.create', $setoran->id) }}" class="lg-detail-link">Beri nilai &rarr;</a>
                    @endif
                </div>
                <div class="lg-stamp-wrap">
                    @if($setoran->status === 'dinilai')
                        <div class="lg-stamp lg-dinilai">
                            <span class="lg-score">{{ $setoran->nilai->nilai_total }}</span>
                            <span class="lg-label">dinilai</span>
                        </div>
                    @else
                        <div class="lg-stamp lg-menunggu">
                            <span class="lg-label">menunggu<br>dinilai</span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="lg-empty">Belum ada data setoran.</div>
        @endforelse
    </div>

    <div>{{ $setorans->withQueryString()->links() }}</div>

</div>
</div>
@endsection
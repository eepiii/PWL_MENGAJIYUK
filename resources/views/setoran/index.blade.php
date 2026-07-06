@extends('layouts.app')

@section('content')
@include('partials.ledger-style')

            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">
                    {{ Auth::user()->role === 'guru' ? 'Semua Setoran Santri' : 'Riwayat Setoran Saya' }}
                </h2>

                @if(Auth::user()->role === 'santri')
                    <a href="{{ route('setoran.create') }}"
                       class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow">
                        + Tambah Setoran Baru
                    </a>
                @endif
            </div>

            {{-- Konten --}}
            @if($setorans->isEmpty())
                <div class="text-center py-10 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-gray-500 font-semibold mb-2">Belum ada rekaman setoran.</p>
                    <p class="text-sm text-gray-400">Silakan buat setoran hafalan pertama Anda.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($setorans as $setoran)
                        <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow bg-gray-50">

                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-bold text-lg text-indigo-700">
                                        {{ $setoran->surah }}
                                    </h3>

                                    @if(Auth::user()->role === 'guru')
                                        <p class="text-sm font-semibold text-gray-800">
                                            Santri: {{ $setoran->santri->name }}
                                        </p>
                                    @endif

                                    <p class="text-xs text-gray-500">
                                        {{ $setoran->created_at->format('d M Y - H:i') }} WIB
                                    </p>
                                </div>

                                {{-- Status Badge --}}
                                <span class="text-xs px-3 py-1 rounded-full font-medium
                                    {{ $setoran->status === 'sudah_dinilai'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $setoran->status === 'sudah_dinilai' ? '✅ Dinilai' : '⏳ Pending' }}
                                </span>
                            </div>

                            {{-- Audio --}}
                            @if($setoran->audio_path)
                                <div class="my-4">
                                    <audio controls class="w-full h-10">
                                        <source src="{{ asset('storage/' . $setoran->audio_path) }}"
                                                type="audio/webm">
                                        Browser Anda tidak mendukung pemutar audio ini.
                                    </audio>
                                </div>
                            @endif

                            {{-- Catatan --}}
                            @if($setoran->catatan)
                                <div class="bg-white p-3 rounded border border-gray-100 text-sm text-gray-600">
                                    <span class="font-semibold block mb-1">Catatan:</span>
                                    {{ $setoran->catatan }}
                                </div>
                            @endif

                            {{-- Tombol Nilai (khusus guru) --}}
                            @if(Auth::user()->role === 'guru')
                                <div class="mt-4">
                                    <a href="{{ route('nilai.create', $setoran->id) }}"
                                       class="bg-blue-600 hover:bg-blue-700 text-white text-sm
                                              font-semibold py-2 px-4 rounded-lg w-full block text-center">
                                        {{ $setoran->status === 'sudah_dinilai' ? 'Lihat / Edit Nilai' : 'Beri Nilai' }}
                                    </a>
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>
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
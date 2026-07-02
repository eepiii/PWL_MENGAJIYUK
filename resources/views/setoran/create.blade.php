@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">
                    @if(Auth::user()->role === 'guru')
                        Riwayat Setoran Santri
                    @else
                        Riwayat Setoran Saya
                    @endif
                </h2>

                @if(Auth::user()->role === 'santri')
                    <a href="{{ route('setoran.create') }}"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow">
                        + Setor Hafalan Baru
                    </a>
                    <a href="{{ route('setoran.progress') }}"
                       class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-lg shadow">
                        Lihat Progress
                    </a>
                @endif
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 rounded bg-green-100 text-green-700 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            @if($setorans->isEmpty())
                <p class="text-gray-500 text-center py-8">Belum ada setoran hafalan.</p>
            @else
                <div class="space-y-4">
                    @foreach($setorans as $setoran)
                        <div class="border rounded-lg p-4 {{ $setoran->status === 'sudah_dinilai' ? 'bg-green-50 border-green-200' : 'bg-yellow-50 border-yellow-200' }}">

                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $setoran->surah }}</p>

                                    @if(Auth::user()->role === 'guru')
                                        <p class="text-sm text-gray-500">
                                            Santri: {{ $setoran->santri->name ?? '-' }}
                                        </p>
                                    @endif

                                    <p class="text-xs text-gray-400">
                                        {{ $setoran->tanggal_setoran->format('d M Y, H:i') }}
                                    </p>
                                </div>

                                <span class="text-xs font-bold px-3 py-1 rounded-full
                                    {{ $setoran->status === 'sudah_dinilai' ? 'bg-green-600 text-white' : 'bg-yellow-500 text-white' }}">
                                    {{ $setoran->status === 'sudah_dinilai' ? 'Sudah Dinilai' : 'Belum Dinilai' }}
                                </span>
                            </div>

                            @if($setoran->audio_path)
                                <audio controls class="w-full mt-2">
                                    <source src="{{ asset('storage/' . $setoran->audio_path) }}">
                                    Browser Anda tidak mendukung audio player.
                                </audio>
                            @endif

                            @if($setoran->catatan)
                                <p class="text-sm text-gray-600 mt-2 italic">"{{ $setoran->catatan }}"</p>
                            @endif

                            {{-- Tampilkan nilai kalau sudah dinilai --}}
                            @if($setoran->status === 'sudah_dinilai' && $setoran->nilaiHafalan)
                                <div class="mt-3 pt-3 border-t border-gray-200 grid grid-cols-4 gap-2 text-center">
                                    <div>
                                        <p class="text-xs text-gray-400">Kelancaran</p>
                                        <p class="font-bold text-gray-700">{{ $setoran->nilaiHafalan->kelancaran }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Tajwid</p>
                                        <p class="font-bold text-gray-700">{{ $setoran->nilaiHafalan->tajwid }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Makhraj</p>
                                        <p class="font-bold text-gray-700">{{ $setoran->nilaiHafalan->makhraj }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Nilai Akhir</p>
                                        <p class="font-bold text-indigo-600 text-lg">{{ $setoran->nilaiHafalan->nilai_total }}</p>
                                    </div>
                                </div>
                                @if($setoran->nilaiHafalan->catatan)
                                    <p class="text-sm text-gray-600 mt-2">
                                        <span class="font-bold">Catatan Guru:</span> {{ $setoran->nilaiHafalan->catatan }}
                                    </p>
                                @endif
                            @endif

                            {{-- Tombol nilai untuk guru --}}
                            @if(Auth::user()->role === 'guru' && $setoran->status === 'belum_dinilai')
                                <div class="mt-3">
                                    <a href="{{ route('nilai.create', $setoran->id) }}"
                                       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded-lg shadow">
                                        Beri Penilaian
                                    </a>
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $setorans->links() }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
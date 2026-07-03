@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

        <div>
    <h3 class="font-bold text-lg text-indigo-700">{{ $setoran->surah }}</h3>
    
    @if(Auth::user()->role === 'guru')
        <p class="text-sm font-semibold text-gray-800">Santri: {{ $setoran->santri->name }}</p>
    @endif
    
    <p class="text-xs text-gray-500">{{ $setoran->created_at->format('d M Y - H:i') }} WIB</p>
</div>
            
            @if(Auth::user()->role === 'santri')
    <a href="{{ route('setoran.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow">
        + Tambah Setoran Baru
    </a>
@endif
            
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
                                    <h3 class="font-bold text-lg text-indigo-700">{{ $setoran->surah }}</h3>
                                    <p class="text-xs text-gray-500">{{ $setoran->created_at->format('d M Y - H:i') }} WIB</p>
                                </div>
                            </div>

                            <div class="my-4">
                                <audio controls class="w-full h-10">
                                    <source src="{{ asset('storage/' . $setoran->audio_path) }}" type="audio/webm">
                                    Browser Anda tidak mendukung pemutar audio ini.
                                </audio>
                            </div>

                            @if($setoran->catatan)
                                <div class="bg-white p-3 rounded border border-gray-100 text-sm text-gray-600">
                                    <span class="font-semibold block mb-1">Catatan:</span>
                                    {{ $setoran->catatan }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
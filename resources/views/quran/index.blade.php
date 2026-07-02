<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Baca Al-Quran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @foreach ($surahs as $surah)
                    <a href="{{ route('quran.show', $surah->nomor_surah) }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-indigo-50 transition duration-150 ease-in-out border border-gray-200 block">
                        <div class="p-6 text-gray-900 flex justify-between items-center">
                            
                            <div class="flex items-center space-x-4">
                                <div class="bg-indigo-100 text-indigo-800 font-bold w-12 h-12 flex items-center justify-center rounded-full text-lg">
                                    {{ $surah->nomor_surah }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg">{{ $surah->nama_latin }}</h3>
                                    <p class="text-sm text-gray-500">
                                        {{ $surah->arti }} • {{ $surah->jumlah_ayat }} Ayat
                                    </p>
                                </div>
                            </div>

                            <div class="text-2xl font-bold text-right text-gray-800" dir="rtl">
                                {{ $surah->nama_arab }}
                            </div>
                            
                        </div>
                    </a>
                @endforeach

            </div>
            
        </div>
    </div>
</x-app-layout>
@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 30px; margin-bottom: 50px;">
    <div class="row" style="margin-bottom: 40px;">
        <div class="col-md-12 text-center">
            <h1 style="font-weight: bold; color: #0f5132; margin-bottom: 10px;">
                <i class="fa fa-quran" style="margin-right: 10px;"></i> Al-Qur'an Digital
            </h1>
            <p class="text-muted" style="font-size: 16px;">
                Silakan pilih surah di bawah ini untuk mulai membaca dan mentadabburi ayat-ayat-Nya.
            </p>
            <hr style="border-top: 2px solid #0f5132; width: 80px; margin: 20px auto;">
        </div>
    </div>

    <div class="row">
        @foreach ($surah as $item)
            <div class="col-md-4" style="margin-bottom: 30px;">
                <div class="panel panel-default" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: none; transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.06)';">
                    
                    <div class="panel-body" style="padding: 25px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <div style="background-color: #0f5132; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px;">
                                {{ $item['nomor'] }}
                            </div>
                            @if(isset($item['nama']))
                                <h2 style="font-family: 'Amiri', serif; font-weight: bold; color: #0f5132; margin: 0; font-size: 28px; line-height: 1;">
                                    {{ $item['nama'] }}
                                </h2>
                            @endif
                        </div>

                        <div style="margin-bottom: 20px; border-top: 1px solid #eee; padding-top: 15px;">
                            <h4 style="font-weight: bold; color: #333; margin-bottom: 3px;">
                                {{ $item['namaLatin'] }}
                            </h4>
                            <p class="text-muted" style="margin-bottom: 8px; font-size: 13px; font-style: italic;">
                                "{{ $item['arti'] }}"
                            </p>
                            <span class="label label-success" style="background-color: #157347; font-weight: normal; font-size: 11px;">
                                {{ $item['jumlahAyat'] }} Ayat
                            </span>
                        </div>

                        <div style="margin-top: 15px;">
                            <a href="/quran/{{ $item['nomor'] }}" class="btn btn-block btn-primary" style="background-color: #0f5132; border-color: #0f5132; font-weight: bold; border-radius: 6px; padding: 10px 15px; font-size: 14px;">
                                Buka Surah <i class="fa fa-arrow-right" style="margin-left: 8px;"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

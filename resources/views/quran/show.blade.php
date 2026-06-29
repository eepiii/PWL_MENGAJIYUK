@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 20px; margin-bottom: 40px;">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('quran.index') }}" class="btn btn-default btn-sm" style="border-radius: 20px; font-weight: bold; padding: 6px 15px;">
            <i class="fa fa-arrow-left"></i> Kembali ke Daftar Surah
        </a>
    </div>

    <div class="panel panel-default text-center" style="background-color: #0f5132; color: white; border-radius: 8px; border: none; padding: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
        @if(isset($detailSurat['nama']))
            <h1 style="font-family: 'Amiri', serif; font-weight: bold; margin-bottom: 5px; font-size: 42px; color: white;">
                {{ $detailSurat['nama'] }}
            </h1>
            <h3 style="margin-top: 5px; font-weight: bold; margin-bottom: 5px; color: white;">
                {{ $detailSurat['namaLatin'] }}
            </h3>
            <p style="color: rgba(255, 255, 255, 0.75); font-style: italic; margin-bottom: 15px; font-size: 15px;">
                "{{ $detailSurat['arti'] }}"
            </p>
            <span class="label label-warning" style="text-transform: capitalize; font-size: 13px; padding: 6px 12px; background-color: #f0ad4e;">
                {{ $detailSurat['tempatTurun'] }}
            </span>
            <span class="label label-warning" style="font-size: 13px; padding: 6px 12px; margin-left: 5px; background-color: #f0ad4e;">
                {{ $detailSurat['jumlahAyat'] }} Ayat
            </span>
        @else
            <h3 style="color: white; margin: 10px 0;">Memuat Data Surah...</h3>
        @endif
    </div>

    <div class="row" style="margin-top: 30px;">
        <div class="col-md-10 col-md-offset-1">
            @if(isset($detailSurat['ayat']) && is_array($detailSurat['ayat']))
                @foreach($detailSurat['ayat'] as $ayat)
                    <div class="panel panel-default" style="border-radius: 8px; margin-bottom: 25px; box-shadow: 0 3px 6px rgba(0,0,0,0.03); border-top: 1px solid #eee;">
                        <div class="panel-body" style="padding: 30px;">
                            
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-xs-2">
                                    <span class="badge" style="background-color: #0f5132; font-size: 15px; padding: 8px 14px; border-radius: 50%; font-weight: bold;">
                                        {{ $ayat['nomorAyat'] }}
                                    </span>
                                </div>
                                <div class="col-xs-10 text-right">
                                    <h2 style="font-family: 'Amiri', serif; font-weight: bold; color: #222; line-height: 2.6; margin: 0; font-size: 32px; word-spacing: 5px; direction: rtl;">
                                        {{ $ayat['teksArab'] }}
                                    </h2>
                                </div>
                            </div>
                            
                            <hr style="margin-top: 15px; margin-bottom: 15px; border-top: 1px solid #f5f5f5;">
                            
                            <div class="row">
                                <div class="col-xs-12">
                                    <p style="color: #2e7d32; font-style: italic; font-size: 14px; margin-bottom: 8px; font-weight: 500;">
                                        {{ $ayat['teksLatin'] }}
                                    </p>
                                    <p style="color: #444; font-size: 15px; margin-bottom: 0; line-height: 1.7;">
                                        {{ $ayat['teksIndonesia'] }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-danger text-center" style="border-radius: 6px;">
                    Gagal memuat ayat. Pastikan koneksi internet aktif untuk mengambil data dari API.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
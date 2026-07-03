@extends('layouts.app')

@section('content')
<div style="min-height: 80vh; display: flex; flex-direction: column; justify-content: flex-start; padding-top: 20px; padding-bottom: 60px;">
    
    <div class="container" style="font-family: 'Segoe UI', Arial, sans-serif; width: 100%; max-width: 1140px; margin: 0 auto;">
        
        <div style="margin-bottom: 25px; text-align: left;">
            <a href="{{ route('quran.index') }}" class="btn btn-default btn-sm" style="border-radius: 20px; font-weight: bold; padding: 8px 18px; border: 1px solid #ccc; background: white; text-decoration: none; color: #333; display: inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                ← Kembali ke Daftar Surah
            </a>
        </div>

        <div class="panel panel-default text-center" style="background-color: #0f5132; color: white; border-radius: 12px; border: none; padding: 35px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); margin-bottom: 30px;">
            @if(isset($detailSurat['nama']))
                <h1 style="font-family: 'Amiri', serif; font-weight: bold; margin: 0 0 10px 0; font-size: 46px; color: white; letter-spacing: 1px;">
                    {{ $detailSurat['nama'] }}
                </h1>
                <h3 style="margin: 0 0 10px 0; font-weight: bold; color: white; font-size: 22px;">
                    {{ $detailSurat['namaLatin'] }}
                </h3>
                <p style="color: rgba(255, 255, 255, 0.85); font-style: italic; margin: 0 0 20px 0; font-size: 16px;">
                    "{{ $detailSurat['arti'] }}"
                </p>
                <div style="display: flex; justify-content: center; gap: 10px;">
                    <span class="label label-warning" style="text-transform: capitalize; font-size: 13px; padding: 6px 14px; background-color: #f0ad4e; border-radius: 4px; font-weight: 600;">
                        {{ $detailSurat['tempatTurun'] }}
                    </span>
                    <span class="label label-warning" style="font-size: 13px; padding: 6px 14px; background-color: #f0ad4e; border-radius: 4px; font-weight: 600;">
                        {{ $detailSurat['jumlahAyat'] }} Ayat
                    </span>
                </div>
            @else
                <h3 style="color: white; margin: 10px 0;">Memuat Data Surah...</h3>
            @endif
        </div>

        <div style="width: 100%; display: flex; flex-direction: column; gap: 25px;">
            @if(isset($detailSurat['ayat']) && is_array($detailSurat['ayat']))
                @foreach($detailSurat['ayat'] as $ayat)
                    <div class="panel panel-default" style="border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); border: 1px solid #eef2f5; background: white; margin-bottom: 0; width: 100%;">
                        <div class="panel-body" style="padding: 35px;">
                            
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; margin-bottom: 25px;">
                                <div style="flex-shrink: 0;">
                                    <span style="background-color: #0f5132; font-size: 14px; width: 36px; height: 36px; border-radius: 50%; font-weight: bold; color: white; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(15,81,50,0.2);">
                                        {{ $ayat['nomorAyat'] }}
                                    </span>
                                </div>
                                <div style="width: 100%; text-align: right;">
                                    <h2 style="font-family: 'Amiri', serif; font-weight: bold; color: #222; line-height: 2.5; margin: 0; font-size: 34px; word-spacing: 4px; direction: rtl;">
                                        {{ $ayat['teksArab'] }}
                                    </h2>
                                </div>
                            </div>
                            
                            <hr style="border-top: 1px solid #f8fafc; margin: 20px 0;">
                            
                            <div style="text-align: left;">
                                <p style="color: #2e7d32; font-style: italic; font-size: 15px; margin-bottom: 10px; font-weight: 500; line-height: 1.5;">
                                    {{ $ayat['teksLatin'] }}
                                </p>
                                <p style="color: #444; font-size: 15px; margin-bottom: 0; line-height: 1.8;">
                                    {{ $ayat['teksIndonesia'] }}
                                </p>
                            </div>

                            <hr style="border-top: 1px dashed #eef2f5; margin: 25px 0 15px 0;">

                            <div style="text-align: left;">
                                <label style="font-size: 11px; font-weight: bold; color: #888; text-transform: uppercase; display: block; margin-bottom: 10px; letter-spacing: 0.8px;">DENGARKAN MUROTTAL:</label>
                                @if(isset($ayat['audio']['01']))
                                    <audio controls style="width: 100%; max-width: 450px; height: 36px; display: block;">
                                        <source src="{{ $ayat['audio']['01'] }}" type="audio/mpeg">
                                        Browser Anda tidak mendukung pemutar audio.
                                    </audio>
                                @else
                                    <span class="text-muted" style="font-size: 13px; font-style: italic;">Audio tidak tersedia untuk ayat ini.</span>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-danger text-center" style="border-radius: 8px; font-weight: bold; padding: 15px;">
                    ⚠️ Gagal memuat ayat. Pastikan koneksi internet aktif untuk menarik data dari API Kemenag.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
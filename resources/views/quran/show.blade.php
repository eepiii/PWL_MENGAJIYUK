@extends('layouts.app')

@section('content')
<style>
    body { background-color: #fdfbf7; font-family: 'Inter', sans-serif; }
    .header-surah {
        background-color: #fcf9f2;
        border-radius: 16px;
        padding: 40px;
        margin-bottom: 30px;
        border: 1px solid #eee7d5;
        position: relative;
        overflow: hidden;
    }
    .header-surah::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 6px; height: 100%;
        background-color: #115e3b;
    }
    .btn-back-pill {
        background: #ffffff; border: 1px solid #e5e7eb; color: #374151;
        border-radius: 999px; padding: 8px 20px; font-weight: 600;
        font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .btn-back-pill:hover { background: #f9fafb; color: #115e3b; border-color: #115e3b; text-decoration: none; }
    
    .ayat-card {
        background: #ffffff; border-radius: 16px; padding: 30px; margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #f0f0f0;
    }
    .ayat-number-circle {
        background-color: #115e3b; color: white; width: 40px; height: 40px;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 16px; flex-shrink: 0; box-shadow: 0 4px 10px rgba(17,94,59,0.2);
    }
    .arab-text {
        font-family: 'Amiri', serif; font-size: 38px; color: #1f2937;
        line-height: 2.4; margin: 0; direction: rtl; font-weight: 700;
    }
</style>

<div class="container" style="max-width: 900px; margin-top: 30px; margin-bottom: 60px;">
    
    <div style="margin-bottom: 20px;">
        <a href="{{ route('quran.index') }}" class="btn-back-pill">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="header-surah">
        <div style="font-size: 12px; font-weight: 700; color: #9ca3af; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 10px;">
            SURAH AL-QUR'AN &bull; {{ $detailSurat['tempatTurun'] ?? 'Mekah' }}
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div>
                <h1 style="font-size: 36px; font-weight: 800; color: #115e3b; margin: 0 0 5px 0; font-family: 'Amiri', serif;">
                    {{ $detailSurat['nama'] ?? '' }}
                </h1>
                <h2 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 5px 0;">
                    {{ $detailSurat['namaLatin'] ?? 'Memuat...' }}
                </h2>
                <p style="color: #6b7280; font-size: 15px; margin: 0;">"{{ $detailSurat['arti'] ?? '' }}"</p>
            </div>
            <div>
                <div style="background: #115e3b; color: white; padding: 10px 20px; border-radius: 999px; font-weight: 600; font-size: 14px; display: inline-block;">
                    {{ $detailSurat['jumlahAyat'] ?? '0' }} Ayat
                </div>
            </div>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 15px;">
        @if(isset($detailSurat['ayat']) && is_array($detailSurat['ayat']))
            @foreach($detailSurat['ayat'] as $ayat)
                <div class="ayat-card">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 25px; margin-bottom: 25px;">
                        <div class="ayat-number-circle">{{ $ayat['nomorAyat'] }}</div>
                        <div style="width: 100%; text-align: right;">
                            <h2 class="arab-text">{{ $ayat['teksArab'] }}</h2>
                        </div>
                    </div>
                    
                    <hr style="border-top: 1px dashed #e5e7eb; margin: 20px 0;">
                    
                    <div>
                        <p style="color: #115e3b; font-style: italic; font-size: 15px; font-weight: 600; line-height: 1.6; margin-bottom: 8px;">
                            {{ $ayat['teksLatin'] }}
                        </p>
                        <p style="color: #4b5563; font-size: 15px; line-height: 1.7; margin-bottom: 0;">
                            {{ $ayat['teksIndonesia'] }}
                        </p>
                    </div>

                    @if(isset($ayat['audio']['01']))
                        <div style="margin-top: 25px; padding-top: 15px; border-top: 1px solid #f3f4f6;">
                            <audio controls style="width: 100%; height: 40px; outline: none;">
                                <source src="{{ $ayat['audio']['01'] }}" type="audio/mpeg">
                            </audio>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
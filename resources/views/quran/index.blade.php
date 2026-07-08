@extends('layouts.app')

@section('content')
<style>
    /* Global Background untuk kesan hangat/krem seperti referensi */
    body { background-color: #fdfbf7; font-family: 'Inter', 'Segoe UI', sans-serif; }
    
    .quran-header {
        text-align: center;
        margin-bottom: 40px;
    }
    .quran-title {
        font-weight: 800;
        color: #115e3b;
        font-size: 32px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }
    .surah-card {
        background-color: #ffffff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .surah-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(17, 94, 59, 0.08);
        border-color: #e5e7eb;
    }
    .surah-number {
        background-color: #115e3b;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
    }
    .surah-arab {
        font-family: 'Amiri', serif;
        font-size: 28px;
        font-weight: 700;
        color: #115e3b;
        margin: 0;
    }
    .ayat-badge {
        background-color: #115e3b;
        color: white;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        display: inline-block;
        margin-top: 10px;
    }
    .btn-buka-surah {
        background-color: #115e3b;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        padding: 12px;
        width: 100%;
        text-align: center;
        border: none;
        transition: background 0.2s;
        text-decoration: none;
        display: inline-block;
        margin-top: auto;
    }
    .btn-buka-surah:hover {
        background-color: #0e4b2f;
        color: white;
        text-decoration: none;
    }
</style>

<div class="container" style="margin-top: 40px; margin-bottom: 60px; max-width: 1100px;">
    
    <div class="quran-header">
        <h1 class="quran-title">
            <i class="fa fa-book-quran"></i> Al-Qur'an Digital
        </h1>
        <p style="color: #6b7280; font-size: 16px;">
            Silakan pilih surah di bawah ini untuk mulai membaca dan mentadabburi ayat-ayat-Nya.
        </p>
        <hr style="border-top: 2px solid #115e3b; width: 60px; margin: 20px auto; border-radius: 2px;">
    </div>

    <div class="row">
        @foreach ($surah as $item)
            @php
                $item = (object) $item;
                $nomor     = $item->nomor ?? null;
                $nama      = $item->nama ?? '';
                $namaLatin = $item->namaLatin ?? '';
                $arti      = $item->arti ?? '';
                $jumlahAyat = $item->jumlahAyat ?? 0;
            @endphp

            <div class="col-md-4 col-sm-6" style="margin-bottom: 24px;">
                <div class="surah-card">
                    
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                        <div class="surah-number">{{ $nomor }}</div>
                        <h2 class="surah-arab">{{ $nama }}</h2>
                    </div>

                    <div style="border-top: 1px solid #f3f4f6; padding-top: 15px; margin-bottom: 20px;">
                        <h4 style="font-weight: 700; color: #1f2937; margin: 0 0 4px 0; font-size: 18px;">
                            {{ $namaLatin }}
                        </h4>
                        <p style="color: #6b7280; font-size: 13px; font-style: italic; margin: 0;">
                            "{{ $arti }}"
                        </p>
                        <div class="ayat-badge">{{ $jumlahAyat }} Ayat</div>
                    </div>

                    <a href="{{ route('quran.show', $nomor) }}" class="btn-buka-surah">
                        Buka Surah <i class="fa fa-arrow-right" style="margin-left: 5px;"></i>
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

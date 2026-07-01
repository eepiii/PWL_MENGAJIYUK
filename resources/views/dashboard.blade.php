@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container" style="margin-top: 30px; margin-bottom: 50px; max-width: 1140px; font-family: 'Segoe UI', Arial, sans-serif;">
    
    <div class="text-center" style="background-color: #0f5132; color: white; border-radius: 12px; padding: 50px 20px; margin-bottom: 40px; box-shadow: 0 4px 15px rgba(15,81,50,0.1);">
        <h1 style="font-size: 38px; font-weight: bold; margin-bottom: 15px; font-family: 'Georgia', serif;">
            Selamat Datang di MengajiYuk!
        </h1>
        <p style="font-size: 16px; opacity: 0.9; max-width: 700px; margin: 0 auto 25px auto; line-height: 1.6;">
            Platform digital pendukung hafalan santri, jurnal ibadah, dan pembelajaran Al-Qur'an interaktif.
        </p>
        <a href="/quran" class="btn" style="background-color: #e67e22; color: white; font-weight: bold; padding: 12px 30px; border-radius: 6px; text-decoration: none; font-size: 15px; display: inline-block; transition: all 0.2s; box-shadow: 0 4px 10px rgba(230,126,34,0.2);">
            <i class="fa-solid fa-book-open" style="margin-right: 8px;"></i> Mulai Baca Al-Qur'an
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
        
        <div class="card-menu" style="background: white; border: 1px solid #eef2f5; border-radius: 12px; padding: 35px 25px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; min-height: 280px;">
            <div>
                <div style="color: #0f5132; font-size: 40px; margin-bottom: 15px;">
                    <i class="fa-solid fa-book-quran"></i>
                </div>
                <h3 style="font-weight: bold; color: #222; margin: 0 0 10px 0; font-size: 20px;">Al-Qur'an Digital</h3>
                <p style="color: #666; font-size: 14px; line-height: 1.6; margin: 0 0 20px 0;">
                    Baca Al-Qur'an lengkap dengan teks Arab, transliterasi latin, dan terjemahan bahasa Indonesia resmi.
                </p>
            </div>
            <div>
                <a href="/quran" class="btn" style="border: 1px solid #ccc; background: white; color: #333; font-weight: bold; padding: 8px 24px; border-radius: 6px; text-decoration: none; font-size: 13px; display: inline-block;">
                    Buka Qur'an
                </a>
            </div>
        </div>

        <div class="card-menu" style="background: white; border: 1px solid #eef2f5; border-radius: 12px; padding: 35px 25px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; min-height: 280px;">
            <div>
                <div style="color: #f39c12; font-size: 40px; margin-bottom: 15px;">
                    <i class="fa-solid fa-microphone"></i>
                </div>
                <h3 style="font-weight: bold; color: #222; margin: 0 0 10px 0; font-size: 20px;">Setoran Hafalan</h3>
                <p style="color: #666; font-size: 14px; line-height: 1.6; margin: 0 0 20px 0;">
                    Rekam dan setor hafalan ayat Al-Qur'an kamu secara mandiri untuk dikoreksi oleh Ustadz pembimbing.
                </p>
            </div>
            <div>
                <a href="/setoran-hafalan" class="btn" style="border: 1px solid #ccc; background: white; color: #333; font-weight: bold; padding: 8px 24px; border-radius: 6px; text-decoration: none; font-size: 13px; display: inline-block;">
                    Mulai Setoran
                </a>
            </div>
        </div>

        <div class="card-menu" style="background: white; border: 1px solid #eef2f5; border-radius: 12px; padding: 35px 25px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; min-height: 280px;">
            <div>
                <div style="color: #2b6cb0; font-size: 40px; margin-bottom: 15px;">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <h3 style="font-weight: bold; color: #222; margin: 0 0 10px 0; font-size: 20px;">Jurnal Ibadah</h3>
                <p style="color: #666; font-size: 14px; line-height: 1.6; margin: 0 0 20px 0;">
                    Catat perkembangan ibadah harianmu mulai dari shalat wajib, sunnah, hingga target tilawah harian.
                </p>
            </div>
            <div>
                <a href="/jurnal" class="btn" style="border: 1px solid #ccc; background: white; color: #333; font-weight: bold; padding: 8px 24px; border-radius: 6px; text-decoration: none; font-size: 13px; display: inline-block;">
                    Isi Jurnal
                </a>
            </div>
        </div>

    </div>
</div>

<style>
    /* Efek hover interaktif tipis biar makin mirip web professional */
    .card-menu {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-menu:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06) !important;
    }
    .card-menu a:hover {
        background-color: #f8f9fa !important;
        border-color: #adadad !important;
    }
</style>
@endsection
@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 30px; margin-bottom: 50px;">
    <div class="jumbotron text-center" style="background-color: #0f5132; color: white; border-radius: 12px; padding: 40px 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h1 style="font-family: 'Amiri', serif; font-weight: bold; font-size: 48px; color: white;">
            Selamat Datang di MengajiYuk!
        </h1>
        <p style="font-size: 18px; color: rgba(255,255,255,0.85); margin-top: 15px;">
            Platform digital pendukung hafalan santri, jurnal ibadah, dan pembelajaran Al-Qur'an interaktif.
        </p>
        <p style="margin-top: 25px;">
            <a class="btn btn-warning btn-lg" href="{{ route('quran.index') }}" role="button" style="font-weight: bold; padding: 12px 30px; border-radius: 4px;">
                <i class="fa fa-book-open"></i> Mulai Baca Al-Qur'an
            </a>
        </p>
    </div>

    <div class="row" style="margin-top: 40px;">
        <div class="col-md-4 text-center" style="margin-bottom: 20px;">
            <div class="panel panel-default" style="border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-top: 4px solid #0f5132;">
                <div style="font-size: 40px; color: #0f5132; margin-bottom: 15px;">
                    <i class="fa fa-quran"></i>
                </div>
                <h3 style="font-weight: bold; color: #333;">Al-Qur'an Digital</h3>
                <p class="text-muted">Baca Al-Qur'an lengkap dengan teks Arab, transliterasi latin, dan terjemahan bahasa Indonesia resmi.</p>
                <a href="{{ route('quran.index') }}" class="btn btn-default btn-sm" style="font-weight: bold;">Buka Qur'an</a>
            </div>
        </div>

        <div class="col-md-4 text-center" style="margin-bottom: 20px;">
            <div class="panel panel-default" style="border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-top: 4px solid #f0ad4e;">
                <div style="font-size: 40px; color: #f0ad4e; margin-bottom: 15px;">
                    <i class="fa fa-microphone"></i>
                </div>
                <h3 style="font-weight: bold; color: #333;">Setoran Hafalan</h3>
                <p class="text-muted">Rekam dan setor hafalan ayat Al-Qur'an kamu secara mandiri untuk dikoreksi oleh Ustadz pembimbing.</p>
                <a href="#" class="btn btn-default btn-sm" style="font-weight: bold;">Mulai Setoran</a>
            </div>
        </div>

        <div class="col-md-4 text-center" style="margin-bottom: 20px;">
            <div class="panel panel-default" style="border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-top: 4px solid #337ab7;">
                <div style="font-size: 40px; color: #337ab7; margin-bottom: 15px;">
                    <i class="fa fa-calendar-check"></i>
                </div>
                <h3 style="font-weight: bold; color: #333;">Jurnal Ibadah</h3>
                <p class="text-muted">Catat perkembangan ibadah harianmu mulai dari shalat wajib, sunnah, hingga target tilawah harian.</p>
                <a href="#" class="btn btn-default btn-sm" style="font-weight: bold;">Isi Jurnal</a>
            </div>
        </div>
    </div>
</div>
@endsection
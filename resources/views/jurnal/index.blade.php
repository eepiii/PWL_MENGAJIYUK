@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&family=Amiri:wght@400;700&display=swap');

    .jurnal-wrap { max-width: 780px; margin: 50px auto; padding: 0 20px 80px; font-family: 'Inter', sans-serif; }
    .jurnal-breadcrumb { font-size: 11px; letter-spacing: 2px; color: #999; text-transform: uppercase; margin-bottom: 8px; }
    .jurnal-title { font-family: 'Amiri', serif; font-size: 38px; color: #1a3a2a; margin: 0 0 6px; font-weight: 700; }
    .jurnal-subtitle { font-size: 14px; color: #888; margin-bottom: 30px; }
    .filter-bar { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; flex-wrap: wrap; }
    .filter-btn { border: 1.5px solid #1a3a2a; border-radius: 30px; padding: 6px 18px; font-size: 13px; font-weight: 600; cursor: pointer; background: transparent; color: #1a3a2a; transition: all 0.2s; }
    .filter-btn.active { background: #1a3a2a; color: white; }
    .progres-bar-wrap { background: #f0f0eb; border-radius: 30px; height: 8px; margin-top: 6px; overflow: hidden; }
    .progres-bar-fill { background: #1a3a2a; height: 8px; border-radius: 30px; transition: width 0.5s; }
    .shalat-card { background: white; border-radius: 4px; padding: 20px 24px; margin-bottom: 2px; border-left: 3px solid transparent; transition: all 0.2s; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
    .shalat-card.done { border-left-color: #1a3a2a; background: #f9fdf9; }
    .shalat-card.absen { border-left-color: #e5e5e5; }
    .shalat-name { font-family: 'Amiri', serif; font-size: 20px; color: #1a3a2a; font-weight: 700; margin: 0; }
    .shalat-time { font-size: 12px; color: #888; margin: 2px 0 0; }
    .badge-status { font-size: 10px; letter-spacing: 1px; font-weight: 700; padding: 4px 12px; border-radius: 30px; text-transform: uppercase; }
    .badge-tepat { background: #1a3a2a; color: white; }
    .badge-qadha { background: #d4a017; color: white; }
    .badge-absen { background: #f0f0eb; color: #999; border: 1px dashed #ccc; }
    .jurnal-select { border: 1px solid #e0e0e0; border-radius: 8px; padding: 8px 12px; font-size: 13px; color: #333; background: white; outline: none; min-width: 160px; }
    .section-label { font-size: 10px; letter-spacing: 2px; color: #aaa; text-transform: uppercase; font-weight: 700; margin: 30px 0 12px; border-bottom: 1px solid #f0f0eb; padding-bottom: 8px; }
    .extra-card { background: white; border-radius: 4px; padding: 20px 24px; margin-bottom: 2px; display: flex; align-items: center; justify-content: space-between; gap: 16px; border-left: 3px solid #e5e5e5; }
    .save-btn { width: 100%; background: #1a3a2a; color: white; border: none; border-radius: 8px; padding: 16px; font-size: 15px; font-weight: 600; cursor: pointer; margin-top: 30px; letter-spacing: 0.5px; transition: opacity 0.2s; }
    .save-btn:hover { opacity: 0.88; }
    .alert-success-custom { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; border-radius: 8px; padding: 14px 18px; font-size: 14px; font-weight: 600; margin-bottom: 24px; }
</style>

<div class="jurnal-wrap">

    {{-- Breadcrumb & Judul --}}
    <p class="jurnal-breadcrumb">Jurnal Ibadah · Harian</p>
    <h1 class="jurnal-title">Catatan Ibadah</h1>
    <p class="jurnal-subtitle">Pantau konsistensi ibadah harianmu dan catat amalan di sini.</p>

    {{-- Filter Tanggal & Progres --}}
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 30px;">
        <form action="{{ route('jurnal.index') }}" method="GET" style="display: flex; align-items: center; gap: 10px;">
            <label style="font-size: 12px; font-weight: 600; color: #888; letter-spacing: 1px; text-transform: uppercase;">Tanggal</label>
            <input type="date" name="tanggal" value="{{ $tanggal }}"
                style="border: 1.5px solid #e0e0e0; border-radius: 8px; padding: 8px 12px; font-size: 13px; color: #1a3a2a; font-weight: 600; outline: none; cursor: pointer;"
                onchange="this.form.submit()">
        </form>

        @php $progres = $jurnal->persentaseShalat(); @endphp
        <div style="min-width: 220px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 12px; font-weight: 600; color: #888; letter-spacing: 1px; text-transform: uppercase;">Progres Shalat</span>
                <span style="font-family: 'Playfair Display', serif; font-size: 22px; color: #1a3a2a; font-weight: 700;">{{ $progres }}%</span>
            </div>
            <div class="progres-bar-wrap">
                <div class="progres-bar-fill" style="width: {{ $progres }}%;"></div>
            </div>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert-success-custom">✨ {{ session('success') }}</div>
    @endif

    <form action="{{ route('jurnal.store') }}" method="POST">
        @csrf
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        {{-- Shalat --}}
        <p class="section-label">🕌 Shalat Fardhu</p>

        @foreach(['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'] as $waktu)
            @php
                $field  = 'shalat_' . $waktu;
                $status = $jurnal->$field;
            @endphp
            <div class="shalat-card {{ $status > 0 ? 'done' : 'absen' }}">
                <div style="flex: 1;">
                    <p class="shalat-name">Shalat {{ ucfirst($waktu) }}</p>
                    @if($jadwalShalat && isset($jadwalShalat[$waktu]))
                        <p class="shalat-time">⏰ Waktu masuk: {{ $jadwalShalat[$waktu] }} WIB</p>
                    @else
                        <p class="shalat-time">Jadwal tidak tersedia</p>
                    @endif
                </div>

                <div style="display: flex; align-items: center; gap: 12px;">
                    @if($status == 1)
                        <span class="badge-status badge-tepat">Tepat Waktu</span>
                    @elseif($status == 2)
                        <span class="badge-status badge-qadha">Qadha</span>
                    @else
                        <span class="badge-status badge-absen">Belum</span>
                    @endif

                    <select name="{{ $field }}" class="jurnal-select">
                        <option value="0" {{ $status == 0 ? 'selected' : '' }}>Tidak Shalat</option>
                        <option value="1" {{ $status == 1 ? 'selected' : '' }}>Tepat Waktu</option>
                        <option value="2" {{ $status == 2 ? 'selected' : '' }}>Qadha</option>
                    </select>
                </div>
            </div>
        @endforeach

        {{-- Amalan Tambahan --}}
        <p class="section-label">🌙 Amalan Tambahan</p>

        {{-- Puasa Sunnah --}}
        <div class="extra-card" style="{{ $jurnal->puasa_sunnah ? 'border-left-color: #1a3a2a; background: #f9fdf9;' : '' }}">
            <div style="flex: 1;">
                <p class="shalat-name">Puasa Sunnah</p>
                <p class="shalat-time">Catat jika kamu berpuasa sunnah hari ini</p>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                @if($jurnal->puasa_sunnah)
                    <span class="badge-status badge-tepat">Alhamdulillah</span>
                @endif
                <select name="puasa_sunnah" class="jurnal-select">
                    <option value="0" {{ !$jurnal->puasa_sunnah ? 'selected' : '' }}>Tidak Puasa</option>
                    <option value="1" {{ $jurnal->puasa_sunnah ? 'selected' : '' }}>Ya, Puasa</option>
                </select>
            </div>
        </div>

        {{-- Tilawah --}}
        <div class="extra-card" style="{{ $jurnal->tilawah_halaman > 0 ? 'border-left-color: #1a3a2a; background: #f9fdf9;' : '' }}">
            <div style="flex: 1;">
                <p class="shalat-name">Tilawah Al-Qur'an</p>
                <p class="shalat-time">Catat jumlah halaman yang kamu baca hari ini</p>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                @if($jurnal->tilawah_halaman > 0)
                    <span class="badge-status badge-tepat">{{ $jurnal->tilawah_halaman }} Hal</span>
                @endif
                <input type="number" name="tilawah_halaman"
                    value="{{ $jurnal->tilawah_halaman }}"
                    min="0" placeholder="0"
                    style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 8px 12px; font-size: 13px; width: 100px; outline: none; text-align: center; font-weight: 600; color: #1a3a2a;">
            </div>
        </div>

        {{-- Catatan --}}
        <p class="section-label">📝 Evaluasi & Catatan</p>
        <div style="background: white; border-radius: 4px; border-left: 3px solid #e5e5e5; padding: 20px 24px;">
            <textarea name="catatan" rows="4"
                style="width: 100%; border: none; outline: none; resize: none; font-size: 14px; color: #555; font-family: 'Inter', sans-serif; background: transparent; line-height: 1.7;"
                placeholder="Tulis refleksi ibadah, kendala, atau doa untuk hari ini...">{{ $jurnal->catatan }}</textarea>
        </div>

        <button type="submit" class="save-btn">
            Simpan Jurnal Ibadah
        </button>

    </form>
</div>
@endsection
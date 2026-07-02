@extends('layouts.app')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- 1. Kotak Ucapan Selamat Datang -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                <div class="p-6 text-gray-900 text-lg">
                    Assalamu'alaikum, <strong>{{ Auth::user()->name }}</strong>! <br>
                    Anda masuk menggunakan akun <span class="uppercase font-bold text-indigo-600 bg-indigo-100 px-2 py-1 rounded">{{ Auth::user()->getRoleNames()->first() }}</span>.
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

            <!-- 2. Menu Navigasi Cepat (Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Menu Baca Al-Qur'an (Bisa dilihat Semua Role) -->
                <a href="{{ route('quran.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md hover:bg-gray-50 transition">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">📖 Baca Al-Qur'an</h5>
                    <p class="font-normal text-gray-600">Akses daftar 114 Surah dan baca ayat suci Al-Qur'an di sini.</p>
                </a>

                <!-- Menu Khusus Santri (Hanya muncul jika yang login adalah Santri) -->
                @role('santri')
                <a href="#" class="block p-6 bg-blue-50 border border-blue-200 rounded-lg shadow-sm hover:shadow-md hover:bg-blue-100 transition">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-blue-900">🎤 Setor Hafalan</h5>
                    <p class="font-normal text-blue-700">Kirim jadwal atau hasil setoran hafalan baru Anda kepada guru.</p>
                </a>
                @endrole

                <!-- Menu Khusus Guru (Hanya muncul jika yang login adalah Guru) -->
                @role('guru')
                <a href="{{ route('penilaian.index') }}" class="block p-6 bg-green-50 border border-green-200 rounded-lg shadow-sm hover:shadow-md hover:bg-green-100 transition">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-green-900">📝 Penilaian Setoran</h5>
                    <p class="font-normal text-green-700">Periksa, dengarkan, dan beri nilai pada setoran hafalan santri.</p>
                </a>
                @endrole
                
            </div>

        </div>

    </div>
</x-app-layout>
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

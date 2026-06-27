<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- 1. Kotak Ucapan Selamat Datang -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                <div class="p-6 text-gray-900 text-lg">
                    Assalamu'alaikum, <strong>{{ Auth::user()->name }}</strong>! <br>
                    Anda masuk menggunakan akun <span class="uppercase font-bold text-indigo-600 bg-indigo-100 px-2 py-1 rounded">{{ Auth::user()->getRoleNames()->first() }}</span>.
                </div>
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
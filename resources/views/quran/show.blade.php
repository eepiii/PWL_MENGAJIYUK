<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Surah {{ $surah->namaLatin }}
            </h2>
            <a href="{{ route('quran.index') }}" class="text-sm bg-gray-500 hover:bg-gray-700 text-white py-1 px-3 rounded">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="text-center mb-10 border-b pb-6">
                    <h3 class="text-4xl font-bold mb-2 text-indigo-600">{{ $surah->nama }}</h3>
                    <p class="text-lg text-gray-600 font-semibold">{{ $surah->arti }}</p>
                </div>

                <div class="space-y-8">
                    @foreach ($surah->ayat as $ayat)
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            
                            <!-- Bagian Atas: Teks Arab & Nomor -->
                            <div class="flex justify-between items-start mb-4">
                                <span class="bg-indigo-100 text-indigo-800 text-sm font-bold px-3 py-1 rounded-full h-8">
                                    {{ $ayat->nomorAyat }}
                                </span>
                                <p class="text-3xl text-right w-full leading-loose font-arabic text-gray-900" dir="rtl" id="teks-arab-{{ $ayat->nomorAyat }}">
                                    {{ $ayat->teksArab }}
                                </p>
                            </div>
                            
                            <!-- Terjemahan -->
                            <div class="mb-4">
                                <p class="text-indigo-600 text-sm italic mb-1">{{ $ayat->teksLatin }}</p>
                                <p class="text-gray-800 text-md">{{ $ayat->teksIndonesia }}</p>
                            </div>

                            <hr class="my-4">

                            <!-- FITUR UTAMA: Audio Mengaji & Koreksi AI -->
                            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                                
                                <!-- 1. Suara Yang Mengaji (Dari API eQuran) -->
                                <div class="w-full md:w-1/2">
                                    <p class="text-xs font-bold text-gray-500 mb-1 uppercase">Dengarkan Bacaan:</p>
                                    <!-- Mengambil audio Qari 01 dari API -->
                                    <audio controls class="w-full h-10">
                                        <source src="{{ $ayat->audio->{'01'} }}" type="audio/mpeg">
                                        Browser Anda tidak mendukung elemen audio.
                                    </audio>
                                </div>

                                <!-- 2. Sistem Koreksi Suara AI -->
                                <div class="w-full md:w-1/2 flex flex-col items-end">
                                    <p class="text-xs font-bold text-gray-500 mb-1 uppercase">Tes Hafalan AI:</p>
                                    <div class="flex gap-2 w-full justify-end">
                                        <button onclick="mulaiKoreksiAI({{ $ayat->nomorAyat }})" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm font-bold flex items-center gap-1 shadow">
                                            🎙️ Mulai Setor Suara
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <!-- Area Hasil Koreksi AI (Awalnya Disembunyikan) -->
                            <div id="hasil-koreksi-{{ $ayat->nomorAyat }}" class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded hidden">
                                <p class="text-sm font-bold text-yellow-800 mb-1">Hasil Deteksi AI:</p>
                                <p id="teks-suara-{{ $ayat->nomorAyat }}" class="text-lg text-right font-arabic text-gray-700" dir="rtl">...</p>
                                <p id="status-koreksi-{{ $ayat->nomorAyat }}" class="text-sm mt-2 font-bold"></p>
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <!-- Script AI Web Speech Recognition & Text-to-Speech -->
    <script>
        // --- FITUR BARU: Fungsi untuk menyuruh AI Berbicara ---
        function aiBerbicara(teksKoreksi) {
            if ('speechSynthesis' in window) {
                // Hentikan suara AI sebelumnya jika masih bicara
                window.speechSynthesis.cancel(); 

                const pesanSuara = new SpeechSynthesisUtterance(teksKoreksi);
                pesanSuara.lang = 'id-ID'; // Menggunakan suara bahasa Indonesia
                pesanSuara.rate = 1.0; // Kecepatan bicara normal
                pesanSuara.pitch = 1.0; // Nada suara normal

                window.speechSynthesis.speak(pesanSuara);
            }
        }

        // --- FITUR LAMA: Fungsi Deteksi Suara ---
        function mulaiKoreksiAI(nomorAyat) {
            if (!('webkitSpeechRecognition' in window)) {
                alert("Browser Anda tidak mendukung fitur deteksi suara AI. Gunakan Google Chrome versi terbaru.");
                return;
            }

            const teksAsli = document.getElementById(`teks-arab-${nomorAyat}`).innerText.trim();
            const areaHasil = document.getElementById(`hasil-koreksi-${nomorAyat}`);
            const teksSuara = document.getElementById(`teks-suara-${nomorAyat}`);
            const statusKoreksi = document.getElementById(`status-koreksi-${nomorAyat}`);

            areaHasil.classList.remove('hidden');
            teksSuara.innerText = "Mendengarkan suara Anda...";
            statusKoreksi.innerText = "";
            statusKoreksi.className = "text-sm mt-2 font-bold text-blue-600";

            const recognition = new webkitSpeechRecognition();
            recognition.lang = 'ar-SA'; 
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;

            recognition.start();

            recognition.onresult = function(event) {
                const hasilSuara = event.results[0][0].transcript;
                const teksAsli = document.getElementById(`teks-arab-${nomorAyat}`).innerText.trim();

                // 1. Membandingkan kata per kata
                const kataAsli = teksAsli.split(' ');
                const kataSuara = hasilSuara.split(' ');
                
                let koreksi = "";
                
                // Cek apakah ada kata yang terlewat
                if (kataSuara.length < kataAsli.length) {
                    koreksi = "Ada bacaan yang terlewat atau kurang jelas.";
                } else if (kataSuara.length > kataAsli.length) {
                    koreksi = "Ada bacaan tambahan yang tidak sesuai.";
                } else {
                    koreksi = "Alhamdulillah, bacaan sudah sesuai urutan ayat.";
                }

                // Tampilkan hasil
                teksSuara.innerText = hasilSuara;
                statusKoreksi.innerText = koreksi;
                aiBerbicara(koreksi); 
            };
            
            recognition.onerror = function(event) {
                teksSuara.innerText = "Gagal mendeteksi suara.";
                let kalimatError = "Maaf, sistem tidak bisa mendengar suara Anda dengan jelas.";
                statusKoreksi.innerText = "Error: " + event.error;
                statusKoreksi.className = "text-sm mt-2 font-bold text-red-600";
                
                aiBerbicara(kalimatError); // AI Berbicara!
            };
        }
    </script>
</x-app-layout>
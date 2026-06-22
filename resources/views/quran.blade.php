<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MengajiYuk - Quran Reader</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Amiri&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap');
        .font-arabic { font-family: 'Amiri', serif; }
        .font-sans { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-emerald-600 mb-2">📖 Quran Reader</h1>
            <p class="text-gray-600">Fitur membaca Al-Qur'an digital untuk mendukung setoran hafalan santri.</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm mb-6 border border-gray-100">
            <label for="select-surah" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Surah:</label>
            <select id="select-surah" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition bg-white">
                <option value="" disabled selected>Sedang memuat daftar surah...</option>
            </select>
        </div>

        <div id="surah-info" class="hidden bg-emerald-50 border border-emerald-100 p-6 rounded-2xl text-center mb-6">
            <h2 id="surah-title" class="text-2xl font-bold text-emerald-800"></h2>
            <p id="surah-desc" class="text-sm text-emerald-600 mt-1"></p>
        </div>

        <div id="loading" class="hidden text-center py-12">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-500 border-t-transparent"></div>
            <p class="text-gray-500 mt-2 text-sm">Memuat ayat-ayat...</p>
        </div>

        <div id="ayat-container" class="space-y-4"></div>
    </div>

    <script>
        const selectSurah = document.getElementById('select-surah');
        const ayatContainer = document.getElementById('ayat-container');
        const surahInfo = document.getElementById('surah-info');
        const surahTitle = document.getElementById('surah-title');
        const surahDesc = document.getElementById('surah-desc');
        const loading = document.getElementById('loading');

        async function loadDaftarSurah() {
            try {
                const response = await fetch('https://equran.id/api/v2/surat');
                const result = await response.json();
                if (result.code === 200) {
                    selectSurah.innerHTML = '<option value="" disabled selected>-- Pilih Surah yang Ingin Dibaca --</option>';
                    result.data.forEach(surah => {
                        const option = document.createElement('option');
                        option.value = surah.nomor;
                        option.textContent = `${surah.nomor}. ${surah.namaLatin} (${surah.nama})`;
                        selectSurah.appendChild(option);
                    });
                }
            } catch (error) {
                console.error("Gagal mengambil daftar surah:", error);
                selectSurah.innerHTML = '<option value="" disabled>Gagal memuat daftar surah.</option>';
            }
        }

        async function loadDetailSurah(nomorSurah) {
            loading.classList.remove('hidden');
            ayatContainer.innerHTML = '';
            surahInfo.classList.add('hidden');
            try {
                const response = await fetch(`https://equran.id/api/v2/surat/${nomorSurah}`);
                const result = await response.json();
                if (result.code === 200) {
                    const dataSurah = result.data;
                    surahTitle.textContent = `${dataSurah.namaLatin} (${dataSurah.nama})`;
                    surahDesc.textContent = `${dataSurah.tempatTurun.toUpperCase()} • ${dataSurah.jumlahAyat} Ayat • Arti: ${dataSurah.arti}`;
                    surahInfo.classList.remove('hidden');

                    dataSurah.ayat.forEach(ayat => {
                        const cardAyat = document.createElement('div');
                        cardAyat.className = "bg-white p-6 rounded-2xl shadow-xs border border-gray-100 flex flex-col gap-4";
                        cardAyat.innerHTML = `
                            <div class="flex justify-between items-center">
                                <span class="flex items-center justify-center bg-emerald-100 text-emerald-700 font-bold text-sm w-8 h-8 rounded-full">${ayat.nomorAyat}</span>
                            </div>
                            <div class="text-right text-3xl font-arabic text-gray-900 leading-loose tracking-wide my-2" dir="rtl">${ayat.teksArab}</div>
                            <div class="text-left space-y-1 border-t border-gray-50 pt-3">
                                <p class="text-sm italic text-emerald-700 font-medium">${ayat.teksLatin}</p>
                                <p class="text-sm text-gray-600">${ayat.teksIndonesia}</p>
                            </div>
                        `;
                        ayatContainer.appendChild(cardAyat);
                    });
                }
            } catch (error) {
                console.error("Gagal mengambil detail ayat:", error);
            } finally {
                loading.classList.add('hidden');
            }
        }

        selectSurah.addEventListener('change', (e) => {
            loadDetailSurah(e.target.value);
        });

        loadDaftarSurah();
    </script>
</body>
</html>
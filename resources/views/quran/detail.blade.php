Oalah, begitu maksudmu! Jadi kamu mau di dalam card ayat itu ada **dua mode interaktif sekalian**, mirip fitur komplitnya Ngaji.ai:

1. **Mode Recitation (Membaca/Menghafal):** Santri pencet tombol mic, lalu melafalkan ayatnya, dan sistem akan mencocokkan teks suaranya dengan ayat Al-Qur'an tersebut.
2. **Mode Listening (Mendengarkan):** Santri bisa memutar audio/murottal dari Sheikh langsung dari API per ayatnya (ikon speaker/sound).

Biar bener-bener canggih, kita tambahkan fitur **audio murottal otomatis per ayat** menggunakan API publik Kemenag/Quran.com (biasanya field `$ayat['audio']` sudah ada di return API data Qur'an kamu, atau kita pakai fallback URL cadangan).

Yuk, ganti isi file `detail.blade.php` kamu dengan kode terlengkap ini. Tampilannya horizontal rapi seperti webmu tapi fiturnya kembar dengan Ngaji.ai!

```html
@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container" style="margin-top: 20px; margin-bottom: 40px; max-width: 1000px;">
    
    <div style="margin-bottom: 25px;">
        <a href="/quran" class="btn btn-default btn-sm" style="border-radius: 20px; font-weight: bold; padding: 6px 18px; border: 1px solid #ccc; background-color: #ffffff; color: #333333; text-decoration: none; display: inline-block;">
            <i class="fa fa-arrow-left"></i> Kembali ke Daftar Surah
        </a>
    </div>

    <div class="text-center" style="background-color: #0f5132; color: white; border-radius: 16px; padding: 30px; margin-bottom: 30px;">
        @if(isset($surah['namaLatin']))
            <h1 style="font-family: 'Amiri', serif; font-size: 36px; margin-bottom: 5px;">{{ $surah['nama'] ?? 'الفاتحة' }}</h1>
            <h2 style="font-weight: bold; margin: 0 0 10px 0; font-size: 24px;">{{ $surah['namaLatin'] }}</h2>
            <p style="margin: 0; font-size: 14px; opacity: 0.9;">"{{ $surah['arti'] ?? 'Pembukaan' }}"</p>
            <div style="margin-top: 15px;">
                <span class="label label-warning" style="background-color: #f39c12; padding: 5px 15px; border-radius: 4px; font-weight: bold; margin-right: 5px;">{{ $surah['tempatTurun'] ?? 'Mekah' }}</span>
                <span class="label label-warning" style="background-color: #f39c12; padding: 5px 15px; border-radius: 4px; font-weight: bold;">{{ $surah['jumlahAyat'] }} Ayat</span>
            </div>
        @endif
    </div>

    @if(isset($surah['ayat']) && is_array($surah['ayat']))
        @foreach($surah['ayat'] as $ayat)
            <div style="background-color: #ffffff; border-radius: 12px; padding: 30px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); position: relative; border: 1px solid #eee;">
                
                <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
                    
                    <div style="flex-shrink: 0; display: flex; flex-direction: column; gap: 10px; align-items: center;">
                        <span style="background-color: #0f5132; color: white; font-size: 14px; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                            {{ $ayat['nomorAyat'] }}
                        </span>

                        @php
                            // Format fallback URL audio Kemenag jika data $ayat['audio'] kosong
                            $audioUrl = $ayat['audio']['01'] ?? $ayat['audio'] ?? 'https://equran.nos.wjv-1.neo.id/audio-partial/Mishary-Rashid-Alafasy/' . sprintf('%03d', $surah['nomor']) . sprintf('%03d', $ayat['nomorAyat']) . '.mp3';
                        @endphp
                        <button type="button" class="btn-audio-listening" 
                                onclick="playAudio('{{ $audioUrl }}', this)"
                                style="background-color: #ffffff; border: 1px solid #ccc; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #e67e22; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: all 0.2s;" 
                                title="Dengarkan Murottal (Listening Mode)">
                            <i class="fa-solid fa-volume-high" style="font-size: 12px;"></i>
                        </button>
                    </div>

                    <div style="width: 100%; text-align: right; padding-left: 20px;">
                        <h1 style="font-family: 'Amiri', serif; font-weight: bold; color: #222222; line-height: 2.2; margin: 0; font-size: 32px; direction: rtl;">
                            {{ $ayat['teksArab'] }}
                        </h1>
                    </div>
                </div>

                <div style="padding-left: 52px; margin-top: 15px;">
                    <p style="color: #2e7d32; font-style: italic; font-size: 14px; margin-bottom: 8px; line-height: 1.5;">
                        {{ $ayat['teksLatin'] }}
                    </p>
                    
                    <p style="color: #444444; font-size: 14px; margin-bottom: 20px; line-height: 1.6;">
                        {{ $ayat['teksIndonesia'] }}
                    </p>

                    <div style="border-top: 1px dashed #e5e5e5; padding-top: 15px; display: flex; align-items: center; gap: 12px;">
                        <button type="button" class="btn-mic-ngaji" 
                                onclick="bukaKoreksiSuara('{{ $ayat['nomorAyat'] }}', '{{ $surah['namaLatin'] }}', '{{ $ayat['teksArab'] }}')"
                                style="background-color: #2e7d32; border: none; width: 42px; height: 42px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 3px 10px rgba(46,125,50,0.3); cursor: pointer; color: #ffffff; transition: all 0.2s;">
                            <i class="fa-solid fa-microphone" style="font-size: 16px;"></i>
                        </button>
                        <span style="font-size: 13px; color: #2e7d32; font-weight: bold;">Recite the sentence above (Koreksi Hafalan)</span>
                    </div>
                </div>

            </div>
        @endforeach
    @endif
</div>

<div class="modal fade" id="modalKoreksiSuara" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog" role="document" style="max-width: 450px; margin: 100px auto auto auto;">
    <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
      <div class="modal-header" style="background-color: #0f5132; color: white; border-top-left-radius: 19px; border-top-right-radius: 19px; text-align: center; padding: 15px; border-bottom: none;">
        <h4 class="modal-title" id="modalTitle" style="font-weight: bold; font-size: 16px; display: inline-block;">Koreksi Hafalan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.8; margin-top: -2px;" onclick="stopRecordingManual()"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" style="text-align: center; padding: 25px 20px;">
        
        <div id="statusMendengar" style="margin-bottom: 20px;">
            <i class="fa-solid fa-microphone-lines" style="font-size: 40px; color: #e67e22; animation: blink 1s infinite;"></i>
            <p style="margin-top: 12px; font-weight: bold; color: #555; font-size: 13px;" id="instruksiMic">Menghubungkan mic...</p>
        </div>

        <div style="background-color: #f8f9fa; border-radius: 12px; padding: 15px; min-height: 60px; border: 1px dashed #ccc; margin-bottom: 10px;">
            <span style="font-size: 11px; color: #999; display: block; margin-bottom: 5px; font-weight: bold;">SISTEM MENDENGAR:</span>
            <h3 id="liveTeksSuara" style="color: #222; font-family: 'Amiri', serif; margin: 0; direction: rtl; line-height: 1.8; font-size: 22px;">...</h3>
        </div>

        <div id="boxHasilAkhir" style="display: none; margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee;">
            <div id="labelAkurasi" style="margin-bottom: 15px;"></div>
            <div style="text-align: right; background-color: #f1f8e9; padding: 10px 15px; border-radius: 8px; margin-bottom: 15px;">
                <small style="color: #666; display:block; text-align: left; font-weight: bold;">Ayat Asli:</small>
                <strong id="teksBenarArab" style="font-size: 18px; color: #0f5132; font-family: 'Amiri', serif; display: block; direction: rtl;"></strong>
            </div>
            <button type="button" class="btn btn-default" style="border-radius: 20px; font-weight: bold; border: 1px solid #ccc; padding: 6px 20px;" onclick="ulangiPerekaman()">
                <i class="fa-solid fa-rotate-right"></i> Coba Lagi
            </button>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
    let ayatAktif = '';
    let teksAsliArab = '';
    let recognition;
    let isRecording = false;
    let currentAudio = null;
    let currentAudioBtn = null;

    // --- FUNGSI PLAY AUDIO (LISTENING MODE) ---
    function playAudio(url, btn) {
        if (currentAudio && currentAudioBtn === btn) {
            // Jika diklik tombol yang sama pas lagi play, maka pause
            if (!currentAudio.paused) {
                currentAudio.pause();
                btn.innerHTML = '<i class="fa-solid fa-volume-high" style="font-size: 12px;"></i>';
                btn.style.backgroundColor = '#ffffff';
                btn.style.color = '#e67e22';
                return;
            } else {
                currentAudio.play();
                btn.innerHTML = '<i class="fa-solid fa-pause" style="font-size: 12px;"></i>';
                btn.style.backgroundColor = '#e67e22';
                btn.style.color = '#ffffff';
                return;
            }
        }

        // Matikan audio lain yang sedang berputar
        if (currentAudio) {
            currentAudio.pause();
            if (currentAudioBtn) {
                currentAudioBtn.innerHTML = '<i class="fa-solid fa-volume-high" style="font-size: 12px;"></i>';
                currentAudioBtn.style.backgroundColor = '#ffffff';
                currentAudioBtn.style.color = '#e67e22';
            }
        }

        // Jalankan audio baru
        currentAudio = new Audio(url);
        currentAudioBtn = btn;
        
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="font-size: 12px;"></i>';

        currentAudio.oncanplaythrough = function() {
            btn.innerHTML = '<i class="fa-solid fa-pause" style="font-size: 12px;"></i>';
            btn.style.backgroundColor = '#e67e22';
            btn.style.color = '#ffffff';
        };

        currentAudio.play().catch(e => {
            alert("Gagal memuat audio murottal dari API.");
            btn.innerHTML = '<i class="fa-solid fa-volume-high" style="font-size: 12px;"></i>';
        });

        currentAudio.onended = function() {
            btn.innerHTML = '<i class="fa-solid fa-volume-high" style="font-size: 12px;"></i>';
            btn.style.backgroundColor = '#ffffff';
            btn.style.color = '#e67e22';
            currentAudio = null;
            currentAudioBtn = null;
        };
    }

    // --- INTERAKSI MIC RECITATION ---
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if (SpeechRecognition) {
        recognition = new SpeechRecognition();
        recognition.lang = 'ar-SA'; 
        recognition.interimResults = false;
        recognition.maxAlternatives = 1;

        recognition.onstart = function() {
            isRecording = true;
            document.getElementById('instruksiMic').innerText = "Mendengarkan... Silakan membaca.";
            document.getElementById('liveTeksSuara').innerText = "Menangkap lafal...";
        };

        recognition.onerror = function(event) {
            isRecording = false;
            let errText = "Gagal mendeteksi.";
            if (event.error === 'not-allowed') {
                errText = "Akses mic ditolak. Aktifkan izin mic di browser Anda.";
            } else if (event.error === 'no-speech') {
                errText = "Tidak ada suara terdeteksi. Silakan coba lagi.";
            }
            document.getElementById('instruksiMic').innerText = errText;
            document.getElementById('liveTeksSuara').innerText = "(Gagal)";
        };

        recognition.onresult = function(event) {
            let hasilTeksArab = event.results[0][0].transcript;
            document.getElementById('liveTeksSuara').innerText = hasilTeksArab;
            evaluasiHafalanSuara(hasilTeksArab);
        };
    }

    function bukaKoreksiSuara(nomorAyat, namaSurat, teksArab) {
        // Stop audio listening jika sedang berputar saat mau ngaji
        if (currentAudio) {
            currentAudio.pause();
            if (currentAudioBtn) currentAudioBtn.innerHTML = '<i class="fa-solid fa-volume-high" style="font-size: 12px;"></i>';
        }

        ayatAktif = nomorAyat;
        teksAsliArab = teksArab;

        document.getElementById('modalTitle').innerText = 'Koreksi Ayat ' + nomorAyat;
        document.getElementById('boxHasilAkhir').style.display = 'none';
        document.getElementById('liveTeksSuara').innerText = '...';
        document.getElementById('instruksiMic').innerText = "Membuka Mikrofon...";
        
        $('#modalKoreksiSuara').modal('show');

        if (recognition && isRecording) {
            recognition.stop();
        }

        setTimeout(() => {
            if (recognition) {
                try { recognition.start(); } catch (e) { console.error(e); }
            }
        }, 400);
    }

    function stopRecordingManual() {
        if(recognition && isRecording) { recognition.stop(); }
    }

    function ulangiPerekaman() {
        document.getElementById('boxHasilAkhir').style.display = 'none';
        document.getElementById('liveTeksSuara').innerText = '...';
        if(recognition) recognition.start();
    }

    function cleanArabic(text) {
        if (!text) return "";
        return text.replace(/[\u064B-\u065F\u0670\u06D6-\u06ED]/g, "")
                   .replace(/[إأآا]/g, "ا")
                   .replace(/ة/g, "ه")
                   .replace(/\s+/g, ' ')
                   .trim();
    }

    function evaluasiHafalanSuara(teksSuaraUser) {
        let bersihBenar = cleanArabic(teksAsliArab);
        let bersihUser = cleanArabic(teksSuaraUser);
        
        let labelAkurasi = document.getElementById('labelAkurasi');
        document.getElementById('teksBenarArab').innerText = teksAsliArab;

        if (bersihUser === bersihBenar || bersihBenar.includes(bersihUser) || bersihUser.includes(bersihBenar)) {
            labelAkurasi.innerHTML = '<span class="label label-success" style="font-size:13px; padding: 6px 12px; border-radius:8px; background-color:#2e7d32; color:white; display:inline-block;"><i class="fa fa-circle-check"></i> Sempurna / Sesuai</span>';
        } else {
            labelAkurasi.innerHTML = '<span class="label label-danger" style="font-size:13px; padding: 6px 12px; border-radius:8px; background-color:#c62828; color:white; display:inline-block;"><i class="fa fa-triangle-exclamation"></i> Ada Perbedaan Lafal</span>';
        }

        document.getElementById('boxHasilAkhir').style.display = 'block';
    }
</script>

<style>
    @keyframes blink { 0% { opacity: 0.4; } 50% { opacity: 1; } 100% { opacity: 0.4; } }
    .btn-mic-ngaji:hover { transform: scale(1.1); background-color: #1b5e20 !important; }
    .btn-audio-listening:hover { transform: scale(1.1); border-color: #e67e22 !important; }
</style>
@endsection

```
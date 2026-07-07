@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    body { background-color: #fdfbf7; font-family: 'Inter', sans-serif; }
    .header-surah {
        background-color: #fcf9f2; border-radius: 16px; padding: 40px; margin-bottom: 30px;
        border: 1px solid #eee7d5; position: relative; overflow: hidden;
    }
    .header-surah::before {
        content: ''; position: absolute; top: 0; left: 0; width: 6px; height: 100%; background-color: #115e3b;
    }
    .btn-back-pill {
        background: #ffffff; border: 1px solid #e5e7eb; color: #374151; border-radius: 999px; 
        padding: 8px 20px; font-weight: 600; font-size: 14px; text-decoration: none; 
        display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .btn-back-pill:hover { background: #f9fafb; color: #115e3b; border-color: #115e3b; text-decoration: none; }
    
    .ayat-card { background: #ffffff; border-radius: 16px; padding: 30px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #f0f0f0; }
    .arab-text { font-family: 'Amiri', serif; font-size: 38px; color: #1f2937; line-height: 2.4; margin: 0; direction: rtl; font-weight: 700; }
    
    .action-badge {
        display: flex; flex-direction: column; align-items: center; gap: 10px; flex-shrink: 0;
    }
    .ayat-number-circle {
        background-color: #115e3b; color: white; width: 40px; height: 40px; border-radius: 50%; 
        display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 16px; box-shadow: 0 4px 10px rgba(17,94,59,0.2);
    }
    .btn-audio-listening {
        background-color: #ffffff; border: 1px solid #d1d5db; color: #115e3b; width: 36px; height: 36px;
        border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;
        transition: all 0.2s; box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .btn-audio-listening:hover { border-color: #115e3b; background-color: #f0fdf4; transform: scale(1.05); }
    
    .koreksi-box {
        background-color: #fcf9f2; border-radius: 12px; padding: 15px 20px; margin-top: 20px;
        display: flex; align-items: center; justify-content: space-between; border: 1px solid #eee7d5;
    }
    .btn-mic-ngaji {
        background-color: #115e3b; color: white; border: none; padding: 10px 20px; border-radius: 999px;
        font-weight: 600; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px;
        transition: all 0.2s; box-shadow: 0 4px 10px rgba(17,94,59,0.2);
    }
    .btn-mic-ngaji:hover { background-color: #0e4b2f; transform: translateY(-2px); }

    @keyframes blink { 0% { opacity: 0.4; } 50% { opacity: 1; } 100% { opacity: 0.4; } }
</style>

<div class="container" style="max-width: 900px; margin-top: 30px; margin-bottom: 60px;">
    
    <div style="margin-bottom: 20px;">
        <a href="/quran" class="btn-back-pill">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="header-surah">
        <div style="font-size: 12px; font-weight: 700; color: #9ca3af; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 10px;">
            LATIHAN HAFALAN &bull; {{ $surah['tempatTurun'] ?? 'Mekah' }}
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div>
                <h1 style="font-size: 36px; font-weight: 800; color: #115e3b; margin: 0 0 5px 0; font-family: 'Amiri', serif;">
                    {{ $surah['nama'] ?? 'الفاتحة' }}
                </h1>
                <h2 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 5px 0;">
                    {{ $surah['namaLatin'] ?? '' }}
                </h2>
                <p style="color: #6b7280; font-size: 15px; margin: 0;">"{{ $surah['arti'] ?? '' }}"</p>
            </div>
            <div>
                <div style="background: #115e3b; color: white; padding: 10px 20px; border-radius: 999px; font-weight: 600; font-size: 14px; display: inline-block;">
                    {{ $surah['jumlahAyat'] ?? 0 }} Ayat
                </div>
            </div>
        </div>
    </div>

    @if(isset($surah['ayat']) && is_array($surah['ayat']))
        @foreach($surah['ayat'] as $ayat)
            <div class="ayat-card">
                
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px;">
                    <div class="action-badge">
                        <div class="ayat-number-circle">{{ $ayat['nomorAyat'] }}</div>
                        @php
                            $audioUrl = $ayat['audio']['01'] ?? $ayat['audio'] ?? 'https://equran.nos.wjv-1.neo.id/audio-partial/Mishary-Rashid-Alafasy/' . sprintf('%03d', $surah['nomor']) . sprintf('%03d', $ayat['nomorAyat']) . '.mp3';
                        @endphp
                        <button type="button" class="btn-audio-listening" onclick="playAudio('{{ $audioUrl }}', this)" title="Dengarkan Murottal">
                            <i class="fa-solid fa-volume-high" style="font-size: 14px;"></i>
                        </button>
                    </div>

                    <div style="width: 100%; text-align: right;">
                        <h1 class="arab-text">{{ $ayat['teksArab'] }}</h1>
                    </div>
                </div>

                <div style="margin-top: 20px; padding-left: 50px;">
                    <p style="color: #115e3b; font-style: italic; font-size: 15px; font-weight: 600; margin-bottom: 8px;">
                        {{ $ayat['teksLatin'] }}
                    </p>
                    <p style="color: #4b5563; font-size: 15px; line-height: 1.7; margin-bottom: 0;">
                        {{ $ayat['teksIndonesia'] }}
                    </p>

                    <div class="koreksi-box">
                        <div>
                            <strong style="color: #1f2937; display: block; font-size: 14px;">Fitur Koreksi Suara</strong>
                            <span style="color: #6b7280; font-size: 13px;">Uji ketepatan pelafalan ayat ini</span>
                        </div>
                        <button type="button" class="btn-mic-ngaji" onclick="bukaKoreksiSuara('{{ $ayat['nomorAyat'] }}', '{{ $surah['namaLatin'] }}', '{{ $ayat['teksArab'] }}')">
                            <i class="fa-solid fa-microphone"></i> Mulai Rekam
                        </button>
                    </div>
                </div>

            </div>
        @endforeach
    @endif
</div>

<div class="modal fade" id="modalKoreksiSuara" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog" role="document" style="max-width: 450px; margin: 10vh auto;">
    <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
      <div class="modal-header" style="background-color: #115e3b; color: white; border-top-left-radius: 19px; border-top-right-radius: 19px; padding: 20px; border-bottom: none; display: flex; justify-content: space-between; align-items: center;">
        <h4 class="modal-title" id="modalTitle" style="font-weight: 700; font-size: 16px; margin: 0;">Koreksi Hafalan</h4>
        <button type="button" style="background: none; border: none; color: white; font-size: 24px; opacity: 0.8; cursor: pointer; padding: 0;" data-dismiss="modal" onclick="stopRecordingManual()">&times;</button>
      </div>
      
      <div class="modal-body" style="text-align: center; padding: 30px 25px;">
        <div id="statusMendengar" style="margin-bottom: 25px;">
            <div style="width: 70px; height: 70px; background: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; animation: blink 1.5s infinite;">
                <i class="fa-solid fa-microphone-lines" style="font-size: 30px; color: #d97706;"></i>
            </div>
            <p style="margin-top: 15px; font-weight: 600; color: #4b5563; font-size: 14px;" id="instruksiMic">Menghubungkan mic...</p>
        </div>

        <div style="background-color: #f9fafb; border-radius: 12px; padding: 20px; min-height: 80px; border: 1px solid #e5e7eb; margin-bottom: 10px;">
            <span style="font-size: 11px; color: #9ca3af; display: block; margin-bottom: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Hasil Suara Anda:</span>
            <h3 id="liveTeksSuara" style="color: #1f2937; font-family: 'Amiri', serif; margin: 0; direction: rtl; line-height: 1.8; font-size: 24px;">...</h3>
        </div>

        <div id="boxHasilAkhir" style="display: none; margin-top: 25px; padding-top: 20px; border-top: 1px solid #f3f4f6;">
            <div id="labelAkurasi" style="margin-bottom: 20px;"></div>
            
            <div style="text-align: right; background-color: #f0fdf4; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #bbf7d0;">
                <small style="color: #166534; display:block; text-align: left; font-weight: 700; margin-bottom: 5px;">Ayat Seharusnya:</small>
                <strong id="teksBenarArab" style="font-size: 20px; color: #14532d; font-family: 'Amiri', serif; display: block; direction: rtl;"></strong>
            </div>
            
            <button type="button" style="background: #ffffff; border: 1px solid #d1d5db; color: #374151; padding: 10px 24px; border-radius: 999px; font-weight: 600; cursor: pointer; transition: background 0.2s;" onclick="ulangiPerekaman()">
                <i class="fa-solid fa-rotate-right" style="margin-right: 5px;"></i> Coba Lagi
            </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    // SCRIPT LOGIC TETAP SAMA SEPERTI SEBELUMNYA
    let ayatAktif = '';
    let teksAsliArab = '';
    let recognition;
    let isRecording = false;
    let currentAudio = null;
    let currentAudioBtn = null;

    function playAudio(url, btn) {
        if (currentAudio && currentAudioBtn === btn) {
            if (!currentAudio.paused) {
                currentAudio.pause();
                btn.innerHTML = '<i class="fa-solid fa-volume-high" style="font-size: 14px;"></i>';
                btn.style.backgroundColor = '#ffffff'; btn.style.color = '#115e3b';
                return;
            } else {
                currentAudio.play();
                btn.innerHTML = '<i class="fa-solid fa-pause" style="font-size: 14px;"></i>';
                btn.style.backgroundColor = '#115e3b'; btn.style.color = '#ffffff';
                return;
            }
        }
        if (currentAudio) {
            currentAudio.pause();
            if (currentAudioBtn) {
                currentAudioBtn.innerHTML = '<i class="fa-solid fa-volume-high" style="font-size: 14px;"></i>';
                currentAudioBtn.style.backgroundColor = '#ffffff'; currentAudioBtn.style.color = '#115e3b';
            }
        }
        currentAudio = new Audio(url); currentAudioBtn = btn;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="font-size: 14px;"></i>';
        currentAudio.oncanplaythrough = function() {
            btn.innerHTML = '<i class="fa-solid fa-pause" style="font-size: 14px;"></i>';
            btn.style.backgroundColor = '#115e3b'; btn.style.color = '#ffffff';
        };
        currentAudio.play().catch(e => {
            alert("Gagal memuat audio murottal dari API.");
            btn.innerHTML = '<i class="fa-solid fa-volume-high" style="font-size: 14px;"></i>';
        });
        currentAudio.onended = function() {
            btn.innerHTML = '<i class="fa-solid fa-volume-high" style="font-size: 14px;"></i>';
            btn.style.backgroundColor = '#ffffff'; btn.style.color = '#115e3b';
            currentAudio = null; currentAudioBtn = null;
        };
    }

    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (SpeechRecognition) {
        recognition = new SpeechRecognition();
        recognition.lang = 'ar-SA'; recognition.interimResults = false; recognition.maxAlternatives = 1;
        recognition.onstart = function() {
            isRecording = true;
            document.getElementById('instruksiMic').innerText = "Mendengarkan... Silakan membaca.";
            document.getElementById('liveTeksSuara').innerText = "Menangkap lafal...";
        };
        recognition.onerror = function(event) {
            isRecording = false; let errText = "Gagal mendeteksi.";
            if (event.error === 'not-allowed') errText = "Akses mic ditolak.";
            else if (event.error === 'no-speech') errText = "Tidak ada suara terdeteksi.";
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
        if (currentAudio) { currentAudio.pause(); if (currentAudioBtn) currentAudioBtn.innerHTML = '<i class="fa-solid fa-volume-high" style="font-size: 14px;"></i>'; }
        ayatAktif = nomorAyat; teksAsliArab = teksArab;
        document.getElementById('modalTitle').innerText = 'Koreksi Ayat ' + nomorAyat;
        document.getElementById('boxHasilAkhir').style.display = 'none';
        document.getElementById('liveTeksSuara').innerText = '...';
        document.getElementById('instruksiMic').innerText = "Membuka Mikrofon...";
        $('#modalKoreksiSuara').modal('show');
        if (recognition && isRecording) recognition.stop();
        setTimeout(() => { if (recognition) try { recognition.start(); } catch (e) { console.error(e); } }, 400);
    }
    function stopRecordingManual() { if(recognition && isRecording) recognition.stop(); }
    function ulangiPerekaman() {
        document.getElementById('boxHasilAkhir').style.display = 'none';
        document.getElementById('liveTeksSuara').innerText = '...';
        if(recognition) recognition.start();
    }
    function cleanArabic(text) {
        if (!text) return "";
        return text.replace(/[\u064B-\u065F\u0670\u06D6-\u06ED]/g, "").replace(/[إأآا]/g, "ا").replace(/ة/g, "ه").replace(/\s+/g, ' ').trim();
    }
    function evaluasiHafalanSuara(teksSuaraUser) {
        let bersihBenar = cleanArabic(teksAsliArab); let bersihUser = cleanArabic(teksSuaraUser);
        let labelAkurasi = document.getElementById('labelAkurasi');
        document.getElementById('teksBenarArab').innerText = teksAsliArab;
        if (bersihUser === bersihBenar || bersihBenar.includes(bersihUser) || bersihUser.includes(bersihBenar)) {
            labelAkurasi.innerHTML = '<span style="background-color:#16a34a; color:white; padding: 8px 16px; border-radius:999px; font-size:14px; font-weight:600; display:inline-block;"><i class="fa fa-circle-check"></i> Pelafalan Sesuai</span>';
        } else {
            labelAkurasi.innerHTML = '<span style="background-color:#dc2626; color:white; padding: 8px 16px; border-radius:999px; font-size:14px; font-weight:600; display:inline-block;"><i class="fa fa-triangle-exclamation"></i> Ada Perbedaan Lafal</span>';
        }
        document.getElementById('boxHasilAkhir').style.display = 'block';
    }
</script>
@endsection
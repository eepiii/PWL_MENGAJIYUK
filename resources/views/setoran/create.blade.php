@extends('layouts.app')

@section('content')
@include('partials.ledger-style')

<div class="container" style="max-width: 700px; margin-top: 20px; margin-bottom: 40px;">
<div class="ledger-page">

    <a href="{{ route('setoran.index') }}" class="lg-back">&larr; Kembali ke riwayat</a>

    <div class="lg-eyebrow">Setoran baru</div>
    <h1 class="lg-title" style="font-size: 26px;">Setor Hafalan</h1>
    <p class="lg-subtitle" style="margin-bottom: 24px;">Pilih surah dan rentang ayat, lalu rekam bacaanmu langsung dari browser.</p>

    @if ($errors->any())
        <div class="lg-alert lg-alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="lg-section">
        <form id="formSetoran" action="{{ route('setoran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="lg-form-group">
                <label class="lg-field-label">Surah</label>
                <select name="surah_id" class="lg-input" required>
                    <option value="">-- Pilih Surah --</option>
                    @foreach ($surahs as $surah)
                        <option value="{{ $surah->id }}" {{ old('surah_id') == $surah->id ? 'selected' : '' }}>
                            {{ $surah->nomor_surah }}. {{ $surah->nama_latin }} ({{ $surah->jumlah_ayat }} ayat)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="lg-form-grid" style="grid-template-columns: 1fr 1fr;">
                <div class="lg-form-group">
                    <label class="lg-field-label">Ayat mulai</label>
                    <input type="number" name="ayat_mulai" class="lg-input" min="1" value="{{ old('ayat_mulai') }}" required>
                </div>
                <div class="lg-form-group">
                    <label class="lg-field-label">Ayat selesai</label>
                    <input type="number" name="ayat_selesai" class="lg-input" min="1" value="{{ old('ayat_selesai') }}" required>
                </div>
            </div>

            <div class="lg-form-group">
                <label class="lg-field-label">Catatan (opsional)</label>
                <textarea name="catatan" class="lg-input" rows="2" placeholder="Contoh: sudah muroja'ah 3x sebelum setor">{{ old('catatan') }}</textarea>
            </div>

            <div class="lg-record-box">
                <div id="recordControls">
                    <button type="button" id="btnRecord" class="lg-mic-btn">Mulai rekam</button>
                </div>
                <p class="lg-record-hint" id="statusRekam">Rekam bacaan hafalanmu sebelum mengirim setoran.</p>
                <audio id="previewAudio" controls style="display:none;"></audio>
                <input type="file" name="audio" id="audioInput" style="display:none;" accept="audio/*">
            </div>

            <button type="submit" id="btnSubmit" class="lg-btn lg-btn-solid lg-btn-block" disabled>Kirim setoran</button>
        </form>
    </div>

</div>
</div>

<script>
    let mediaRecorder;
    let chunks = [];
    let recordedBlob = null;

    const btnRecord = document.getElementById('btnRecord');
    const btnSubmit = document.getElementById('btnSubmit');
    const statusRekam = document.getElementById('statusRekam');
    const preview = document.getElementById('previewAudio');
    const form = document.getElementById('formSetoran');

    function startRecording() {
        navigator.mediaDevices.getUserMedia({ audio: true }).then((stream) => {
            chunks = [];
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = (e) => chunks.push(e.data);
            mediaRecorder.onstop = () => {
                recordedBlob = new Blob(chunks, { type: 'audio/webm' });
                preview.src = URL.createObjectURL(recordedBlob);
                preview.style.display = 'block';
                btnSubmit.disabled = false;
                statusRekam.innerText = 'Rekaman selesai. Dengarkan dulu sebelum mengirim.';
                stream.getTracks().forEach(track => track.stop());

                btnRecord.innerText = 'Rekam ulang';
                btnRecord.classList.remove('lg-recording');
                btnRecord.onclick = startRecording;
            };

            mediaRecorder.start();
            btnRecord.innerText = 'Berhenti merekam';
            btnRecord.classList.add('lg-recording');
            btnRecord.onclick = stopRecording;
            statusRekam.innerText = 'Sedang merekam...';
        }).catch(() => {
            alert('Tidak bisa mengakses mikrofon. Pastikan izin mic diaktifkan di browser.');
        });
    }

    function stopRecording() {
        if (mediaRecorder) mediaRecorder.stop();
    }

    btnRecord.onclick = startRecording;

    form.addEventListener('submit', (e) => {
        if (!recordedBlob) {
            e.preventDefault();
            alert('Silakan rekam hafalan terlebih dahulu.');
            return;
        }
        const file = new File([recordedBlob], 'setoran-' + Date.now() + '.webm', { type: 'audio/webm' });
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('audioInput').files = dt.files;
    });
</script>
@endsection
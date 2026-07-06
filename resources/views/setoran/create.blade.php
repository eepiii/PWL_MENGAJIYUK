@extends('layouts.app')

@section('content')
<div class="container" style="max-width:700px;margin-top:30px;margin-bottom:60px;">
    <a href="{{ route('setoran.index') }}" class="btn btn-default btn-sm" style="border-radius:20px;margin-bottom:20px;">← Kembali ke Riwayat</a>

    <div class="panel panel-default" style="border-radius:12px;padding:30px;box-shadow:0 4px 12px rgba(0,0,0,0.05);">
        <h3 style="margin-top:0;color:#0f5132;font-weight:bold;">Setor Hafalan Baru</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin-bottom:0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="formSetoran" action="{{ route('setoran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Surah</label>
                <select name="surah_id" class="form-control" required>
                    <option value="">-- Pilih Surah --</option>
                    @foreach ($surahs as $surah)
                        <option value="{{ $surah->id }}" {{ old('surah_id') == $surah->id ? 'selected' : '' }}>
                            {{ $surah->nomor_surah }}. {{ $surah->nama_latin }} ({{ $surah->jumlah_ayat }} ayat)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Ayat Mulai</label>
                        <input type="number" name="ayat_mulai" class="form-control" min="1" value="{{ old('ayat_mulai') }}" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Ayat Selesai</label>
                        <input type="number" name="ayat_selesai" class="form-control" min="1" value="{{ old('ayat_selesai') }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Catatan (opsional)</label>
                <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: sudah muroja'ah 3x sebelum setor">{{ old('catatan') }}</textarea>
            </div>

            <hr>

            <div class="form-group text-center">
                <label style="display:block;font-weight:bold;color:#555;">Rekam Bacaan Hafalan</label>

                <div style="margin:15px 0;">
                    <button type="button" id="btnRecord" class="btn btn-danger" style="border-radius:30px;padding:10px 25px;font-weight:bold;">
                        <i class="fa fa-microphone"></i> Mulai Rekam
                    </button>
                    <button type="button" id="btnStop" class="btn btn-default" style="border-radius:30px;padding:10px 25px;font-weight:bold;display:none;">
                        <i class="fa fa-stop"></i> Berhenti
                    </button>
                </div>

                <p id="statusRekam" style="color:#888;font-size:13px;"></p>

                <audio id="previewAudio" controls style="display:none;width:100%;margin-top:10px;"></audio>
                <input type="file" name="audio" id="audioInput" style="display:none;" accept="audio/*">
            </div>

            <button type="submit" id="btnSubmit" class="btn btn-success btn-block" style="border-radius:30px;padding:12px;font-weight:bold;background-color:#0f5132;border-color:#0f5132;color:white;" disabled>
                Kirim Setoran
            </button>
        </form>
    </div>
</div>

<script>
    let mediaRecorder;
    let chunks = [];
    let recordedBlob = null;

    const btnRecord = document.getElementById('btnRecord');
    const btnStop = document.getElementById('btnStop');
    const btnSubmit = document.getElementById('btnSubmit');
    const statusRekam = document.getElementById('statusRekam');
    const preview = document.getElementById('previewAudio');
    const form = document.getElementById('formSetoran');

    btnRecord.addEventListener('click', async () => {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            chunks = [];
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = (e) => chunks.push(e.data);
            mediaRecorder.onstop = () => {
                recordedBlob = new Blob(chunks, { type: 'audio/webm' });
                preview.src = URL.createObjectURL(recordedBlob);
                preview.style.display = 'block';
                btnSubmit.disabled = false;
                statusRekam.innerText = 'Rekaman selesai. Silakan dengarkan sebelum mengirim.';
                stream.getTracks().forEach(track => track.stop());
            };

            mediaRecorder.start();
            btnRecord.style.display = 'none';
            btnStop.style.display = 'inline-block';
            statusRekam.innerText = 'Sedang merekam...';
        } catch (err) {
            alert('Tidak bisa mengakses mikrofon. Pastikan izin mic diaktifkan di browser.');
        }
    });

    btnStop.addEventListener('click', () => {
        mediaRecorder.stop();
        btnStop.style.display = 'none';
        btnRecord.style.display = 'inline-block';
        btnRecord.innerHTML = '<i class="fa fa-microphone"></i> Rekam Ulang';
    });

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
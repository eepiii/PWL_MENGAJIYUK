@extends('layouts.app')

@section('content')
@include('partials.ledger-style')

<div class="container" style="max-width: 650px; margin-top: 20px; margin-bottom: 40px;">
<div class="ledger-page">

    <a href="{{ route('setoran.show', $setoran->id) }}" class="lg-back">&larr; Kembali</a>

    <div class="lg-eyebrow">Beri penilaian</div>
    <p class="lg-surah-name" style="font-size: 26px;">{{ $setoran->surah->nama_latin ?? '-' }} : {{ $setoran->ayat_mulai }}-{{ $setoran->ayat_selesai }}</p>
    <p class="lg-subtitle" style="margin-bottom: 20px;">Santri: <b>{{ $setoran->santri->name }}</b></p>

    <div class="lg-section">
        <audio controls>
            <source src="{{ asset('storage/' . $setoran->audio_path) }}" type="audio/webm">
        </audio>

        @if ($errors->any())
            <div class="lg-alert lg-alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('nilai.store', $setoran->id) }}" method="POST" style="margin-top: 16px;">
            @csrf

            <div class="lg-form-group">
                <label class="lg-field-label">Kelancaran (0-100)</label>
                <input type="number" name="kelancaran" id="kelancaran" class="lg-input nilai-input" min="0" max="100" value="{{ old('kelancaran') }}" required>
            </div>
            <div class="lg-form-group">
                <label class="lg-field-label">Tajwid (0-100)</label>
                <input type="number" name="tajwid" id="tajwid" class="lg-input nilai-input" min="0" max="100" value="{{ old('tajwid') }}" required>
            </div>
            <div class="lg-form-group">
                <label class="lg-field-label">Makhraj (0-100)</label>
                <input type="number" name="makhraj" id="makhraj" class="lg-input nilai-input" min="0" max="100" value="{{ old('makhraj') }}" required>
            </div>

            <div class="lg-total-preview">Nilai akhir (otomatis): <span id="previewTotal">0</span></div>

            <div class="lg-form-group">
                <label class="lg-field-label">Catatan untuk santri</label>
                <textarea name="catatan" class="lg-input" rows="3">{{ old('catatan') }}</textarea>
            </div>

            <button type="submit" class="lg-btn lg-btn-solid lg-btn-block">Simpan nilai</button>
        </form>
    </div>

</div>
</div>

<script>
    const inputs = document.querySelectorAll('.nilai-input');
    const previewTotal = document.getElementById('previewTotal');

    function updateTotal() {
        const k = parseFloat(document.getElementById('kelancaran').value) || 0;
        const t = parseFloat(document.getElementById('tajwid').value) || 0;
        const m = parseFloat(document.getElementById('makhraj').value) || 0;
        previewTotal.innerText = Math.round((k + t + m) / 3);
    }

    inputs.forEach(el => el.addEventListener('input', updateTotal));
</script>
@endsection
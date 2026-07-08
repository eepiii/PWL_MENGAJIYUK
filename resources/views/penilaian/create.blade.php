@extends('layouts.app')

@section('content')
@include('partials.ledger-style')

<div class="container" style="max-width: 650px; margin-top: 20px; margin-bottom: 40px;">
<div class="ledger-page">

    <a href="{{ route('setoran.index') }}" class="lg-back">&larr; Kembali</a>

    <div class="lg-eyebrow">Beri Penilaian</div>
    <p class="lg-surah-name" style="font-size: 26px;">{{ $setoran->surah }}</p>
    <p class="lg-subtitle" style="margin-bottom: 20px;">
        Santri: <b>{{ $setoran->santri->name }}</b> ·
        {{ $setoran->created_at->format('d M Y') }}
    </p>

    <div class="lg-section">

        {{-- Audio --}}
        @if($setoran->audio_path)
            <audio controls style="width: 100%; margin-bottom: 20px;">
                <source src="{{ asset('storage/' . $setoran->audio_path) }}" type="audio/webm">
            </audio>
        @endif

        {{-- Error --}}
        @if($errors->any())
            <div class="lg-alert lg-alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('nilai.store', $setoran->id) }}" method="POST">
            @csrf

            <div class="lg-form-group">
                <label class="lg-field-label">Kelancaran (0-100)</label>
                <input type="number" name="kelancaran" id="kelancaran"
                    class="lg-input nilai-input"
                    min="0" max="100"
                    value="{{ old('kelancaran') }}" required>
            </div>

            <div class="lg-form-group">
                <label class="lg-field-label">Tajwid (0-100)</label>
                <input type="number" name="tajwid" id="tajwid"
                    class="lg-input nilai-input"
                    min="0" max="100"
                    value="{{ old('tajwid') }}" required>
            </div>

            <div class="lg-form-group">
                <label class="lg-field-label">Makhraj (0-100)</label>
                <input type="number" name="makhraj" id="makhraj"
                    class="lg-input nilai-input"
                    min="0" max="100"
                    value="{{ old('makhraj') }}" required>
            </div>

            <div class="lg-total-preview">
                Nilai akhir (otomatis): <span id="previewTotal">0</span>
            </div>

            <div class="lg-form-group">
                <label class="lg-field-label">Catatan untuk Santri (opsional)</label>
                <textarea name="catatan" class="lg-input" rows="3"
                    placeholder="Masukan atau saran untuk santri...">{{ old('catatan') }}</textarea>
            </div>

            <button type="submit" class="lg-btn lg-btn-solid lg-btn-block">
                Simpan Penilaian
            </button>
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
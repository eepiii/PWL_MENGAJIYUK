@extends('layouts.app')

@section('content')
@include('partials.ledger-style')

<div class="container" style="max-width: 800px; margin-top: 30px; margin-bottom: 50px;">
    <div class="ledger-page" style="border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 30px;">

        <a href="{{ route('setoran.index') }}" class="lg-back" style="text-decoration: none; font-weight: 500; color: #6b7280; display: inline-flex; align-items: center; gap: 5px;">&larr; Kembali</a>

        <div style="border-bottom: 2px dashed #e5e7eb; padding-bottom: 20px; margin-top: 15px; margin-bottom: 25px;">
            <div class="lg-eyebrow" style="text-transform: uppercase; letter-spacing: 0.05em; font-size: 12px; color: #9ca3af;">Rekap Pribadi</div>
            <h1 class="lg-title" style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 5px 0 0 0;">Progress Hafalan Saya</h1>
        </div>

        <div class="lg-section" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 25px; margin-bottom: 25px;">
            <p class="lg-section-title" style="font-size: 16px; font-weight: 700; color: #374151; margin-top: 0; margin-bottom: 15px;">Jumlah setoran per bulan</p>
            @if($setoranPerBulan->isEmpty())
                <p class="lg-section-sub" style="color: #9ca3af; font-style: italic;">Belum ada setoran.</p>
            @else
                <canvas id="chartSetoran" height="110"></canvas>
            @endif
        </div>

        <div class="lg-section" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 25px;">
            <p class="lg-section-title" style="font-size: 16px; font-weight: 700; color: #374151; margin-top: 0; margin-bottom: 15px;">Perkembangan nilai hafalan</p>
            @if($nilaiHistory->isEmpty())
                <p class="lg-section-sub" style="color: #9ca3af; font-style: italic;">Belum ada setoran yang dinilai.</p>
            @else
                <canvas id="chartNilai" height="110"></canvas>
            @endif
        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script>
    const dataSetoranPerBulan = @json($setoranPerBulan);
    const dataNilai = @json($nilaiHistory);

    if (dataSetoranPerBulan && dataSetoranPerBulan.length > 0) {
        new Chart(document.getElementById('chartSetoran'), {
            type: 'bar',
            data: {
                labels: dataSetoranPerBulan.map(d => d.bulan),
                datasets: [{
                    label: 'Jumlah setoran',
                    data: dataSetoranPerBulan.map(d => d.jumlah),
                    backgroundColor: '#10b981',
                    borderRadius: 4
                }]
            },
            options: { scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    }

    if (dataNilai && dataNilai.length > 0) {
        new Chart(document.getElementById('chartNilai'), {
            type: 'line',
            data: {
                labels: dataNilai.map(d => d.tanggal + ' - ' + d.surah),
                datasets: [
                    { label: 'Kelancaran', data: dataNilai.map(d => d.kelancaran), borderColor: '#f59e0b', tension: 0.3 },
                    { label: 'Tajwid', data: dataNilai.map(d => d.tajwid), borderColor: '#6366f1', tension: 0.3 },
                    { label: 'Makhraj', data: dataNilai.map(d => d.makhraj), borderColor: '#ef4444', tension: 0.3 },
                    { label: 'Nilai akhir', data: dataNilai.map(d => d.nilai_total), borderColor: '#10b981', borderWidth: 3, tension: 0.3 }
                ]
            },
            options: { scales: { y: { beginAtZero: true, max: 100 } } }
        });
    }
</script>
@endsection
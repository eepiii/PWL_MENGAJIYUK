@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 mt-5">
            
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Setoran Hafalan</h2>

            <div id="alertMessage" class="hidden mb-4 p-4 rounded font-bold"></div>

            <div class="mb-4">
                <label class="block font-bold text-gray-700 mb-2">Surah yang Disetor</label>
                <input type="text" id="surah" class="w-full border-gray-300 rounded-md shadow-sm p-2 border" placeholder="Contoh: Al-Mulk ayat 1-10">
            </div>

            <div class="mb-6 p-4 border rounded-lg bg-gray-50 text-center">
                <p class="font-bold text-gray-700 mb-4">Rekam Suara Hafalan</p>
                
                <div class="flex justify-center gap-4 mb-4">
                    <button type="button" id="btnStart" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow">
                        Mulai Rekam
                    </button>
                    <button type="button" id="btnStop" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow hidden">
                        Berhenti Rekam
                    </button>
                </div>
                
                <audio id="audioPlayback" controls class="w-full hidden mt-4"></audio>
            </div>

            <div class="mb-6">
                <label class="block font-bold text-gray-700 mb-2">Catatan (Opsional)</label>
                <textarea id="catatan" rows="3" class="w-full border-gray-300 rounded-md shadow-sm p-2 border"></textarea>
            </div>

            <button type="button" id="btnSubmit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow opacity-50 cursor-not-allowed" disabled>
                Kirim Setoran
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let mediaRecorder;
        let audioChunks = [];
        let audioBlob = null;

        const btnStart = document.getElementById('btnStart');
        const btnStop = document.getElementById('btnStop');
        const btnSubmit = document.getElementById('btnSubmit');
        const audioPlayback = document.getElementById('audioPlayback');
        const alertMessage = document.getElementById('alertMessage');

        btnStart.addEventListener('click', async () => {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                
                mediaRecorder.start();
                audioChunks = [];
                
                btnStart.classList.add('hidden');
                btnStop.classList.remove('hidden');
                audioPlayback.classList.add('hidden');
                btnSubmit.disabled = true;
                btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');

                mediaRecorder.addEventListener('dataavailable', event => {
                    audioChunks.push(event.data);
                });

                mediaRecorder.addEventListener('stop', () => {
                    audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                    const audioUrl = URL.createObjectURL(audioBlob);
                    audioPlayback.src = audioUrl;
                    audioPlayback.classList.remove('hidden');
                    
                    btnSubmit.disabled = false;
                    btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
                });
            } catch (error) {
                alert('Gagal mengakses mikrofon. Pastikan Anda memberikan izin.');
            }
        });

        btnStop.addEventListener('click', () => {
            if (mediaRecorder && mediaRecorder.state === 'recording') {
                mediaRecorder.stop();
                mediaRecorder.stream.getTracks().forEach(track => track.stop());
                
                btnStop.classList.add('hidden');
                btnStart.classList.remove('hidden');
                btnStart.innerText = 'Rekam Ulang';
            }
        });

        btnSubmit.addEventListener('click', async () => {
            const surah = document.getElementById('surah').value;
            const catatan = document.getElementById('catatan').value;

            if (!surah || !audioBlob) {
                alert('Surah dan rekaman wajib diisi!');
                return;
            }

            btnSubmit.disabled = true;
            btnSubmit.innerText = 'Mengirim...';

            const formData = new FormData();
            formData.append('surah', surah);
            formData.append('audio', audioBlob, 'rekaman.webm');
            formData.append('catatan', catatan);
            formData.append('_token', '{{ csrf_token() }}');

            try {
                const response = await fetch('{{ route('setoran.store') }}', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    alertMessage.innerText = result.message;
                    alertMessage.classList.remove('hidden', 'bg-red-100', 'text-red-700');
                    alertMessage.classList.add('bg-green-100', 'text-green-700');
                    setTimeout(() => window.location.reload(), 2000);
                } else {
                    throw new Error(result.message || 'Terjadi kesalahan');
                }
            } catch (error) {
                alertMessage.innerText = error.message;
                alertMessage.classList.remove('hidden', 'bg-green-100', 'text-green-700');
                alertMessage.classList.add('bg-red-100', 'text-red-700');
                btnSubmit.disabled = false;
                btnSubmit.innerText = 'Kirim Setoran';
            }
        });
    });
</script>
@endsection

@section('container')
    @yield('content')
@endsection

@section('main')
    @yield('content')
@endsection
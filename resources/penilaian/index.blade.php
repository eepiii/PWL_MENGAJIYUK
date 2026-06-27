<x-app-layout>
    <!-- Bagian Header (sudah ada) -->
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- 1. TABEL DAFTAR SETORAN -->
                <table class="w-full border">
                    <!-- ... kode isi tabel Anda ... -->
                    @foreach ($setorans as $setoran)
                        <tr>
                            <td>{{ $setoran->santri->name }}</td>
                            <td>
                                <!-- TOMBOL UNTUK MEMBUKA MODAL -->
                                <button onclick="document.getElementById('modal-{{ $setoran->id }}').classList.remove('hidden')" 
                                        class="bg-blue-500 text-white px-3 py-1 rounded">Nilai</button>
                            </td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>

    <!-- 2. MODAL FORM PENILAIAN (Simpan di bawah tabel, tapi masih di dalam file yang sama) -->
    @foreach ($setorans as $setoran)
        <div id="modal-{{ $setoran->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow-lg w-1/3">
                <!-- FORM ANDA DI SINI -->
                <form action="{{ route('penilaian.store', $setoran->id) }}" method="POST">
                    @csrf
                   <!-- Di dalam loop @foreach -->
@foreach ($setorans as $setoran)
    <!-- Tombol untuk membuka modal -->
    <button onclick="document.getElementById('modal-{{ $setoran->id }}').classList.remove('hidden')" 
            class="bg-blue-500 text-white px-3 py-1 rounded">Nilai</button>

    <!-- Modal (Pop-up) -->
    <div id="modal-{{ $setoran->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded shadow-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">Penilaian Santri: {{ $setoran->santri->name }}</h2>
            
            <form action="{{ route('penilaian.store', $setoran->id) }}" method="POST">
                @csrf
                <label class="block mb-1">Skor (0-100):</label>
                <input type="number" name="nilai" class="border p-2 w-full mb-3" required>
                
                <label class="block mb-1">Kategori:</label>
                <select name="kategori" class="border p-2 w-full mb-3">
                    <option value="lancar">Lancar</option>
                    <option value="cukup">Cukup</option>
                    <option value="perlu_ulang">Perlu Ulang</option>
                </select>
                
                <label class="block mb-1">Catatan:</label>
                <textarea name="catatan_guru" class="border p-2 w-full mb-4"></textarea>
                
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modal-{{ $setoran->id }}').classList.add('hidden')" 
                            class="bg-gray-400 text-white px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan Nilai</button>
                </div>
            </form>
        </div>
    </div>
@endforeach
                    <button type="submit">Simpan Nilai</button>
                </form>
            </div>
        </div>
    @endforeach

</x-app-layout>
<!-- resources/views/jurnal/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Jurnal Ibadah Harian
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <form action="{{ route('jurnal.index') }}" method="GET" class="flex items-center gap-2 mb-4 md:mb-0">
                        <label class="font-bold">Tanggal:</label>
                        <input type="date" name="tanggal" value="{{ $tanggal }}" class="border-gray-300 rounded-md shadow-sm" onchange="this.form.submit()">
                    </form>
                    <div class="bg-indigo-100 text-indigo-800 px-4 py-2 rounded-lg font-bold">
                        Progres Shalat: {{ $jurnal->persentaseShalat() }}%
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-4 rounded mb-6 font-bold">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('jurnal.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach(['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'] as $waktu)
                            @php 
                                $field = 'shalat_' . $waktu; 
                                $status = $jurnal->$field;
                            @endphp
                            
                            <div class="border p-4 rounded-lg {{ $status > 0 ? 'bg-green-50 border-green-400' : 'bg-gray-50 border-gray-200' }}">
                                <div class="flex justify-between items-center mb-2">
                                    <div>
                                        <label class="font-bold capitalize text-gray-700 block">Shalat {{ $waktu }}</label>
                                        @if($jadwalShalat && isset($jadwalShalat[$waktu]))
                                            <span class="text-xs text-indigo-600 font-semibold">Masuk: {{ $jadwalShalat[$waktu] }} WIB</span>
                                        @else
                                            <span class="text-xs text-red-500 font-semibold">Jadwal API tidak tersedia</span>
                                        @endif
                                    </div>
                                    @if($status > 0)
                                        <span class="text-green-600 font-bold text-sm bg-green-200 px-2 py-1 rounded">
                                            ✅ {{ $jurnal->labelShalat($status) }}
                                        </span>
                                    @endif
                                </div>
                                
                                <select name="{{ $field }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="0" {{ $status == 0 ? 'selected' : '' }}>Tidak Shalat</option>
                                    <option value="1" {{ $status == 1 ? 'selected' : '' }}>Tepat Waktu</option>
                                    <option value="2" {{ $status == 2 ? 'selected' : '' }}>Qadha</option>
                                </select>
                            </div>
                        @endforeach

                        <div class="border p-4 rounded-lg {{ $jurnal->puasa_sunnah ? 'bg-green-50 border-green-400' : 'bg-gray-50 border-gray-200' }}">
                            <div class="flex justify-between items-center mb-2">
                                <label class="font-bold text-gray-700">Puasa Sunnah</label>
                                @if($jurnal->puasa_sunnah)
                                    <span class="text-green-600 font-bold text-sm bg-green-200 px-2 py-1 rounded">✅ Selesai</span>
                                @endif
                            </div>
                            <select name="puasa_sunnah" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="0" {{ !$jurnal->puasa_sunnah ? 'selected' : '' }}>Tidak</option>
                                <option value="1" {{ $jurnal->puasa_sunnah ? 'selected' : '' }}>Ya</option>
                            </select>
                        </div>

                        <div class="border p-4 rounded-lg {{ $jurnal->tilawah_halaman > 0 ? 'bg-green-50 border-green-400' : 'bg-gray-50 border-gray-200' }}">
                            <div class="flex justify-between items-center mb-2">
                                <label class="font-bold text-gray-700">Tilawah (Jumlah Halaman)</label>
                                @if($jurnal->tilawah_halaman > 0)
                                    <span class="text-green-600 font-bold text-sm bg-green-200 px-2 py-1 rounded">✅ {{ $jurnal->tilawah_halaman }} Halaman</span>
                                @endif
                            </div>
                            <input type="number" name="tilawah_halaman" value="{{ $jurnal->tilawah_halaman }}" min="0" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="mt-6 border p-4 rounded-lg bg-gray-50 border-gray-200">
                        <label class="font-bold text-gray-700 block mb-2">Catatan Harian</label>
                        <textarea name="catatan" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Opsional...">{{ $jurnal->catatan }}</textarea>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow">
                            Simpan Pembaruan Jurnal
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
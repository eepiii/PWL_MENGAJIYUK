<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Baca Al-Quran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @foreach ($surahs as $surah)
                    <a href="{{ route('quran.show', $surah->nomor_surah) }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-indigo-50 transition duration-150 ease-in-out border border-gray-200 block">
                        <div class="p-6 text-gray-900 flex justify-between items-center">
                            
                            <div class="flex items-center space-x-4">
                                <div class="bg-indigo-100 text-indigo-800 font-bold w-12 h-12 flex items-center justify-center rounded-full text-lg">
                                    {{ $surah->nomor_surah }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg">{{ $surah->nama_latin }}</h3>
                                    <p class="text-sm text-gray-500">
                                        {{ $surah->arti }} • {{ $surah->jumlah_ayat }} Ayat
                                    </p>
                                </div>
                            </div>

                            <div class="text-2xl font-bold text-right text-gray-800" dir="rtl">
                                {{ $surah->nama_arab }}
                            </div>
                            
                        </div>
                    </a>
                @endforeach

            </div>
            
        </div>
    </div>
</x-app-layout>
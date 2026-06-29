@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 30px; margin-bottom: 50px;">
    <div class="row" style="margin-bottom: 40px;">
        <div class="col-md-12 text-center">
            <h1 style="font-weight: bold; color: #0f5132; margin-bottom: 10px;">
                <i class="fa fa-quran" style="margin-right: 10px;"></i> Al-Qur'an Digital
            </h1>
            <p class="text-muted" style="font-size: 16px;">
                Silakan pilih surah di bawah ini untuk mulai membaca dan mentadabburi ayat-ayat-Nya.
            </p>
            <hr style="border-top: 2px solid #0f5132; width: 80px; margin: 20px auto;">
        </div>
    </div>

    <div class="row">
        @foreach ($surah as $item)
            <div class="col-md-4" style="margin-bottom: 30px;">
                <div class="panel panel-default" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: none; transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.06)';">
                    
                    <div class="panel-body" style="padding: 25px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <div style="background-color: #0f5132; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px;">
                                {{ $item['nomor'] }}
                            </div>
                            @if(isset($item['nama']))
                                <h2 style="font-family: 'Amiri', serif; font-weight: bold; color: #0f5132; margin: 0; font-size: 28px; line-height: 1;">
                                    {{ $item['nama'] }}
                                </h2>
                            @endif
                        </div>

                        <div style="margin-bottom: 20px; border-top: 1px solid #eee; padding-top: 15px;">
                            <h4 style="font-weight: bold; color: #333; margin-bottom: 3px;">
                                {{ $item['namaLatin'] }}
                            </h4>
                            <p class="text-muted" style="margin-bottom: 8px; font-size: 13px; font-style: italic;">
                                "{{ $item['arti'] }}"
                            </p>
                            <span class="label label-success" style="background-color: #157347; font-weight: normal; font-size: 11px;">
                                {{ $item['jumlahAyat'] }} Ayat
                            </span>
                        </div>

                        <div style="margin-top: 15px;">
                            <a href="/quran/{{ $item['nomor'] }}" class="btn btn-block btn-primary" style="background-color: #0f5132; border-color: #0f5132; font-weight: bold; border-radius: 6px; padding: 10px 15px; font-size: 14px;">
                                Buka Surah <i class="fa fa-arrow-right" style="margin-left: 8px;"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
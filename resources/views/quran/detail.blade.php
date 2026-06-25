<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Surah</title>
</head>

<body>

    <h1>
        📖 Surah {{ $surah['namaLatin'] }}
        ({{ $surah['nama'] }})
    </h1>

    <p>
        Arti: {{ $surah['arti'] }}
    </p>

    <p>
        Jumlah Ayat: {{ $surah['jumlahAyat'] }}
    </p>

    <hr>

    @foreach ($surah['ayat'] as $ayat)

        <h3>
            Ayat {{ $ayat['nomorAyat'] }}
        </h3>

        <h2>
            {{ $ayat['teksArab'] }}
        </h2>

        <p>
            {{ $ayat['teksLatin'] }}
        </p>

        <p>
            {{ $ayat['teksIndonesia'] }}
        </p>

        <hr>

    @endforeach

</body>
</html>
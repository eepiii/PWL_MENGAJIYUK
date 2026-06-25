<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>MengajiYuk - Quran Reader</title>
</head>

<body>

    <h1>📖 Quran Reader</h1>

    <h3>Daftar Surah Al-Qur'an</h3>

    <ul>
        @foreach ($surah as $item)
            <li>
                <a href="/quran/{{ $item['nomor'] }}">
                    {{ $item['nomor'] }}.
                    {{ $item['namaLatin'] }}
                    ({{ $item['jumlahAyat'] }} ayat)
                    - {{ $item['arti'] }}
                </a>
            </li>
        @endforeach
    </ul>

</body>
</html>
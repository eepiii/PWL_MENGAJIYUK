<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MengajiYuk - Quran Reader</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body style="background-color: #f8f9fa;">
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top" style="background-color: #0f5132; border: none; margin-bottom: 20px; shadow: 0 2px 4px rgba(0,0,0,.08);">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" style="border-color: rgba(255,255,255,0.3); background-color: transparent;">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar" style="background-color: white;"></span>
                        <span class="icon-bar" style="background-color: white;"></span>
                        <span class="icon-bar" style="background-color: white;"></span>
                    </button>

                    <a class="navbar-brand" href="{{ url('/') }}" style="color: white; font-weight: bold;">
                        <i class="fas fa-quran" style="margin-right: 8px;"></i> MengajiYuk!
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="{{ route('quran.index') }}" style="color: white; background-color: rgba(255,255,255,0.15); font-weight: 500;">Al-Qur'an Digital</a>
                        </li>
                        <li><a href="#" style="color: rgba(255,255,255,0.8);">Setoran Hafalan</a></li>
                        <li><a href="#" style="color: rgba(255,255,255,0.8);">Jurnal Ibadah</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}" style="color: white;"><i class="fas fa-sign-in-alt" style="margin-right: 5px;"></i> Masuk</a></li>
                            <li><a href="{{ route('register') }}" style="color: white;"><i class="fas fa-user-plus" style="margin-right: 5px;"></i> Daftar Santri</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white; background-color: transparent;">
                                    <i class="fas fa-user-circle" style="margin-right: 5px;"></i> {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt text-danger" style="margin-right: 5px;"></i> Keluar
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fra76EXX7336rqVR91qfSG5M01s62nLkW655" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</body>
</html>
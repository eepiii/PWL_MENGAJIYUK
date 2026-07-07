<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — MengajiYuk!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            display: flex;
            width: 900px;
            max-width: 95vw;
            min-height: 520px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
        }

        /* Panel Kiri */
        .login-left {
            flex: 1;
            background: linear-gradient(160deg, #0f5132, #1a7a4a);
            color: white;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '🕌';
            position: absolute;
            font-size: 200px;
            right: -40px;
            bottom: -30px;
            opacity: 0.06;
            pointer-events: none;
        }

        .login-brand {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-brand-sub {
            font-size: 13px;
            opacity: 0.75;
            line-height: 1.6;
        }

        .login-quote {
            font-size: 13px;
            opacity: 0.7;
            font-style: italic;
            line-height: 1.7;
            border-left: 3px solid rgba(255,255,255,0.3);
            padding-left: 14px;
        }

        /* Panel Kanan */
        .login-right {
            flex: 1;
            background: white;
            padding: 50px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h2 {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            color: #1a3a2a;
            margin-bottom: 6px;
        }

        .login-right p.sub {
            font-size: 13px;
            color: #aaa;
            margin-bottom: 30px;
        }

        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #888;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 6px;
            display: block;
        }

        .form-control-custom {
            width: 100%;
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            color: #333;
            outline: none;
            transition: border-color 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .form-control-custom:focus {
            border-color: #0f5132;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #0f5132, #157347);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: opacity 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .btn-login:hover { opacity: 0.88; }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #aaa;
        }

        .login-footer a {
            color: #0f5132;
            font-weight: 600;
            text-decoration: none;
        }

        .login-footer a:hover { text-decoration: underline; }

        .alert-danger-custom {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .remember-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 16px 0 8px;
        }

        .remember-row label {
            font-size: 13px;
            color: #666;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            font-weight: 500;
            text-transform: none;
            letter-spacing: 0;
        }

        .remember-row a {
            font-size: 13px;
            color: #0f5132;
            font-weight: 600;
            text-decoration: none;
        }

        .remember-row a:hover { text-decoration: underline; }

        @media (max-width: 640px) {
            .login-left { display: none; }
            .login-right { padding: 40px 28px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    {{-- Panel Kiri --}}
    <div class="login-left">
        <div>
            <div class="login-brand">📖 MengajiYuk!</div>
            <p class="login-brand-sub">Platform digital untuk hafalan,<br>jurnal ibadah, dan Al-Qur'an digital.</p>
        </div>

        <div class="login-quote">
            "Sebaik-baik kalian adalah orang yang mempelajari Al-Qur'an dan mengajarkannya."
            <br><br>
            <span style="opacity: 0.6; font-style: normal; font-size: 12px;">— HR. Bukhari</span>
        </div>
    </div>

    {{-- Panel Kanan --}}
    <div class="login-right">
        <h2>Selamat Datang</h2>
        <p class="sub">Masuk ke akun MengajiYuk! kamu</p>

        {{-- Error --}}
        @if($errors->any())
            <div class="alert-danger-custom">
                ❌ {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group" style="margin-bottom: 18px;">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="form-control-custom"
                    placeholder="contoh@email.com" required autofocus>
            </div>

            <div class="form-group" style="margin-bottom: 4px;">
                <label>Password</label>
                <input type="password" name="password"
                    class="form-control-custom"
                    placeholder="••••••••" required>
            </div>

            <div class="remember-row">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Ingatkan saya
                </label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="btn-login">
                Masuk ke Akun
            </button>
        </form>

        <div class="login-footer">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>
    </div>

</div>

</body>
</html>
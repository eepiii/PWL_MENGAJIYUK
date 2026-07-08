<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap');

        .reg-brand {
            text-align: center;
            margin-bottom: 24px;
        }

        .reg-brand-icon {
            font-size: 40px;
            display: block;
            margin-bottom: 8px;
        }

        .reg-brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            color: #0f5132;
            font-weight: 700;
            margin: 0;
        }

        .reg-brand-sub {
            font-size: 13px;
            color: #aaa;
            margin-top: 4px;
        }

        .reg-label {
            font-size: 11px;
            font-weight: 700;
            color: #888;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-bottom: 6px;
            display: block;
        }

        .reg-input {
            width: 100%;
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 14px;
            color: #333;
            outline: none;
            transition: border-color 0.2s;
            font-family: 'Inter', sans-serif;
            background: #fafafa;
        }

        .reg-input:focus {
            border-color: #0f5132;
            background: white;
        }

        .role-wrap {
            display: flex;
            gap: 12px;
            margin-top: 6px;
        }

        .role-card {
            flex: 1;
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            padding: 14px;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
            background: #fafafa;
        }

        .role-card:hover {
            border-color: #0f5132;
        }

        .role-card input[type="radio"] {
            display: none;
        }

        .role-card.selected {
            border-color: #0f5132;
            background: #f0fdf4;
        }

        .role-icon { font-size: 24px; display: block; margin-bottom: 6px; }
        .role-name { font-size: 13px; font-weight: 700; color: #1a3a2a; }
        .role-desc { font-size: 11px; color: #aaa; margin-top: 2px; }

        .reg-btn {
            width: 100%;
            background: linear-gradient(135deg, #0f5132, #157347);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: opacity 0.2s;
            margin-top: 8px;
        }

        .reg-btn:hover { opacity: 0.88; }

        .reg-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #aaa;
        }

        .reg-footer a {
            color: #0f5132;
            font-weight: 600;
            text-decoration: none;
        }

        .reg-footer a:hover { text-decoration: underline; }
    </style>

    {{-- Brand --}}
    <div class="reg-brand">
        <span class="reg-brand-icon">📖</span>
        <p class="reg-brand-title">MengajiYuk!</p>
        <p class="reg-brand-sub">Buat akun baru untuk mulai belajar</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nama --}}
        <div style="margin-bottom: 16px;">
            <label class="reg-label">Nama Lengkap</label>
            <input id="name" type="text" name="name"
                value="{{ old('name') }}"
                class="reg-input"
                placeholder="Nama lengkap kamu"
                required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div style="margin-bottom: 16px;">
            <label class="reg-label">Email</label>
            <input id="email" type="email" name="email"
                value="{{ old('email') }}"
                class="reg-input"
                placeholder="contoh@email.com"
                required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div style="margin-bottom: 16px;">
            <label class="reg-label">Password</label>
            <input id="password" type="password" name="password"
                class="reg-input"
                placeholder="Minimal 8 karakter"
                required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div style="margin-bottom: 20px;">
            <label class="reg-label">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                class="reg-input"
                placeholder="Ulangi password"
                required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Role --}}
        <div style="margin-bottom: 20px;">
            <label class="reg-label">Daftar Sebagai</label>
            <div class="role-wrap">

                <label class="role-card {{ old('role') === 'santri' || !old('role') ? 'selected' : '' }}"
                       id="card-santri" onclick="selectRole('santri')">
                    <input type="radio" name="role" value="santri"
                        {{ old('role') === 'santri' || !old('role') ? 'checked' : '' }}>
                    <span class="role-icon">🎓</span>
                    <p class="role-name">Santri</p>
                    <p class="role-desc">Kirim & pantau setoran hafalan</p>
                </label>

                <label class="role-card {{ old('role') === 'guru' ? 'selected' : '' }}"
                       id="card-guru" onclick="selectRole('guru')">
                    <input type="radio" name="role" value="guru"
                        {{ old('role') === 'guru' ? 'checked' : '' }}>
                    <span class="role-icon">👨‍🏫</span>
                    <p class="role-name">Guru / Ustadz</p>
                    <p class="role-desc">Nilai & pantau seluruh santri</p>
                </label>

            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        {{-- Tombol Register --}}
        <button type="submit" class="reg-btn">
            Buat Akun
        </button>

    </form>

    {{-- Login --}}
    <div class="reg-footer">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a>
    </div>

    <script>
        function selectRole(role) {
            document.getElementById('card-santri').classList.remove('selected');
            document.getElementById('card-guru').classList.remove('selected');
            document.getElementById('card-' + role).classList.add('selected');
            document.querySelector('input[value="' + role + '"]').checked = true;
        }
    </script>

</x-guest-layout>
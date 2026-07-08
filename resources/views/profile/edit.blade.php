<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya — MengajiYuk!</title>
    <!-- Meload Bootstrap murni secara independen agar style tidak dirusak layout luar -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f8 !important;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
        }
        .main-container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .custom-card {
            background: #ffffff !important;
            border-radius: 20px !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
            padding: 30px !important;
        }
        .header-ustadz {
            background: linear-gradient(135deg, #0f5132, #1a5235) !important;
            border-radius: 20px !important;
            padding: 35px 30px !important;
        }
        .header-santri {
            background: linear-gradient(135deg, #198754, #145a32) !important;
            border-radius: 20px !important;
            padding: 35px 30px !important;
        }
        .form-label {
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #334155 !important;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .form-control {
            border-radius: 10px !important;
            padding: 11px 14px !important;
            border: 1px solid #cbd5e1 !important;
            font-size: 14px !important;
            background: #ffffff !important;
            color: #334155 !important;
        }
        /* Mengunci warna tombol hijau agar menyala terang dan kontras */
        .btn-custom-green {
            background-color: #198754 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            transition: all 0.2s ease;
        }
        .btn-custom-green:hover {
            background-color: #145a32 !important;
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2) !important;
        }
    </style>
</head>
<body>

<div class="main-container">
    
    {{-- ================= HEADER PROFIL DINAMIS ================= --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px; overflow: hidden;">
        @if(str_contains(strtolower(Auth::user()->name), 'ustadz') || str_contains(strtolower(Auth::user()->name), 'ustad'))
            <div class="header-ustadz text-white position-relative">
                <div style="position: absolute; right: 30px; bottom: 10px; font-size: 80px; opacity: 0.15; pointer-events: none;">🕌</div>
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center shadow-sm" style="width: 70px; height: 70px; font-size: 30px;">
                        👨‍🏫
                    </div>
                    <div class="ms-4">
                        <span class="badge bg-white text-success fw-bold mb-2 px-3 py-1" style="border-radius: 30px; font-size: 11px;">AKUN USTADZ / PENGAJAR</span>
                        <h4 class="fw-bold mb-1 m-0 text-white">{{ Auth::user()->name }}</h4>
                        <p class="mb-0 opacity-90 small text-white" style="font-size: 13px; margin-top: 4px;">✉  {{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="header-santri text-white position-relative">
                <div style="position: absolute; right: 30px; bottom: 10px; font-size: 80px; opacity: 0.15; pointer-events: none;">📖</div>
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center shadow-sm" style="width: 70px; height: 70px; font-size: 30px;">
                        🎒
                    </div>
                    <div class="ms-4">
                        <span class="badge bg-warning text-dark fw-bold mb-2 px-3 py-1" style="border-radius: 30px; font-size: 11px;">AKUN SANTRI</span>
                        <h4 class="fw-bold mb-1 m-0 text-white">{{ Auth::user()->name }}</h4>
                        <p class="mb-0 opacity-90 small text-white" style="font-size: 13px; margin-top: 4px;">✉  {{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- ================= KONTEN UTAMA FORM ================= --}}
    <div class="row g-4">
        
        {{-- Kiri: Form Update Profil & Password --}}
        <div class="col-md-7">
            
            {{-- Form Informasi Akun --}}
            <div class="custom-card mb-4">
                <h5 class="fw-bold mb-1" style="color: #0f5132; font-size: 18px;">Pengaturan Informasi Akun</h5>
                <p class="text-muted small mb-4" style="font-size: 13px;">Perbarui nama akun dan alamat email resmi kamu.</p>

                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label class="form-label">NAMA LENGKAP</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">ALAMAT EMAIL</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                    </div>

                    <button type="submit" class="btn btn-custom-green">
                        💾 Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- Form Ganti Password --}}
            <div class="custom-card">
                <h5 class="fw-bold mb-1" style="color: #0f5132; font-size: 18px;">Keamanan & Password</h5>
                <p class="text-muted small mb-4" style="font-size: 13px;">Ganti password secara berkala agar akunmu tetap aman.</p>

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label class="form-label">PASSWORD SEKARANG</label>
                        <input type="password" name="current_password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">PASSWORD BARU</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">KONFIRMASI PASSWORD BARU</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-custom-green">
                        🔑 Perbarui Password
                    </button>
                </form>
            </div>

        </div>

        {{-- Kanan: Widget Samping Sesuai Role --}}
        <div class="col-md-5">
            @if(str_contains(strtolower(Auth::user()->name), 'ustadz') || str_contains(strtolower(Auth::user()->name), 'ustad'))
                <div class="card border-0 shadow-sm p-4 text-white" style="border-radius: 20px; background: #1e293b; min-height: 340px;">
                    <h5 class="fw-bold mb-3 text-white">⚡ Ruang Pengajar</h5>
                    <p class="small opacity-75" style="font-size: 13px;">Sebagai Ustadz, Anda memiliki akses penuh untuk melakukan:</p>
                    <ul class="small opacity-90 ps-3 mb-4" style="line-height: 1.8; font-size: 13px;">
                        <li>Memvalidasi setoran hafalan santri harian.</li>
                        <li>Mengoreksi jurnal kegiatan ibadah santri.</li>
                        <li>Memberikan catatan perkembangan tilawah Al-Qur'an.</li>
                    </ul>
                    <div class="p-3 rounded-3 mt-auto" style="background: rgba(255,255,255,0.07);">
                        <small class="d-block text-warning fw-bold mb-1" style="font-size: 11px;">💡 Catatan Proyek:</small>
                        <small class="opacity-75" style="font-size: 12px;">Gunakan akun ber-nama depan Ustadz untuk mendemokan fitur pemeriksaan di hadapan dosen penguji.</small>
                    </div>
                </div>
            @else
                <div class="custom-card text-dark" style="min-height: 340px; display: flex; flex-direction: column;">
                    <h5 class="fw-bold mb-1" style="color: #198754; font-size: 18px;">🎯 Target Hafalan</h5>
                    <p class="text-muted small mb-4" style="font-size: 13px;">Pantau ringkasan kegiatan mengaji kamu.</p>
                    
                    <div class="p-3 mb-3 bg-light rounded-3 border-start border-4 border-success">
                        <small class="text-muted d-block fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">PROGRES SHALAT HARI INI</small>
                        <span class="fw-bold text-dark" style="font-size: 18px;">60% Selesai</span>
                    </div>

                    <div class="p-3 bg-light rounded-3 border-start border-4 border-warning">
                        <small class="text-muted d-block fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">STATUS SETORAN</small>
                        <span class="fw-bold text-dark" style="font-size: 15px;">Aktif Terdata 🚀</span>
                    </div>

                    <div class="mt-auto pt-3 text-center">
                        <p class="fst-italic text-muted small mb-0" style="font-size: 12.5px; line-height: 1.5;">"Semangat terus ngajinya ya, jangan lupa setor hafalanmu hari ini!"</p>
                    </div>
                </div>
            @endif
        </div>

    </div>

</div>

</body>
</html>
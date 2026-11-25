<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIBEKA - Sistem Informasi Beasiswa Mahasiswa</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&family=jetbrains-mono:500,600,700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --navy: #0b1b3d;
            --navy-deep: #07122b;
            --blue: #1d4ed8;
            --blue-hover: #1e40af;
            --gold: #eab308;
            --ink: #0f172a;
            --muted: #475569;
            --subtle: #64748b;
            --surface: #f5f7fb;
            --border: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #ffffff;
            color: var(--ink);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .mono {
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-variant-numeric: tabular-nums;
        }

        /* NAVBAR PUTIH BERSIH */
        .navbar {
            width: 100%;
            min-height: 82px;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 12px 32px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar-container {
            width: 100%;
            max-width: 1220px;
            margin: 0 auto;
            display: flex;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-title {
            color: var(--navy-deep);
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .brand-subtitle {
            color: var(--subtle);
            font-size: 12px;
            font-weight: 500;
            margin-top: 1px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-left: auto;
        }

        .nav-link {
            color: var(--muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 9px 15px;
            border-radius: 9px;
            transition: color 0.18s ease, background-color 0.18s ease;
        }

        .nav-link:hover {
            color: var(--navy);
            background: #f1f5f9;
        }

        .nav-link.active {
            background: #eff6ff;
            color: var(--blue);
        }

        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 22px;
        }

        .login-button {
            background: var(--blue);
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            padding: 10px 22px;
            border-radius: 9px;
            font-weight: 600;
            transition: background-color 0.18s ease;
            display: inline-block;
        }

        .login-button:hover {
            background: var(--blue-hover);
        }

        .register-button {
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            color: var(--ink);
            text-decoration: none;
            font-size: 14px;
            padding: 9px 20px;
            border-radius: 9px;
            font-weight: 600;
            transition: all 0.18s ease;
            display: inline-block;
        }

        .register-button:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }

        /* HERO */
        .hero {
            position: relative;
            min-height: 540px;
            background:
                linear-gradient(100deg, rgba(7, 18, 43, 0.92) 0%, rgba(11, 27, 61, 0.80) 52%, rgba(15, 36, 82, 0.44) 100%),
                url("{{ asset('images/logo%20polmed.jpeg') }}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            padding: 72px 32px 116px;
        }

        .hero-content {
            width: 100%;
            max-width: 1220px;
            margin: 0 auto;
        }

        .hero-eyebrow {
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.04em;
            color: #fde68a;
            margin-bottom: 16px;
            padding-left: 12px;
            border-left: 3px solid var(--gold);
        }

        .hero-title {
            max-width: 720px;
            color: #ffffff;
            font-size: 46px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.025em;
            margin-bottom: 18px;
        }

        .hero-title span {
            color: #93c5fd;
        }

        .hero-description {
            max-width: 600px;
            color: #dbeafe;
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 34px;
            font-weight: 400;
        }

        /* TOMBOL AKSI HERO */
        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 14px;
        }

        .hero-btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 26px;
            border-radius: 10px;
            background: var(--blue);
            color: #ffffff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            box-shadow: 0 10px 24px rgba(29, 78, 216, 0.35);
            transition: background-color 0.18s ease, transform 0.18s ease;
        }

        .hero-btn-primary:hover {
            background: var(--blue-hover);
            transform: translateY(-1px);
        }

        .hero-btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 24px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.10);
            border: 1.5px solid rgba(255, 255, 255, 0.30);
            color: #ffffff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            backdrop-filter: blur(6px);
            transition: background-color 0.18s ease, border-color 0.18s ease;
        }

        .hero-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.55);
        }

        /* STRIP STATISTIK OVERLAP ELEGAN */
        .stats-wrapper {
            max-width: 1220px;
            margin: -56px auto 0;
            padding: 0 32px;
            position: relative;
            z-index: 10;
        }

        .statistics-strip {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 14px 36px rgba(15, 23, 42, 0.07);
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            overflow: hidden;
        }

        .stat-item {
            padding: 28px 30px;
            position: relative;
        }

        .stat-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 24px;
            bottom: 24px;
            width: 1px;
            background: var(--border);
        }

        .stat-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--subtle);
            margin-bottom: 6px;
        }

        .stat-number {
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: 30px;
            font-weight: 700;
            color: var(--navy);
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin-bottom: 8px;
        }

        .stat-description {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.55;
        }

        /* SECTION ALUR SELEKSI */
        .scholarship-section {
            background: #ffffff;
            padding: 76px 32px 84px;
        }

        .scholarship-container {
            max-width: 1220px;
            margin: 0 auto;
        }

        .section-head {
            max-width: 640px;
            margin-bottom: 40px;
        }

        .section-kicker {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--blue);
            margin-bottom: 8px;
            display: inline-block;
        }

        .section-title {
            font-size: 30px;
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -0.02em;
            line-height: 1.25;
            margin-bottom: 10px;
        }

        .section-subtitle {
            font-size: 15px;
            color: var(--muted);
            line-height: 1.65;
        }

        .selection-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 18px;
        }

        .selection-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .selection-card:hover {
            transform: translateY(-3px);
            border-color: #bfdbfe;
            box-shadow: 0 12px 26px rgba(29, 78, 216, 0.07);
        }

        .selection-number {
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: 13px;
            font-weight: 700;
            color: var(--blue);
            background: #eff6ff;
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
        }

        .selection-card h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 8px;
            line-height: 1.35;
        }

        .selection-card p {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .selection-link {
            font-size: 13px;
            font-weight: 600;
            color: var(--blue);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: gap 0.18s ease;
        }

        .selection-link:hover {
            gap: 8px;
        }

        /* KOMPONEN, SYARAT & JADWAL */
        .information-section {
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 80px 32px;
        }

        .information-container {
            max-width: 1220px;
            margin: 0 auto;
        }

        .information-grid {
            display: grid;
            grid-template-columns: 1.25fr 0.95fr;
            gap: 36px;
            align-items: start;
        }

        .benefit-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            margin-bottom: 22px;
        }

        .benefit-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-top: 3px solid var(--blue);
            border-radius: 14px;
            padding: 24px;
        }

        .benefit-card h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 8px;
        }

        .benefit-card p {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.65;
        }

        .requirement-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 26px 28px;
        }

        .requirement-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 16px;
        }

        .requirement-list {
            list-style: none;
            display: grid;
            gap: 12px;
        }

        .requirement-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 14px;
            color: var(--muted);
            line-height: 1.6;
        }

        .requirement-number {
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            width: 24px;
            height: 24px;
            border-radius: 6px;
            background: #eff6ff;
            color: var(--blue);
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* AGENDA TIMELINE */
        .agenda-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 30px;
        }

        .agenda-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -0.015em;
            margin-top: 6px;
            margin-bottom: 6px;
        }

        .agenda-description {
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 24px;
        }

        .agenda-timeline {
            position: relative;
            padding-left: 22px;
            border-left: 2px solid #e2e8f0;
            display: grid;
            gap: 20px;
        }

        .agenda-item {
            position: relative;
        }

        .agenda-item::before {
            content: '';
            position: absolute;
            left: -28px;
            top: 5px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--blue);
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 2px #bfdbfe;
        }

        .agenda-date {
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--blue);
            margin-bottom: 3px;
        }

        .agenda-content h4 {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 3px;
        }

        .agenda-content p {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.55;
        }

        .agenda-warning {
            margin-top: 24px;
            padding: 13px 16px;
            border-radius: 10px;
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #92400e;
            font-size: 12.5px;
            line-height: 1.55;
        }

        /* FOOTER */
        .footer {
            background: var(--navy-deep);
            color: #cbd5e1;
            padding: 64px 32px 32px;
        }

        .footer-container {
            max-width: 1220px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 48px;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }

        .footer-logo {
            width: 58px;
            height: 58px;
            object-fit: contain;
            background: #ffffff;
            border-radius: 12px;
            padding: 4px;
        }

        .footer-brand h3 {
            color: #ffffff;
            font-size: 17px;
            font-weight: 800;
        }

        .footer-brand p {
            color: #94a3b8;
            font-size: 12.5px;
            margin-top: 2px;
        }

        .footer-description {
            font-size: 14px;
            line-height: 1.7;
            color: #94a3b8;
            margin-bottom: 14px;
            max-width: 420px;
        }

        .footer-address {
            font-size: 13px;
            color: #cbd5e1;
        }

        .footer-column h4 {
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.04em;
            margin-bottom: 16px;
        }

        .footer-links {
            list-style: none;
            display: grid;
            gap: 10px;
        }

        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.18s ease;
        }

        .footer-links a:hover {
            color: #ffffff;
        }

        .footer-bottom {
            padding-top: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-copyright {
            font-size: 13px;
            color: #94a3b8;
        }

        .footer-bottom-links {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
        }

        .footer-bottom-links a {
            color: #94a3b8;
            text-decoration: none;
        }

        .footer-bottom-links a:hover {
            color: #ffffff;
        }

        /* RESPONSIVE */
        @media (max-width: 1080px) {
            .selection-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .information-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 860px) {
            .navbar {
                padding: 12px 20px;
            }

            .navbar-container {
                flex-wrap: wrap;
                gap: 12px;
            }

            .nav-menu {
                order: 3;
                width: 100%;
                margin-left: 0;
                justify-content: flex-start;
                overflow-x: auto;
                padding-top: 8px;
                border-top: 1px solid var(--border);
            }

            .auth-buttons {
                margin-left: auto;
            }

            .hero {
                min-height: 440px;
                padding: 56px 20px 92px;
            }

            .hero-title {
                font-size: 32px;
            }

            .hero-description {
                font-size: 14.5px;
            }

            .hero-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .hero-btn-primary,
            .hero-btn-secondary {
                width: 100%;
            }

            .stats-wrapper {
                padding: 0 20px;
                margin-top: -42px;
            }

            .statistics-strip {
                grid-template-columns: 1fr;
            }

            .stat-item:not(:last-child)::after {
                top: auto;
                bottom: 0;
                left: 24px;
                right: 24px;
                width: auto;
                height: 1px;
            }

            .scholarship-section,
            .information-section,
            .footer {
                padding-left: 20px;
                padding-right: 20px;
            }

            .selection-grid,
            .benefit-grid,
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    @include('layouts.partials.welcome-navbar')

    <!-- HERO -->
    <section class="hero" id="status-seleksi">
        <div class="hero-content">

            <div class="hero-eyebrow">Portal Resmi Seleksi Beasiswa Mahasiswa</div>

            <h1 class="hero-title">
                Wujudkan Mimpi Kuliah
                <br>
                Bersama <span>Beasiswa SIBEKA</span>
            </h1>

            <p class="hero-description">
                Program bantuan pembiayaan pendidikan dan apresiasi prestasi
                bagi mahasiswa aktif untuk menempuh pendidikan tinggi secara
                unggul dan berdaya saing.
            </p>

            <!-- TOMBOL AKSI UTAMA (LOGIS & AMAN SESUAI 2FA) -->
            <div class="hero-actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="hero-btn-primary">
                        <span>Buka Dashboard</span>
                        <span>→</span>
                    </a>
                    <a href="#alur-seleksi" class="hero-btn-secondary">
                        Lihat Alur Seleksi
                    </a>
                @else
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hero-btn-primary">
                            <span>Daftar Beasiswa</span>
                            <span>→</span>
                        </a>
                    @endif
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="hero-btn-secondary">
                            Masuk &amp; Cek Status
                        </a>
                    @endif
                @endauth
            </div>

        </div>
    </section>

    <!-- STRIP STATISTIK RINGKAS -->
    <div class="stats-wrapper">
        <div class="statistics-strip">
            <div class="stat-item">
                <div class="stat-label">Pembebasan Biaya UKT</div>
                <div class="stat-number">100%</div>
                <p class="stat-description">
                    Bagi mahasiswa penerima aktif hingga masa studi selesai tepat waktu.
                </p>
            </div>

            <div class="stat-item">
                <div class="stat-label">Bantuan Biaya Hidup / Semester</div>
                <div class="stat-number">Rp 5.000.000</div>
                <p class="stat-description">
                    Tunjangan prestasi dan pengembangan akademik disalurkan per semester.
                </p>
            </div>

            <div class="stat-item">
                <div class="stat-label">Penerima Aktif Tahun Ini</div>
                <div class="stat-number">{{ $penerimaAktif ?? 0 }}</div>
                <p class="stat-description">
                    Total mahasiswa aktif yang menerima pembiayaan beasiswa tahun ini.
                </p>
            </div>
        </div>
    </div>

    <!-- ALUR SELEKSI -->
    <section class="scholarship-section" id="alur-seleksi">
        <div class="scholarship-container">

            <div class="section-head">
                <span class="section-kicker">Panduan Pendaftaran</span>
                <h2 class="section-title">Alur Seleksi Beasiswa</h2>
                <p class="section-subtitle">
                    Calon penerima beasiswa mengikuti 5 tahapan seleksi resmi berikut secara berurutan.
                </p>
            </div>

            <div class="selection-grid">

                <div class="selection-card">
                    <div>
                        <div class="selection-number">01</div>
                        <h3>Registrasi Akun</h3>
                        <p>
                            Buat akun calon pendaftar melalui portal resmi SIBEKA menggunakan NIM dan email aktif.
                        </p>
                    </div>
                    <a href="{{ Route::has('register') ? route('register') : '#alur-seleksi' }}" class="selection-link">
                        Daftar Akun →
                    </a>
                </div>

                <div class="selection-card">
                    <div>
                        <div class="selection-number">02</div>
                        <h3>Pemberkasan</h3>
                        <p>
                            Lengkapi formulir data akademik, kondisi ekonomi, dan unggah dokumen persyaratan.
                        </p>
                    </div>
                    <a href="#persyaratan" class="selection-link">Lihat Syarat →</a>
                </div>

                <div class="selection-card">
                    <div>
                        <div class="selection-number">03</div>
                        <h3>Seleksi Berkas</h3>
                        <p>
                            Verifikasi administratif dan pemeriksaan keabsahan dokumen oleh tim verifikator.
                        </p>
                    </div>
                    <a href="#status-seleksi" class="selection-link">Cek Status →</a>
                </div>

                <div class="selection-card">
                    <div>
                        <div class="selection-number">04</div>
                        <h3>Wawancara</h3>
                        <p>
                            Asesmen kelayakan, verifikasi faktual, dan wawancara bersama tim seleksi beasiswa.
                        </p>
                    </div>
                    <a href="#persyaratan" class="selection-link">Lihat Jadwal →</a>
                </div>

                <div class="selection-card">
                    <div>
                        <div class="selection-number">05</div>
                        <h3>Pengumuman Hasil</h3>
                        <p>
                            Penetapan kelulusan dan publikasi SK penetapan penerima beasiswa secara terbuka.
                        </p>
                    </div>
                    <a href="#status-seleksi" class="selection-link">Cek Kelulusan →</a>
                </div>

            </div>
        </div>
    </section>

    <!-- KOMPONEN BEASISWA, SYARAT & JADWAL -->
    <section class="information-section" id="persyaratan">
        <div class="information-container">

            <div class="information-grid">

                <div>
                    <div class="section-head" style="margin-bottom: 24px;">
                        <span class="section-kicker">Cakupan &amp; Ketentuan</span>
                        <h2 class="section-title">Komponen Beasiswa</h2>
                        <p class="section-subtitle">
                            Fasilitas pembiayaan pendidikan yang diberikan kepada penerima beasiswa aktif hingga lulus tepat waktu.
                        </p>
                    </div>

                    <div class="benefit-grid">
                        <div class="benefit-card">
                            <h3>Biaya Pendidikan (UKT/SPP)</h3>
                            <p>
                                Pembebasan biaya pendidikan 100% per semester bagi mahasiswa penerima beasiswa aktif.
                            </p>
                        </div>

                        <div class="benefit-card">
                            <h3>Tunjangan Biaya Hidup</h3>
                            <p>
                                Subsidi biaya hidup per semester yang disalurkan langsung ke rekening bank aktif mahasiswa penerima.
                            </p>
                        </div>
                    </div>

                    <div class="requirement-card">
                        <h3 class="requirement-title">Syarat Utama Penerima Beasiswa</h3>

                        <ul class="requirement-list">
                            <li>
                                <span class="requirement-number">1</span>
                                <span>Mahasiswa aktif yang terdaftar pada pangkalan data pendidikan tinggi.</span>
                            </li>
                            <li>
                                <span class="requirement-number">2</span>
                                <span>Memiliki Indeks Prestasi Kumulatif (IPK) minimal <strong class="mono">3.50</strong> pada semester berjalan.</span>
                            </li>
                            <li>
                                <span class="requirement-number">3</span>
                                <span>Berkelakuan baik, berintegritas, serta tidak sedang menerima beasiswa lain.</span>
                            </li>
                            <li>
                                <span class="requirement-number">4</span>
                                <span>Lolos seluruh rangkaian verifikasi berkas administrasi dan tahap wawancara.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- JADWAL TIMELINE -->
                <div class="agenda-card">
                    <span class="section-kicker">Agenda Resmi</span>
                    <h2 class="agenda-title">Jadwal Seleksi {{ date('Y') }}</h2>
                    <p class="agenda-description">
                        Perhatikan setiap batas waktu tahapan pendaftaran berikut.
                    </p>

                    <div class="agenda-timeline">
                        <div class="agenda-item">
                            <div class="agenda-date">FEB – MAR {{ date('Y') }}</div>
                            <div class="agenda-content">
                                <h4>Pendaftaran &amp; Unggah Berkas</h4>
                                <p>Registrasi akun, pengisian formulir, dan unggah dokumen melalui portal SIBEKA.</p>
                            </div>
                        </div>

                        <div class="agenda-item">
                            <div class="agenda-date">MAR – APR {{ date('Y') }}</div>
                            <div class="agenda-content">
                                <h4>Seleksi Administrasi &amp; Verifikasi</h4>
                                <p>Pemeriksaan kelengkapan dan keabsahan dokumen oleh tim verifikator.</p>
                            </div>
                        </div>

                        <div class="agenda-item">
                            <div class="agenda-date">MEI – JUN {{ date('Y') }}</div>
                            <div class="agenda-content">
                                <h4>Pengumuman Seleksi Berkas</h4>
                                <p>Publikasi daftar peserta yang memenuhi syarat menuju tahap wawancara.</p>
                            </div>
                        </div>

                        <div class="agenda-item">
                            <div class="agenda-date">JUL {{ date('Y') }}</div>
                            <div class="agenda-content">
                                <h4>Wawancara &amp; Kelayakan</h4>
                                <p>Tahap wawancara komprehensif bersama dewan penguji beasiswa.</p>
                            </div>
                        </div>

                        <div class="agenda-item">
                            <div class="agenda-date">AGU {{ date('Y') }}</div>
                            <div class="agenda-content">
                                <h4>Pengumuman Akhir &amp; Penetapan</h4>
                                <p>Penetapan penerima resmi beasiswa dan publikasi hasil akhir.</p>
                            </div>
                        </div>
                    </div>

                    <div class="agenda-warning">
                        Jadwal dan ketentuan tahapan seleksi dapat disesuaikan dengan kalender akademik resmi.
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('layouts.partials.welcome-footer')

</body>

</html>

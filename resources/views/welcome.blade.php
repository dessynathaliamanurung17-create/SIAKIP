<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIBEKA POLMED - Sistem Informasi Beasiswa Politeknik Negeri Medan</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fff;
        }

        /* NAVBAR */
        .navbar {
            width: 100%;
            min-height: 100px;
            background: #07122f;
            display: flex;
            align-items: center;
            padding: 15px 32px;
        }

        .navbar-container {
            width: 100%;
            display: flex;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 330px;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: white;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-title {
            color: white;
            font-size: 17px;
            font-weight: 700;
        }

        .brand-subtitle {
            color: #9aa5bd;
            font-size: 12px;
            margin-top: 5px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
        }

        .nav-link {
            color: #d9deea;
            text-decoration: none;
            font-size: 14px;
            padding: 14px 20px;
            border-radius: 12px;
            transition: .2s;
        }

        .nav-link:hover {
            color: white;
        }

        .nav-link.active {
            background: white;
            color: #172033;
            font-weight: 600;
        }

        /* AUTH BUTTONS (LOGIN & REGISTER) */
        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 25px;
        }

        .login-button {
            background: #2563eb;
            color: white;
            text-decoration: none;
            font-size: 14px;
            padding: 13px 25px;
            border-radius: 11px;
            font-weight: 600;
            transition: .2s;
            display: inline-block;
        }

        .login-button:hover {
            background: #1d4ed8;
        }

        .register-button {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: white;
            text-decoration: none;
            font-size: 14px;
            padding: 12px 22px;
            border-radius: 11px;
            font-weight: 600;
            transition: .2s;
            display: inline-block;
        }

        .register-button:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* HERO */
        .hero {
            position: relative;
            min-height: 515px;
            background: linear-gradient(rgba(4, 15, 39, .70), rgba(4, 15, 39, .70)),
            url("{{ asset('build/assets/image/pesawat.jpg') }}");
            background-position: center;
            background-size: cover;
            display: flex;
            align-items: center;
        }

        .hero-content {
            width: 100%;
            max-width: 1400px;
            margin: auto;
            padding: 55px 45px;
        }

        .hero-title {
            max-width: 850px;
            color: white;
            font-size: 54px;
            font-weight: 800;
            line-height: 1.05;
            margin-bottom: 25px;
        }

        .hero-title span {
            color: #25d9f5;
        }

        .hero-description {
            max-width: 850px;
            color: #e2e8f0;
            font-size: 18px;
            line-height: 1.7;
            margin-bottom: 40px;
        }

        .hero-search {
            width: 740px;
            max-width: 100%;
            height: 70px;
            background: #071633;
            border-radius: 15px;
            display: flex;
            align-items: center;
            padding: 6px;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .hero-search-input {
            flex: 1;
            height: 100%;
            border: none;
            outline: none;
            background: transparent;
            color: white;
            padding: 0 20px;
            font-size: 15px;
        }

        .hero-search-input::placeholder {
            color: #8d9ab2;
        }

        .hero-search-button {
            height: 56px;
            padding: 0 25px;
            border: none;
            border-radius: 12px;
            background: #2563eb;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
        }

        .hero-search-button:hover {
            background: #1d4ed8;
        }

        .search-feedback {
            margin-top: 15px;
            max-width: 740px;
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 13px;
            line-height: 1.5;
            background: rgba(7, 22, 51, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* STATISTIK DAN ALUR SELEKSI */
        .scholarship-section {
            background: #f8fafc;
            padding: 35px 32px 55px;
        }

        .scholarship-container {
            max-width: 1400px;
            margin: auto;
        }

        .statistics-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 45px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 12px rgba(0, 0, 0, .07);
            min-height: 120px;
            border: 1px solid #edf0f5;
        }

        .stat-icon {
            width: 32px;
            height: 32px;
            border-radius: 7px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 9px;
            font-weight: bold;
        }

        .stat-number {
            font-size: 21px;
            font-weight: 800;
            color: #172033;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 6px;
        }

        .stat-description {
            font-size: 10px;
            line-height: 1.5;
            color: #8490a3;
        }

        .selection-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .selection-badge,
        .information-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #dbeafe;
            font-size: 9px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .selection-title {
            font-size: 25px;
            font-weight: 800;
            color: #172033;
            margin-bottom: 8px;
        }

        .selection-description {
            font-size: 12px;
            color: #8490a3;
            line-height: 1.6;
        }

        .selection-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }

        .selection-card {
            background: white;
            border: 1px solid #e8edf4;
            border-radius: 11px;
            padding: 17px 14px;
            min-height: 180px;
            transition: .2s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .selection-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 7px 18px rgba(0, 0, 0, .07);
        }

        .selection-number {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            margin-bottom: 13px;
        }

        .selection-card h3 {
            font-size: 12px;
            color: #172033;
            margin-bottom: 9px;
        }

        .selection-card p {
            font-size: 10px;
            color: #8490a3;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .selection-link {
            display: block;
            border-top: 1px solid #f1f3f6;
            padding-top: 11px;
            color: #2563eb;
            font-size: 10px;
            text-decoration: none;
            font-weight: 600;
        }

        /* KOMPONEN BEASISWA */
        .information-section {
            background: white;
            padding: 45px 32px 55px;
        }

        .information-container {
            max-width: 1400px;
            margin: auto;
        }

        .information-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 35px;
            align-items: start;
        }

        .information-heading {
            font-size: 24px;
            color: #172033;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .information-subtitle {
            color: #8490a3;
            font-size: 11px;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .benefit-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .benefit-card {
            background: #f8fafc;
            border: 1px solid #e8edf4;
            border-radius: 10px;
            padding: 17px;
        }

        .benefit-icon {
            width: 28px;
            height: 28px;
            background: #d1fae5;
            color: #059669;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .benefit-card:nth-child(2) .benefit-icon {
            background: #dbeafe;
            color: #2563eb;
        }

        .benefit-card h3 {
            color: #172033;
            font-size: 12px;
            margin-bottom: 7px;
        }

        .benefit-card p {
            color: #8490a3;
            font-size: 10px;
            line-height: 1.6;
        }

        .requirement-card {
            margin-top: 14px;
            padding: 17px;
            background: #f8fafc;
            border: 1px solid #dbeafe;
            border-radius: 10px;
        }

        .requirement-title {
            color: #2563eb;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 13px;
        }

        .requirement-list {
            list-style: none;
        }

        .requirement-list li {
            display: flex;
            gap: 9px;
            color: #64748b;
            font-size: 10px;
            line-height: 1.6;
            margin-bottom: 7px;
        }

        .requirement-number {
            flex-shrink: 0;
            width: 17px;
            height: 17px;
            border-radius: 50%;
            background: #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: 700;
        }

        /* AGENDA */
        .agenda-card {
            background: white;
            border: 1px solid #e8edf4;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 7px 18px rgba(0, 0, 0, .07);
        }

        .agenda-title {
            font-size: 18px;
            color: #172033;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .agenda-description {
            color: #8490a3;
            font-size: 10px;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .agenda-item {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding: 12px 10px;
            background: #f8fafc;
            border: 1px solid #edf0f5;
            border-radius: 9px;
            margin-bottom: 9px;
        }

        .agenda-date {
            min-width: 77px;
            text-align: center;
            padding: 7px 4px;
            border-radius: 6px;
            background: #dbeafe;
            color: #2563eb;
            font-size: 8px;
            font-weight: 700;
        }

        .agenda-item:nth-child(3) .agenda-date {
            background: #f3e8ff;
            color: #9333ea;
        }

        .agenda-item:nth-child(4) .agenda-date {
            background: #cffafe;
            color: #0891b2;
        }

        .agenda-item:nth-child(5) .agenda-date {
            background: #fef3c7;
            color: #b45309;
        }

        .agenda-item:nth-child(6) .agenda-date {
            background: #d1fae5;
            color: #059669;
        }

        .agenda-content h4 {
            color: #172033;
            font-size: 10px;
            margin-bottom: 4px;
        }

        .agenda-content p {
            color: #8490a3;
            font-size: 9px;
            line-height: 1.5;
        }

        .agenda-warning {
            margin-top: 12px;
            padding: 12px;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 9px;
            color: #b45309;
            font-size: 9px;
            line-height: 1.6;
        }

        /* SAMBUTAN DIREKTUR */
        .leader-section {
            background: #f8fafc;
            padding: 55px 32px;
        }

        .leader-container {
            max-width: 1400px;
            margin: auto;
            display: grid;
            grid-template-columns: 35% 65%;
            align-items: center;
            gap: 35px;
        }

        .leader-photo-area {
            text-align: center;
        }

        .leader-photo {
            width: 210px;
            height: 260px;
            object-fit: cover;
            object-position: center;
            border-radius: 12px;
            border: 2px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .12);
            background: #e2e8f0;
        }

        .leader-name {
            margin-top: 12px;
            color: #172033;
            font-size: 12px;
            font-weight: 700;
        }

        .leader-position {
            color: #8490a3;
            font-size: 10px;
            margin-top: 4px;
        }

        .leader-content {
            border-left: 1px solid #e2e8f0;
            padding-left: 30px;
        }

        .leader-title {
            color: #172033;
            font-size: 28px;
            line-height: 1.2;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .leader-title span {
            color: #2563eb;
        }

        .leader-description {
            color: #64748b;
            font-size: 11px;
            line-height: 1.8;
            margin-bottom: 12px;
        }

        /* FOOTER */
        .footer {
            background: #071321;
            color: #cbd5e1;
            padding: 42px 32px 25px;
        }

        .footer-container {
            max-width: 1400px;
            margin: auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr .9fr 1fr;
            gap: 55px;
            padding-bottom: 32px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 17px;
        }

        .footer-logo {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .footer-brand h3 {
            color: white;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .footer-brand p {
            color: #8490a3;
            font-size: 9px;
        }

        .footer-description {
            color: #9aa7ba;
            font-size: 10px;
            line-height: 1.8;
            max-width: 430px;
            margin-bottom: 12px;
        }

        .footer-address {
            color: #8490a3;
            font-size: 10px;
            line-height: 1.7;
        }

        .footer-column h4 {
            color: white;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .4px;
            margin-bottom: 15px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 9px;
        }

        .footer-links a {
            color: #aab5c5;
            font-size: 10px;
            text-decoration: none;
            transition: .2s;
        }

        .footer-links a:hover {
            color: #38bdf8;
        }

        .footer-bottom {
            border-top: 1px solid rgba(148, 163, 184, .15);
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .footer-copyright {
            color: #718096;
            font-size: 9px;
        }

        .footer-bottom-links {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .footer-bottom-links a {
            color: #8490a3;
            text-decoration: none;
            font-size: 9px;
        }

        .footer-bottom-links a:hover {
            color: white;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .navbar {
                height: auto;
                padding: 15px 20px;
            }

            .navbar-container {
                flex-wrap: wrap;
                gap: 15px;
            }

            .brand {
                min-width: auto;
            }

            .nav-menu {
                width: 100%;
                order: 3;
                justify-content: center;
                margin-left: 0;
            }

            .auth-buttons {
                margin-left: auto;
            }

            .selection-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .information-grid {
                grid-template-columns: 1fr;
            }

            .leader-container {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .leader-content {
                border-left: none;
                padding-left: 0;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 30px 20px;
            }

            .footer-brand-area {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 14px 16px;
            }

            .brand-logo {
                width: 40px;
                height: 40px;
            }

            .brand-subtitle {
                display: none;
            }

            .nav-menu {
                overflow-x: auto;
                justify-content: flex-start;
            }

            .nav-link {
                font-size: 11px;
                padding: 9px 12px;
                white-space: nowrap;
            }

            .auth-buttons {
                gap: 6px;
            }

            .login-button,
            .register-button {
                font-size: 11px;
                padding: 8px 12px;
            }

            .hero {
                min-height: 420px;
            }

            .hero-content {
                padding: 45px 20px;
            }

            .hero-title {
                font-size: 30px;
            }

            .hero-description {
                font-size: 13px;
            }

            .hero-search {
                height: auto;
                flex-direction: column;
                gap: 6px;
                padding: 6px;
            }

            .hero-search-input {
                width: 100%;
                height: 42px;
            }

            .hero-search-button {
                width: 100%;
            }

            .scholarship-section,
            .information-section,
            .leader-section {
                padding: 35px 16px;
            }

            .statistics-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .selection-title {
                font-size: 20px;
            }

            .selection-grid {
                grid-template-columns: 1fr;
            }

            .selection-card {
                min-height: auto;
            }

            .selection-card p {
                min-height: auto;
            }

            .benefit-grid {
                grid-template-columns: 1fr;
            }

            .information-heading {
                font-size: 20px;
            }

            .agenda-card {
                padding: 14px;
            }

            .leader-photo {
                width: 190px;
                height: 240px;
            }

            .leader-title {
                font-size: 22px;
            }

            .footer {
                padding: 35px 20px 22px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .footer-brand-area {
                grid-column: auto;
            }

            .footer-bottom {
                flex-direction: column;
                align-items: flex-start;
            }

            .footer-bottom-links {
                flex-wrap: wrap;
                gap: 10px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-container">

            <div class="brand">
                <div class="brand-logo">
                    <img src="{{ asset('build/assets/image/logo sibeka.png') }}"
                        alt="Logo SIBEKA POLMED"
                        onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=POLMED&background=07122f&color=fff';">
                </div>

                <div>
                    <div class="brand-title">SIBEKA POLMED</div>
                    <div class="brand-subtitle">
                        Portal Beasiswa Resmi Politeknik Negeri Medan
                    </div>
                </div>
            </div>

            <div class="nav-menu">
                <a href="{{ url('/') }}" class="nav-link active">Beranda</a>
                <a href="#pendaftaran" class="nav-link">Pendaftaran</a>
                <a href="#dokumen" class="nav-link">Dokumen</a>
                <a href="#status-seleksi" class="nav-link">Status Seleksi</a>
            </div>

            <!-- MENU AUTH (LOGIN & REGISTER) -->
            @if (Route::has('login'))
                <div class="auth-buttons">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="login-button">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="login-button">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="register-button">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

        </div>
    </nav>


    <!-- HERO -->
    <section class="hero" id="status-seleksi">
        <div class="hero-content">

            <h1 class="hero-title">
                Wujudkan Mimpi Kuliah Vokasi
                <br>
                Bersama <span>Beasiswa POLMED</span>
            </h1>

            <p class="hero-description">
                Program bantuan pembiayaan pendidikan dan apresiasi prestasi
                bagi mahasiswa aktif Politeknik Negeri Medan untuk menempuh
                jenjang Diploma dan Sarjana Terapan secara unggul dan berdaya saing.
            </p>

            <!-- FORM CEK STATUS SELEKSI BEASISWA -->
            <form action="{{ url('/') }}" method="GET" class="hero-search">
                <input type="text"
                    name="keyword_pencarian"
                    class="hero-search-input"
                    value="{{ request('keyword_pencarian') }}"
                    placeholder="Masukkan Nomor Registrasi Beasiswa / NIM Mahasiswa"
                    required>

                <button type="submit" class="hero-search-button">
                    Cek Status Seleksi →
                </button>
            </form>

            <!-- HASIL PENCARIAN RIIL DARI DATABASE -->
            @if(request('keyword_pencarian'))
                <div class="search-feedback">
                    @if(isset($hasilPencarian) && $hasilPencarian)
                        <div style="color: #4ade80; font-weight: bold; margin-bottom: 4px;">✓ Data Beasiswa Ditemukan</div>
                        <div><strong>Nama:</strong> {{ $hasilPencarian->nama_lengkap }}</div>
                        <div><strong>NIM:</strong> {{ $hasilPencarian->nim ?? '-' }}</div>
                        <div><strong>Status Seleksi:</strong> <span style="color: #facc15; font-weight: bold; text-transform: uppercase;">{{ $hasilPencarian->status_seleksi }}</span></div>
                    @else
                        <div style="color: #f87171; font-weight: bold; margin-bottom: 4px;">✕ Data Tidak Ditemukan</div>
                        <div>Nomor <strong>{{ request('keyword_pencarian') }}</strong> belum terdaftar dalam sistem seleksi beasiswa.</div>
                    @endif
                </div>
            @endif

        </div>
    </section>


    <!-- STATISTIK DAN ALUR SELEKSI -->
    <section class="scholarship-section" id="pendaftaran">
        <div class="scholarship-container">

            <div class="statistics-grid">

                <div class="stat-card">
                    <div class="stat-icon">✓</div>
                    <div class="stat-number">100%</div>
                    <div class="stat-label">PEMBEBASAN BIAYA UKT</div>
                    <p class="stat-description">
                        Bagi seluruh mahasiswa penerima aktif berprestasi
                        hingga masa studi selesai tepat waktu.
                    </p>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">$</div>
                    <div class="stat-number">Rp 5.000.000</div>
                    <div class="stat-label">BIAYA HIDUP / SEMESTER</div>
                    <p class="stat-description">
                        Dana tunjangan prestasi dan pengembangan akademik
                        yang disalurkan langsung per semester.
                    </p>
                </div>

                <!-- DATA RIIL PENERIMA AKTIF (OTOMATIS 0 JIKA BELUM ADA DATA) -->
                <div class="stat-card">
                    <div class="stat-icon">♙</div>
                    <div class="stat-number">{{ $penerimaAktif ?? 0 }}</div>
                    <div class="stat-label">PENERIMA AKTIF TAHUN INI</div>
                    <p class="stat-description">
                        Total mahasiswa aktif yang menerima pembiayaan
                        Beasiswa resmi POLMED tahun ini.
                    </p>
                </div>

            </div>

            <div class="selection-header">
                <span class="selection-badge">PANDUAN PENDAFTARAN</span>
                <h2 class="selection-title">Alur Seleksi Beasiswa POLMED</h2>
                <p class="selection-description">
                    Ikuti 5 tahapan alur seleksi Beasiswa resmi
                    Politeknik Negeri Medan berikut secara berurutan:
                </p>
            </div>

            <div class="selection-grid">

                <div class="selection-card">
                    <div>
                        <div class="selection-number">01</div>
                        <h3>Registrasi Akun</h3>
                        <p>
                            Pembuatan akun calon pendaftar beasiswa melalui
                            sistem portal resmi SIBEKA POLMED.
                        </p>
                    </div>
                    <a href="{{ Route::has('register') ? route('register') : '#pendaftaran' }}" class="selection-link">
                        Daftar Akun →
                    </a>
                </div>

                <div class="selection-card">
                    <div>
                        <div class="selection-number">02</div>
                        <h3>Pemberkasan</h3>
                        <p>
                            Pengunggahan dokumen kelengkapan berkas akademik,
                            sertifikat prestasi, dan data pendukung.
                        </p>
                    </div>
                    <a href="#dokumen" class="selection-link">Unggah Berkas →</a>
                </div>

                <div class="selection-card">
                    <div>
                        <div class="selection-number">03</div>
                        <h3>Seleksi Berkas</h3>
                        <p>
                            Verifikasi administratif, validasi keabsahan dokumen,
                            dan penilaian kelayakan oleh tim seleksi beasiswa.
                        </p>
                    </div>
                    <a href="#status-seleksi" class="selection-link">Status Berkas →</a>
                </div>

                <div class="selection-card">
                    <div>
                        <div class="selection-number">04</div>
                        <h3>Wawancara</h3>
                        <p>
                            Tahap wawancara komprehensif, uji kompetensi vokasi,
                            dan asesmen komitmen calon penerima beasiswa.
                        </p>
                    </div>
                    <a href="#status-seleksi" class="selection-link">Jadwal Wawancara →</a>
                </div>

                <div class="selection-card">
                    <div>
                        <div class="selection-number">05</div>
                        <h3>Pengumuman Hasil Seleksi</h3>
                        <p>
                            Pengumuman resmi penetapan kelulusan dan publikasi
                            SK Direktur Beasiswa POLMED.
                        </p>
                    </div>
                    <a href="#status-seleksi" class="selection-link">SK Direktur POLMED →</a>
                </div>

            </div>
        </div>
    </section>


    <!-- KOMPONEN BEASISWA DAN AGENDA -->
    <section class="information-section" id="dokumen">
        <div class="information-container">

            <div class="information-grid">

                <div class="benefit-area">

                    <span class="information-badge">
                        BANTUAN & CAKUPAN BEASISWA
                    </span>

                    <h2 class="information-heading">
                        Komponen Beasiswa POLMED
                    </h2>

                    <p class="information-subtitle">
                        Penerima Beasiswa Politeknik Negeri Medan mendapatkan
                        fasilitas pembiayaan pendidikan terjamin hingga lulus tepat waktu:
                    </p>

                    <div class="benefit-grid">

                        <div class="benefit-card">
                            <div class="benefit-icon">▦</div>
                            <h3>Biaya Pendidikan (UKT/SPP)</h3>
                            <p>
                                Bebas biaya pendidikan 100% per semester yang
                                disalurkan langsung untuk jenjang D3 dan Sarjana
                                Terapan (D4) POLMED.
                            </p>
                        </div>

                        <div class="benefit-card">
                            <div class="benefit-icon">▣</div>
                            <h3>Tunjangan Biaya Hidup & Riset</h3>
                            <p>
                                Bantuan subsidi biaya hidup dan uang saku per semester
                                yang ditransfer langsung ke rekening bank aktif
                                mahasiswa penerima.
                            </p>
                        </div>

                    </div>

                    <div class="requirement-card">
                        <h3 class="requirement-title">
                            ◉ SYARAT UTAMA PENERIMA BEASISWA POLMED
                        </h3>

                        <ul class="requirement-list">
                            <li>
                                <span class="requirement-number">1</span>
                                Mahasiswa aktif Politeknik Negeri Medan (jenjang D3 atau Sarjana Terapan/D4).
                            </li>
                            <li>
                                <span class="requirement-number">2</span>
                                Memiliki Indeks Prestasi Kumulatif (IPK) minimal 3.50 pada semester berjalan.
                            </li>
                            <li>
                                <span class="requirement-number">3</span>
                                Berkelakuan baik, berintegritas, serta tidak sedang menerima beasiswa lain.
                            </li>
                            <li>
                                <span class="requirement-number">4</span>
                                Dinyatakan lolos seluruh rangkaian seleksi administrasi dan wawancara.
                            </li>
                        </ul>
                    </div>

                </div>


                <!-- AGENDA -->
                <div class="agenda-card">

                    <span class="information-badge">AGENDA RESMI</span>

                    <h2 class="agenda-title">
                        Jadwal Tahapan Seleksi ({{ date('Y') }})
                    </h2>

                    <p class="agenda-description">
                        Pastikan tidak melewati setiap agenda pendaftaran
                        dan seleksi beasiswa berikut:
                    </p>

                    <div class="agenda-item">
                        <div class="agenda-date">FEB - MAR {{ date('Y') }}</div>
                        <div class="agenda-content">
                            <h4>Pendaftaran & Unggah Berkas</h4>
                            <p>Pendaftaran online dan pengunggahan berkas melalui portal SIBEKA POLMED.</p>
                        </div>
                    </div>

                    <div class="agenda-item">
                        <div class="agenda-date">MAR - APR {{ date('Y') }}</div>
                        <div class="agenda-content">
                            <h4>Seleksi Administrasi & Verifikasi</h4>
                            <p>Pemeriksaan keabsahan dokumen akademik dan sertifikat prestasi mahasiswa.</p>
                        </div>
                    </div>

                    <div class="agenda-item">
                        <div class="agenda-date">MEI - JUNI {{ date('Y') }}</div>
                        <div class="agenda-content">
                            <h4>Pengumuman Hasil Seleksi Berkas</h4>
                            <p>Publikasi daftar peserta yang memenuhi syarat dan berhak ke tahap wawancara.</p>
                        </div>
                    </div>

                    <div class="agenda-item">
                        <div class="agenda-date">JULI {{ date('Y') }}</div>
                        <div class="agenda-content">
                            <h4>Uji Wawancara & Kelayakan</h4>
                            <p>Tahap wawancara komprehensif bersama dewan penguji beasiswa POLMED.</p>
                        </div>
                    </div>

                    <div class="agenda-item">
                        <div class="agenda-date">AGUSTUS {{ date('Y') }}</div>
                        <div class="agenda-content">
                            <h4>Pengumuman Akhir & SK Direktur</h4>
                            <p>Penetapan penerima resmi beasiswa dan penandatanganan komitmen beasiswa.</p>
                        </div>
                    </div>

                    <div class="agenda-warning">
                        ⚠ Jadwal dan ketentuan tahapan seleksi beasiswa dapat disesuaikan dengan kalender akademik resmi Politeknik Negeri Medan.
                    </div>

                </div>

            </div>
        </div>
    </section>


    <!-- SAMBUTAN PIMPINAN -->
    <section class="leader-section">
        <div class="leader-container">

            <div class="leader-photo-area">

                <img
                    src="{{ asset('build/assets/image/idham kamil.jpg') }}"
                    alt="Direktur Politeknik Negeri Medan"
                    class="leader-photo"
                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Idham+Kamil&background=07122f&color=fff&size=512';">

                <h3 class="leader-name">
                    Dr. Ir. Idham Kamil, S.T., M.T.
                </h3>

                <p class="leader-position">
                    Direktur Politeknik Negeri Medan
                </p>

            </div>

            <div class="leader-content">

                <span class="information-badge">SAMBUTAN PIMPINAN</span>

                <h2 class="leader-title">
                    Mendorong Generasi Berprestasi dan
                    Berdaya Saing Global Melalui
                    <span>Beasiswa POLMED</span>
                </h2>

                <p class="leader-description">
                    Politeknik Negeri Medan senantiasa berkomitmen untuk
                    mendukung mahasiswa berprestasi dan berdedikasi tinggi
                    agar terus berkembang menjadi lulusan vokasi yang unggul,
                    terampil, dan siap kerja.
                </p>

                <p class="leader-description">
                    Melalui program Beasiswa POLMED (SIBEKA), kami memberikan
                    ruang seluas-luasnya bagi mahasiswa aktif dengan IPK unggul
                    untuk meraih potensi terbaik mereka tanpa hambatan.
                </p>

                <p class="leader-description">
                    Kami meyakini bahwa apresiasi atas kerja keras akademik
                    akan membentuk insan vokasi yang berintegritas tinggi
                    serta berdaya saing di kancah nasional maupun internasional.
                </p>

            </div>
        </div>
    </section>


    <!-- FOOTER SIBEKA POLMED -->
    <footer class="footer">
        <div class="footer-container">

            <div class="footer-grid">

                <!-- IDENTITAS -->
                <div class="footer-brand-area">

                    <div class="footer-brand">

                        <img
                            src="{{ asset('build/assets/image/logo sibeka.png') }}"
                            alt="Logo SIBEKA POLMED"
                            class="footer-logo"
                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=P&background=2563eb&color=fff';">

                        <div>
                            <h3>SIBEKA POLMED</h3>
                            <p>
                                Sistem Informasi Beasiswa Politeknik Negeri Medan
                            </p>
                        </div>

                    </div>

                    <p class="footer-description">
                        Portal resmi seleksi dan pengelolaan Beasiswa Politeknik
                        Negeri Medan. Mewujudkan pendidikan tinggi vokasi yang
                        berdaya saing, berkeadilan, dan mendorong prestasi
                        gemilang anak bangsa.
                    </p>

                    <p class="footer-address">
                        Jl. Almamater No. 1, Kampus USU, Padang Bulan,
                        Kota Medan, Sumatera Utara 20155
                    </p>

                </div>


                <!-- TAUTAN RESMI -->
                <div class="footer-column">

                    <h4>TAUTAN RESMI</h4>

                    <ul class="footer-links">

                        <li>
                            <a href="https://www.polmed.ac.id/" target="_blank">
                                Website Resmi POLMED
                            </a>
                        </li>

                        <li>
                            <a href="https://siakad.polmed.ac.id/" target="_blank">
                                SIAKAD POLMED
                            </a>
                        </li>

                        <li>
                            <a href="#" target="_blank">
                                Panduan & Pedoman Beasiswa
                            </a>
                        </li>

                        <li>
                            <a href="#" target="_blank">
                                Pengumuman SK Direktur Beasiswa
                            </a>
                        </li>

                        <li>
                            <a href="https://www.kemdikbud.go.id/" target="_blank">
                                Kemendikbudristek
                            </a>
                        </li>

                    </ul>

                </div>


                <!-- LAYANAN DAN INFORMASI -->
                <div class="footer-column">

                    <h4>LAYANAN & INFORMASI</h4>

                    <ul class="footer-links">

                        <li>
                            <a href="#faq">Pusat Bantuan & FAQ Beasiswa</a>
                        </li>

                        <li>
                            <a href="#syarat">Syarat & Ketentuan Penerima</a>
                        </li>

                        <li>
                            <a href="#kontak">Kontak Helpdesk Beasiswa POLMED</a>
                        </li>

                        <li>
                            <a href="#status-seleksi">Pengumuman Kelulusan Seleksi</a>
                        </li>

                        <li>
                            <a href="#pengaduan">Layanan Bantuan & Pengaduan</a>
                        </li>

                    </ul>

                </div>

            </div>


            <!-- COPYRIGHT -->
            <div class="footer-bottom">

                <p class="footer-copyright">
                    © {{ date('Y') }} Politeknik Negeri Medan.
                    Hak Cipta Dilindungi Undang-Undang.
                </p>

                <div class="footer-bottom-links">

                    <a href="#kebijakan-privasi">
                        Kebijakan Privasi
                    </a>

                    <span style="color:#64748b;">•</span>

                    <a href="#syarat">
                        Syarat & Ketentuan
                    </a>

                </div>

            </div>

        </div>
    </footer>

</body>

</html>
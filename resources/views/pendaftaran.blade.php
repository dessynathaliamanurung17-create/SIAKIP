
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pendaftaran Beasiswa - SIBEKA POLMED</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f8fafc;
            color: #172033;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            width: 100%;
            height: 58px;
            background: #07122f;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            padding: 0 5%;
            justify-content: space-between;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand img {
            width: 27px;
            height: 27px;
            object-fit: contain;
        }

        .brand-name {
            color: #fff;
            font-size: 13px;
            font-weight: 700;
        }

        .brand-subtitle {
            color: #8592aa;
            font-size: 8px;
            margin-top: 3px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .nav-link {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 10px;
            padding: 10px 13px;
            border-radius: 10px;
            transition: .2s;
        }

        .nav-link:hover {
            color: white;
        }

        .nav-link.active {
            background: #fff;
            color: #07122f;
            font-weight: 700;
        }

        .nav-divider {
            height: 25px;
            width: 1px;
            background: rgba(255,255,255,.12);
            margin: 0 7px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 10px;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 9px;
            color: white;
            font-size: 10px;
        }

        .user-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: 700;
        }

        /* =========================
           HEADER PENDAFTARAN
        ========================= */

        .registration-header {
            background:
                radial-gradient(
                    circle at 90% 20%,
                    rgba(37,99,235,.22),
                    transparent 35%
                ),
                radial-gradient(
                    circle at 35% 100%,
                    rgba(13,148,136,.12),
                    transparent 40%
                ),
                #09172b;

            min-height: 210px;
            padding: 42px 5% 35px;
            color: white;
        }

        .header-container {
            max-width: 1250px;
            margin: auto;
        }

        .period-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(5,150,105,.18);
            color: #34d399;
            border: 1px solid rgba(16,185,129,.12);
            border-radius: 30px;
            padding: 5px 12px;
            font-size: 9px;
            font-weight: 700;
            margin-bottom: 17px;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #34d399;
        }

        .header-title {
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -.7px;
            margin-bottom: 7px;
        }

        .header-year {
            color: #cbd5e1;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .header-description {
            max-width: 530px;
            color: #aebbd0;
            font-size: 12px;
            line-height: 1.7;
        }

        /* =========================
           PROGRESS SECTION
        ========================= */

        .progress-section {
            background: #09172b;
            padding: 10px 5% 35px;
        }

        .progress-container {
            max-width: 700px;
            margin: auto;
            position: relative;
        }

        .progress-line {
            position: absolute;
            top: 14px;
            left: 5.5%;
            right: 5.5%;
            height: 3px;
            background: #26364c;
            z-index: 1;
        }

        .progress-line-active {
            position: absolute;
            top: 14px;
            left: 5.5%;
            width: 33%;
            height: 3px;
            background: #2563eb;
            z-index: 2;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(4,1fr);
            position: relative;
            z-index: 3;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .step-circle {
            width: 29px;
            height: 29px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #17263d;
            border: 1px solid #304158;
            color: #94a3b8;
            font-size: 10px;
            margin-bottom: 9px;
        }

        .step.completed .step-circle {
            background: #047857;
            border-color: #047857;
            color: #6ee7b7;
            font-size: 15px;
        }

        .step.active .step-circle {
            width: 34px;
            height: 34px;
            margin-top: -2px;
            margin-bottom: 6px;
            background: #2563eb;
            border: 4px solid #183b79;
            color: white;
            font-size: 13px;
        }

        .step-label {
            font-size: 9px;
            color: #8593a9;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .step.completed .step-label {
            color: #34d399;
        }

        .step.active .step-label {
            color: #93b4ff;
        }

        .step-name {
            font-size: 11px;
            color: #aab5c5;
        }

        .step.completed .step-name,
        .step.active .step-name {
            color: #f1f5f9;
            font-weight: 700;
        }

        /* =========================
           AREA KONTEN BERIKUTNYA
        ========================= */

        .form-content {
            max-width: 1100px;
            margin: 35px auto;
            padding: 0 5%;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 650px) {

            .navbar {
                height: auto;
                min-height: 65px;
                padding: 12px 15px;
                flex-wrap: wrap;
                gap: 12px;
            }

            .navbar-right {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 5px;
            }

            .nav-link {
                white-space: nowrap;
            }

            .user-profile {
                white-space: nowrap;
            }

            .registration-header {
                padding: 35px 20px 30px;
            }

            .header-title {
                font-size: 21px;
            }

            .header-year {
                font-size: 14px;
            }

            .header-description {
                font-size: 11px;
            }

            .period-badge {
                font-size: 8px;
            }

            .progress-section {
                padding: 20px 12px 30px;
            }

            .step-name {
                font-size: 9px;
            }

            .step-label {
                font-size: 8px;
            }

            .step-circle {
                width: 27px;
                height: 27px;
            }

            .step.active .step-circle {
                width: 32px;
                height: 32px;
            }

        }

    </style>
</head>

<body>

    <!-- =========================
         NAVBAR
    ========================= -->

    <nav class="navbar">

        <div class="navbar-brand">

            <img
                src="{{ asset('build/assets/image/logo sibeka.png') }}"
                alt="Logo POLMED">

            <div>
                <div class="brand-name">SIBEKA POLMED</div>
                <div class="brand-subtitle">
                    Portal Beasiswa Resmi Politeknik Negeri Medan
                </div>
            </div>

        </div>


        <div class="navbar-right">

            <a href="{{ url('/') }}" class="nav-link">
                Beranda
            </a>

            <a href="{{ url('/pendaftaran') }}" class="nav-link active">
                Pendaftaran
            </a>

            <a href="{{ url('/dokumen') }}" class="nav-link">
                Dokumen
            </a>

            <a href="{{ url('/status-seleksi') }}" class="nav-link">
                Status Seleksi
            </a>

            <div class="nav-divider"></div>

            <div class="user-profile">

                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'RP', 0, 2)) }}
                </div>

                <span>
                    {{ auth()->user()->name ?? 'Pengguna' }}
                </span>

                <span>⌄</span>

            </div>

        </div>

    </nav>


    <!-- =========================
         HEADER PENDAFTARAN
    ========================= -->

    <section class="registration-header">

        <div class="header-container">

            <div class="period-badge">

                <span class="status-dot"></span>

                PERIODE PENDAFTARAN TERBUKA:
                JALUR PRESTASI & MANDIRI (GELOMBANG 1)

            </div>

            <h1 class="header-title">
                Formulir Pendaftaran Beasiswa POLMED
            </h1>

            <h2 class="header-year">
                Tahun Akademik 2025/2026
            </h2>

            <p class="header-description">
                Lengkapi data diri, riwayat akademik, verifikasi ekonomi
                keluarga, serta unggah dokumen persyaratan resmi secara
                transparan dan akuntabel.
            </p>

        </div>

    </section>


    <!-- =========================
         PROGRESS PENDAFTARAN
    ========================= -->

    <section class="progress-section">

        <div class="progress-container">

            <div class="progress-line"></div>

            <div class="progress-line-active"></div>

            <div class="steps">

                <!-- TAHAP 1 -->
                <div class="step completed">

                    <div class="step-circle">
                        ✓
                    </div>

                    <div class="step-label">
                        TAHAP 01
                    </div>

                    <div class="step-name">
                        Identitas Diri
                    </div>

                </div>


                <!-- TAHAP 2 -->
                <div class="step active">

                    <div class="step-circle">
                        ♧
                    </div>

                    <div class="step-label">
                        TAHAP 02
                    </div>

                    <div class="step-name">
                        Data Akademik
                    </div>

                </div>


                <!-- TAHAP 3 -->
                <div class="step">

                    <div class="step-circle">
                        03
                    </div>

                    <div class="step-label">
                        TAHAP 03
                    </div>

                    <div class="step-name">
                        Unggah Berkas
                    </div>

                </div>


                <!-- TAHAP 4 -->
                <div class="step">

                    <div class="step-circle">
                        04
                    </div>

                    <div class="step-label">
                        TAHAP 04
                    </div>

                    <div class="step-name">
                        Finalisasi
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!--
        AREA KONTEN FORMULIR AKAN KITA TAMBAHKAN
        SETELAH DESAIN BAGIAN INI SELESAI.
    -->

</body>
</html>

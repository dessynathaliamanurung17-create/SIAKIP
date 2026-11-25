<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-container">

        <div class="brand">
            <div class="brand-logo">
                <img src="{{ asset('images/logo%20sibeka.png') }}"
                    alt="Logo SIBEKA">
            </div>
        </div>

        <div class="nav-menu">
            <a href="{{ url('/') }}" class="nav-link active">Beranda</a>
            <a href="#alur-seleksi" class="nav-link">Alur Seleksi</a>
            <a href="#persyaratan" class="nav-link">Persyaratan</a>
            <a href="#informasi" class="nav-link">Informasi</a>
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

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
        <a wire:navigate href="{{ route('home') }}" class="logo d-flex align-items-center me-auto">
            <img src="{{ asset('assets/img/logo-icon.png') }}" alt="" class="logo-icon">
            <h1 class="logo-text">Tirta Nirwana</h1>
        </a>
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a wire:navigate href="{{ route('home') }}" class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}">Home</a></li>
                <li class="dropdown">
                    <a href="#program-les">Program<i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="#tarif">Tarif</a></li>
                        <li><a href="#syarat-dan-ketentuan">Syarat & Ketentuan</a></li>
                    </ul>
                </li>
                <li><a wire:navigate href="{{ route('about') }}" class="nav-link {{ Route::currentRouteName() == 'about' ? 'active' : '' }}">About</a></li>
                <li><a wire:navigate href="{{ route('gallery') }}" class="nav-link {{ Route::currentRouteName() == 'gallery' ? 'active' : '' }}">Gallery</a></li>
                <li><a wire:navigate href="{{ route('blog') }}" class="nav-link {{ Route::currentRouteName() == 'blog' ? 'active' : '' }}">Blog</a></li>
                <li><a wire:navigate href="{{ route('contact') }}" class="nav-link {{ Route::currentRouteName() == 'contact' ? 'active' : '' }}">Contact</a></li>
                @if($isAuthenticated)
                    <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                @else
                    <li><a wire:navigate href="{{ route('register') }}" class="btn-daftar">Daftar Sekarang</a></li>
                @endif
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>
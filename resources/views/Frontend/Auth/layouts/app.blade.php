<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title') - Pt.Tirta Nirwana</title>
    <meta name="description" content="Tirta Nirwana - Les Renang Profesional di Surabaya">
    <meta name="keywords" content="les renang, swimming lessons, surabaya, tirta nirwana">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo-icon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logo-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    @livewireStyles
</head>
<body class="index-page">
    @livewire('header')

    <main class="main">
        @yield('content')
    </main>

    @livewire('footer')

    <!-- WhatsApp Floating Button -->
    @php
        $contact = \App\Models\Contact::first() ?? (object) [
            'whatsapp_number' => '6285852532681',
            'whatsapp_message' => 'Halo Tirta Nirwana, saya ingin info tentang les renang'
        ];
        $whatsappUrl = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $contact->whatsapp_number) . '?text=' . urlencode($contact->whatsapp_message);
    @endphp
    <a href="{{ $whatsappUrl }}" class="whatsapp-float" target="_blank" data-aos="fade-up" data-aos-delay="200" aria-label="Hubungi kami di WhatsApp">
        <i class="bi bi-whatsapp whatsapp-icon"></i>
        <span class="whatsapp-tooltip">Chat via WhatsApp</span>
    </a>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}" defer></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}" defer></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}" defer></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}" defer></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}" defer></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}" defer></script>

    @livewireScripts
</body>
</html>
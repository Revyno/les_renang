<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $page['props']['meta']['description'] ?? 'Tirta Nirwana — sekolah renang di Surabaya untuk segala usia.' }}">

    <link rel="icon" type="image/png" href="/assets/img/favicon.png?v=tirta">
    <link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png?v=tirta">

    {{-- Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.tsx'])
    @inertiaHead
</head>
<body class="font-sans antialiased">
    {{-- Inertia v3 client reads the initial page from a <script type="application/json">
         element (getInitialPageFromDOM), which the installed inertia-laravel v1 @inertia
         directive does not emit. Emit the v3-compatible root manually.
         ponytail: hand-rolled root couples us to v3's DOM contract. Upgrade path:
         bump inertia-laravel to the version matching the JS client (needs Laravel 10+)
         and restore @inertia. --}}
    <div id="app"></div>
    <script type="application/json" data-page="app">{!! json_encode($page, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}</script>
</body>
</html>

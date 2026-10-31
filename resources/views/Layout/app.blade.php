<!DOCTYPE html>
<html lang="ar" dir="ltr" class="bg-[#06140e]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'تدبّر — Tadabbur')</title>

    {{-- Preload background & logo so they stay cached in memory with zero flicker across pages --}}
    <link rel="preload" as="image" href="{{ asset('images/tadabbur-bg.jpg') }}" fetchpriority="high">
    <link rel="preload" as="image" href="{{ asset('images/tadabbur-logo.jpg') }}">

    {{-- Instant View Transitions between pages --}}
    <style>
        @view-transition {
            navigation: auto;
        }
        ::view-transition-old(root),
        ::view-transition-new(root) {
            animation-duration: 180ms;
        }
    </style>

    {{-- Fonts: Amiri for Arabic Calligraphy & Cinzel / Instrument Sans for typography --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Cinzel:wght@600;700;800&family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative min-h-screen bg-[#06140e] antialiased selection:bg-[#d4af37]/30 selection:text-white text-[#fbf8f2] overflow-x-hidden">

    {{-- Fixed GPU-accelerated background layer that never reloads or flickers --}}
    <div class="fixed inset-0 -z-10 pointer-events-none overflow-hidden bg-[#06140e]" style="transform: translateZ(0); will-change: transform;">
        <img
            src="{{ asset('images/tadabbur-bg.jpg') }}"
            alt=""
            decoding="sync"
            fetchpriority="high"
            class="h-full w-full object-cover object-center select-none"
        >
        <div
            class="absolute inset-0"
            style="background: linear-gradient(180deg, rgba(6, 20, 14, 0.80) 0%, rgba(3, 11, 8, 0.90) 100%);"
        ></div>
    </div>

    <x-navbar :page="$page ?? ''" />

    <main class="relative z-10 pb-16">
        @yield('content')
    </main>

</body>

</html>

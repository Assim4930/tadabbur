<!DOCTYPE html>
<html lang="ar" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'تدبّر — Tadabbur')</title>

    {{-- Fonts: Amiri for Arabic Calligraphy & Cinzel / Instrument Sans for typography --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Cinzel:wght@600;700;800&family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen bg-center bg-fixed bg-no-repeat antialiased selection:bg-[#d4af37]/30 selection:text-white text-[#fbf8f2]"
    style="
        background-image: linear-gradient(180deg, rgba(6, 20, 14, 0.80) 0%, rgba(3, 11, 8, 0.90) 100%), url('{{ asset('images/tadabbur-bg.jpg') }}');
        background-size: cover;
    "
>
    <x-navbar :page="$page ?? ''" />

    <main>
        @yield('content')
    </main>

</body>

</html>

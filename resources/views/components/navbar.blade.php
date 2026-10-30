@props(['page' => ''])

<nav class="sticky top-0 z-50 border-b border-[#d4af37]/25 bg-[#06140e]/92 shadow-2xl backdrop-blur-xl">
    <a href="{{ route('home') }}" class="site-name">
        <span class="text-2xl md:text-3xl font-bold font-amiri tracking-normal">تدبّر</span>
        <span class="text-xs md:text-sm font-cinzel font-semibold tracking-widest text-[#f3d574] opacity-90">TADABBUR</span>
    </a>

    <ul class="mx-auto flex max-w-7xl items-center gap-4 px-4 py-3">
        @auth
            <li>
                <a href="{{ route('bookmarks') }}"
                   class="flex items-center gap-2 rounded-full px-4 py-1.5 text-xs font-semibold tracking-wider transition-all duration-200 {{ ($page ?? '') === 'Bookmarks' ? 'bg-[#d4af37] text-[#0a1f17] shadow-md' : 'text-[#fbf8f2]/80 hover:bg-[#d4af37]/15 hover:text-[#f3d574]' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="h-4 w-4 shrink-0" style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                    <span>Bookmarks</span>
                </a>
            </li>

            <li>
                <div class="flex items-center gap-2.5 rounded-full bg-white/5 py-1 pl-1 pr-3 border border-[#d4af37]/25">
                    <img src="{{ asset('images/profile.jpeg') }}" width="36" height="36" alt="Profile"
                        class="h-9 w-9 rounded-full object-cover ring-2 ring-[#d4af37]/70 transition hover:scale-105"
                        style="width: 36px; height: 36px;">
                    <span class="text-xs font-semibold text-[#fbf8f2] truncate max-w-[120px]">{{ Auth::user()->name }}</span>
                </div>
            </li>

            <li>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="rounded-full border border-white/20 bg-white/10 px-3.5 py-1.5 text-xs font-semibold text-white transition hover:bg-red-500/25 hover:border-red-400/40 hover:text-red-200">
                        Log Out
                    </button>
                </form>
            </li>
        @else
            @if (($page ?? '') === 'Sign Up')
                <li><a href="{{ route('login') }}" class="btn-primary text-xs py-2 px-5 rounded-full">Log In</a></li>
            @elseif(($page ?? '') === 'Log In')
                <li><a href="{{ route('signup') }}" class="btn-primary text-xs py-2 px-5 rounded-full">Sign Up</a></li>
            @else
                <li><a href="{{ route('login') }}" class="btn-primary text-xs py-2 px-5 rounded-full">Log In</a></li>
                <li><a href="{{ route('signup') }}" class="text-xs font-semibold text-[#fbf8f2]/80 hover:text-[#f3d574] transition px-3 py-1.5">Sign Up</a></li>
            @endif
        @endauth

        <li class="ml-auto">
            <a href="{{ route('home') }}" class="block transition hover:opacity-90" title="تدبّر — الرئيسية">
                <img src="{{ asset('images/tadabbur-logo.jpg') }}" alt="شعار تدبّر" class="h-12 w-auto max-h-12 rounded-xl object-contain border border-[#d4af37]/35 shadow-[0_2px_12px_rgba(212,175,55,0.25)] transition-all duration-300 hover:scale-105 hover:border-[#d4af37] hover:shadow-[0_4px_16px_rgba(212,175,55,0.45)]" style="max-height: 48px;">
            </a>
        </li>
    </ul>
</nav>

@props(['page' => ''])

<nav class="sticky top-0 z-50 border-b border-[#d4af37]/25 bg-[#06140e]/92 shadow-2xl backdrop-blur-xl">
    <ul class="mx-auto flex max-w-7xl items-center justify-between gap-2 sm:gap-4 px-3 sm:px-4 py-2.5 sm:py-3">
        {{-- Left side: Auth actions / User controls --}}
        <li class="flex items-center gap-1.5 sm:gap-3 min-w-0">
            @auth
                <a href="{{ route('bookmarks') }}"
                   title="Bookmarks"
                   class="flex items-center gap-1.5 sm:gap-2 rounded-full px-2.5 sm:px-4 py-1.5 text-xs font-semibold tracking-wider transition-all duration-200 {{ ($page ?? '') === 'Bookmarks' ? 'bg-[#d4af37] text-[#0a1f17] shadow-md' : 'text-[#fbf8f2]/80 hover:bg-[#d4af37]/15 hover:text-[#f3d574]' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="h-4 w-4 shrink-0" style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                    <span class="hidden sm:inline">Bookmarks</span>
                </a>

                <div class="flex items-center gap-1.5 sm:gap-2.5 rounded-full bg-white/5 py-1 pl-1 pr-2.5 sm:pr-3 border border-[#d4af37]/25 min-w-0">
                    <img src="{{ asset('images/profile.jpeg') }}" width="32" height="32" alt="Profile"
                        class="h-7 w-7 sm:h-9 sm:w-9 rounded-full object-cover ring-2 ring-[#d4af37]/70 shrink-0 transition hover:scale-105"
                        style="width: 30px; height: 30px;">
                    <span class="text-[11px] sm:text-xs font-semibold text-[#fbf8f2] truncate max-w-[75px] sm:max-w-[120px]">{{ Auth::user()->name }}</span>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="inline shrink-0">
                    @csrf
                    <button type="submit" class="rounded-full border border-white/20 bg-white/10 px-2.5 sm:px-3.5 py-1.5 text-[11px] sm:text-xs font-semibold text-white transition hover:bg-red-500/25 hover:border-red-400/40 hover:text-red-200 whitespace-nowrap">
                        Log Out
                    </button>
                </form>
            @else
                @if (($page ?? '') === 'Sign Up')
                    <a href="{{ route('login') }}" class="btn-primary text-xs py-1.5 sm:py-2 px-4 sm:px-5 rounded-full whitespace-nowrap">Log In</a>
                @elseif(($page ?? '') === 'Log In')
                    <a href="{{ route('signup') }}" class="btn-primary text-xs py-1.5 sm:py-2 px-4 sm:px-5 rounded-full whitespace-nowrap">Sign Up</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary text-xs py-1.5 sm:py-2 px-4 sm:px-5 rounded-full whitespace-nowrap">Log In</a>
                    <a href="{{ route('signup') }}" class="text-xs font-semibold text-[#fbf8f2]/80 hover:text-[#f3d574] transition px-2 sm:px-3 py-1.5 whitespace-nowrap">Sign Up</a>
                @endif
            @endauth
        </li>

        {{-- Right side on mobile / Centered title + Right logo on desktop --}}
        <li class="ml-auto flex items-center gap-2.5 sm:gap-3 shrink-0">
            <a href="{{ route('home') }}" class="site-name">
                <span class="text-xl sm:text-2xl md:text-3xl font-bold font-amiri tracking-normal">تدبّر</span>
                <span class="hidden sm:inline text-xs md:text-sm font-cinzel font-semibold tracking-widest text-[#f3d574] opacity-90">TADABBUR</span>
            </a>

            <a href="{{ route('home') }}" class="block transition hover:opacity-90 shrink-0" title="تدبّر — الرئيسية">
                <img src="{{ asset('images/tadabbur-logo.jpg') }}" alt="شعار تدبّر"
                    class="h-10 sm:h-12 w-auto max-h-10 sm:max-h-12 rounded-xl object-contain border border-[#d4af37]/35 shadow-[0_2px_12px_rgba(212,175,55,0.25)] transition-all duration-300 hover:scale-105 hover:border-[#d4af37] hover:shadow-[0_4px_16px_rgba(212,175,55,0.45)]">
            </a>
        </li>
    </ul>
</nav>

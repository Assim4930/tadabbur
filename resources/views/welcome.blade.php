@extends('Layout.app')

@section('title', ($currentTab ?? 'all') === 'bookmarks' ? 'Bookmarks — تدبّر' : 'تدبّر — Tadabbur')
@section('content')
    <div class="mx-auto max-w-3xl px-3.5 sm:px-4 py-5 sm:py-8 md:px-0">

        {{-- Inspiring Header Banner --}}
        <div class="text-center mb-6 sm:mb-8 pt-1 sm:pt-2">
            <div class="inline-flex flex-wrap items-center justify-center gap-1.5 sm:gap-2.5 rounded-2xl sm:rounded-full border border-[#d4af37]/35 bg-[#0a1e16]/85 px-3.5 sm:px-5 py-1.5 text-xs font-semibold text-[#f3d574] backdrop-blur-md shadow-2xl max-w-full">
                <span class="text-[#d4af37]">✨</span>
                <span class="font-amiri text-base font-bold text-white">تدبّر</span>
                <span class="opacity-40">|</span>
                <span class="font-amiri text-xs sm:text-sm text-[#fbf8f2]/90">مساحة لمشاركة الحِكَم والخواطر المُلهمة</span>
                <span class="hidden md:inline opacity-40">·</span>
                <span class="hidden md:inline font-sans text-xs opacity-75">Wisdom & Reflections</span>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="mb-5 sm:mb-6 rounded-2xl bg-[#143a2b]/95 backdrop-blur-md border border-[#d4af37]/50 p-3.5 sm:p-4 text-[#fbf8f2] shadow-2xl flex items-center justify-between gap-2 transition-all">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="h-5 w-5 shrink-0 text-[#f3d574]" style="width: 20px; height: 20px;" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium text-xs sm:text-sm">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-[#fbf8f2]/70 hover:text-white text-lg font-bold px-1">✕</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 sm:mb-6 rounded-2xl bg-red-900/90 backdrop-blur-md border border-red-400/30 p-3.5 sm:p-4 text-white shadow-xl">
                <ul class="list-disc list-inside space-y-1 text-xs sm:text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tabs Navigation (Visible for authenticated users) --}}
        @auth
            <div class="mb-6 sm:mb-8 flex items-center justify-center">
                <div class="inline-flex items-center gap-1 sm:gap-1.5 rounded-full bg-[#081812]/85 p-1 sm:p-1.5 border border-[#d4af37]/35 backdrop-blur-md shadow-2xl max-w-full">
                    <a href="{{ route('home', ['tab' => 'all']) }}"
                       class="flex items-center gap-1.5 sm:gap-2 rounded-full px-4 sm:px-5 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold transition-all duration-200 {{ ($currentTab ?? 'all') === 'all' ? 'bg-gradient-to-r from-[#143a2b] to-[#1e543e] text-[#fbf8f2] shadow-lg border border-[#d4af37]/50' : 'text-[#fbf8f2]/70 hover:text-white hover:bg-white/10' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="h-4 w-4 sm:h-[18px] sm:w-[18px] shrink-0" style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <span>All Quotes</span>
                    </a>

                    <a href="{{ route('bookmarks') }}"
                       class="flex items-center gap-1.5 sm:gap-2 rounded-full px-4 sm:px-5 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold transition-all duration-200 {{ ($currentTab ?? 'all') === 'bookmarks' ? 'bg-gradient-to-r from-[#143a2b] to-[#1e543e] text-[#fbf8f2] shadow-lg border border-[#d4af37]/50' : 'text-[#fbf8f2]/70 hover:text-white hover:bg-white/10' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="h-4 w-4 sm:h-[18px] sm:w-[18px] shrink-0 {{ ($currentTab ?? 'all') === 'bookmarks' ? 'text-[#d4af37] fill-[#d4af37]' : '' }}" style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                        </svg>
                        <span>Bookmarks</span>
                        @if ($bookmarksCount > 0)
                            <span class="rounded-full bg-[#d4af37] px-2 py-0.5 text-[11px] sm:text-xs font-bold text-[#0a1f17]">
                                {{ $bookmarksCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        @endauth

        {{-- Quotes panel --}}
        <section class="space-y-4 sm:space-y-5">
            <div class="flex flex-wrap items-center justify-between gap-2 pb-1">
                <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-white flex flex-wrap items-center gap-2">
                    @if (($currentTab ?? 'all') === 'bookmarks')
                        <span class="font-amiri text-xl sm:text-2xl text-[#f3d574]">المحفوظات</span>
                        <span class="text-[11px] sm:text-xs uppercase tracking-widest text-[#fbf8f2]/60 font-sans">Saved Bookmarks</span>
                        <span class="text-lg sm:text-xl">🔖</span>
                    @else
                        <span class="font-amiri text-xl sm:text-2xl text-[#f3d574]">الاقتباسات والتدبّرات</span>
                        <span class="text-[11px] sm:text-xs uppercase tracking-widest text-[#fbf8f2]/60 font-sans">Quotes Feed</span>
                    @endif
                </h2>
                @if (($currentTab ?? 'all') === 'bookmarks')
                    <span class="text-xs font-semibold text-[#f3d574] bg-[#0a1e16]/80 px-3 py-1 rounded-full border border-[#d4af37]/30">
                        {{ $bookmarkedQuotes->count() }} {{ Str::plural('quote', $bookmarkedQuotes->count()) }}
                    </span>
                @endif
            </div>

            {{-- 1. Bookmarks Tab View --}}
            @if (($currentTab ?? 'all') === 'bookmarks')
                @forelse ($bookmarkedQuotes as $quote)
                    <blockquote class="relative rounded-2xl sm:rounded-3xl bg-[#fcfaf4]/96 backdrop-blur-md p-4 sm:p-6 text-[#0d2319] shadow-2xl border border-[#d4af37]/35 transition-all duration-300 hover:shadow-[0_15px_35px_rgba(212,175,55,0.2)] hover:-translate-y-0.5">
                        <p class="text-base sm:text-lg md:text-xl font-medium leading-relaxed pr-11 sm:pr-12 text-[#0f281e] break-words">
                            <span class="text-lg sm:text-xl md:text-2xl text-[#aa771c] font-bold select-none inline-block align-baseline mr-1">«</span>
                            <span>{{ $quote->text }}</span>
                            <span class="text-lg sm:text-xl md:text-2xl text-[#aa771c] font-bold select-none inline-block align-baseline ml-1">»</span>
                        </p>
                        <div class="mt-3.5 sm:mt-4 flex items-center gap-2 text-xs font-semibold text-[#143a2b]/80">
                            <span class="rounded-full bg-[#143a2b]/10 border border-[#143a2b]/20 px-2.5 py-0.5 sm:py-1 text-[#143a2b] font-bold">
                                {{ $quote->user->id === Auth::id() ? 'You' : $quote->user->name }}
                            </span>
                            <span class="text-[#d4af37]">·</span>
                            <span>{{ $quote->created_at->format('M d, Y') }}</span>
                        </div>

                        {{-- Action button (Remove bookmark) --}}
                        <div class="absolute right-3.5 top-3.5 sm:right-5 sm:top-5">
                            <form action="{{ route('quotes.bookmark', $quote) }}" method="POST">
                                @csrf
                                <button type="submit" title="Remove from bookmarks" class="flex h-9 w-9 items-center justify-center rounded-full bg-[#d4af37]/15 text-[#aa771c] transition-all duration-200 hover:scale-110 hover:bg-[#d4af37]/25 shadow-sm border border-[#d4af37]/40">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="h-5 w-5 shrink-0" style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="#d4af37">
                                        <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 0 1-1.085.67L12 18.089l-7.165 3.58A.75.75 0 0 1 3.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </blockquote>
                @empty
                    <div class="rounded-2xl sm:rounded-3xl border border-dashed border-[#d4af37]/35 bg-[#081812]/75 p-7 sm:p-10 text-center text-[#fbf8f2]/70 backdrop-blur-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" class="mx-auto h-12 w-12 text-[#d4af37]/60 mb-3" style="width: 48px; height: 48px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        <p class="text-lg font-semibold text-white font-amiri text-xl">لا توجد اقتباسات محفوظة بعد</p>
                        <p class="text-xs sm:text-sm text-[#fbf8f2]/60 mt-1 max-w-sm mx-auto">اضغط على أيقونة الحفظ 🔖 على أي تدبّر أو حكمة لإضافتها إلى قائمتك الخاصة.</p>
                        <a href="{{ route('home', ['tab' => 'all']) }}" class="btn btn-secondary mt-5 inline-block text-sm">
                            Browse All Quotes
                        </a>
                    </div>
                @endforelse

            {{-- 2. All Quotes Tab View --}}
            @else
                {{-- My quotes: Royal Emerald & Gold cards --}}
                @foreach ($myQuotes as $quote)
                    @if ($quote->id === $editingId)
                        <form method="POST" action="{{ route('quotes.update', $quote) }}"
                            class="space-y-3 rounded-2xl sm:rounded-3xl bg-gradient-to-br from-[#143a2b] to-[#0a1f17] p-4 sm:p-6 shadow-2xl border border-[#d4af37]/50">
                            @csrf
                            @method('PUT')

                            <label class="block text-sm font-semibold text-[#f3d574]">تعديل الاقتباس / Edit your quote</label>
                            <textarea name="quote" rows="3" required minlength="3" maxlength="155" class="input"
                                autofocus>{{ old('quote', $quote->text) }}</textarea>
                            <p class="text-xs text-[#fbf8f2]/60">3–155 characters.</p>

                            <div class="flex gap-2 pt-1">
                                <button type="submit" class="btn btn-secondary text-sm">Save</button>
                                <a href="{{ route('home') }}" class="btn text-[#fbf8f2]/80 hover:text-white text-sm hover:underline py-2 px-4 inline-flex items-center">Cancel</a>
                            </div>
                        </form>
                    @else
                        <blockquote class="relative rounded-2xl sm:rounded-3xl bg-gradient-to-br from-[#123829]/95 via-[#0e2c20]/95 to-[#091d15]/98 p-4 sm:p-6 text-[#fbf8f2] shadow-2xl border border-[#d4af37]/35 transition-all duration-300 hover:shadow-[0_15px_35px_rgba(20,58,43,0.4)] hover:border-[#d4af37]/60 hover:-translate-y-0.5">
                            <p class="text-base sm:text-lg md:text-xl font-medium leading-relaxed sm:pr-24 tracking-wide text-[#fbf8f2] break-words">
                                <span class="text-lg sm:text-xl md:text-2xl text-[#f3d574] font-bold select-none inline-block align-baseline mr-1">«</span>
                                <span>{{ $quote->text }}</span>
                                <span class="text-lg sm:text-xl md:text-2xl text-[#f3d574] font-bold select-none inline-block align-baseline ml-1">»</span>
                            </p>

                            <div class="mt-4 flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 text-xs font-medium text-[#fbf8f2]/70">
                                    <span class="rounded-full bg-[#d4af37]/20 border border-[#d4af37]/40 px-2.5 py-0.5 text-[#f3d574] font-bold">You</span>
                                    <span class="text-[#d4af37]">·</span>
                                    <span>{{ $quote->created_at->format('M d, Y') }}</span>
                                </div>

                                {{-- Actions: inline on mobile, bottom-right on desktop --}}
                                <div class="flex items-center gap-2 sm:absolute sm:right-5 sm:bottom-5">
                                    {{-- Bookmark button --}}
                                    <form action="{{ route('quotes.bookmark', $quote) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" title="{{ $quote->isBookmarkedBy(Auth::user()) ? 'Remove bookmark' : 'Bookmark quote' }}"
                                                class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 border border-[#d4af37]/25 transition-all duration-200 hover:scale-110 hover:bg-[#d4af37]/20">
                                            @if ($quote->isBookmarkedBy(Auth::user()))
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="h-[18px] w-[18px] shrink-0" style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="#d4af37">
                                                    <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 0 1-1.085.67L12 18.089l-7.165 3.58A.75.75 0 0 1 3.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93Z" clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="h-[18px] w-[18px] shrink-0 text-[#fbf8f2]/80 hover:text-[#d4af37]" style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                                </svg>
                                            @endif
                                        </button>
                                    </form>

                                    {{-- Edit button --}}
                                    <a href="{{ route('home', ['edit' => $quote->id]) }}"
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 border border-white/15 text-[#fbf8f2]/90 transition-all duration-200 hover:scale-110 hover:bg-white/20 hover:text-[#f3d574]" title="Edit">✎</a>

                                    {{-- Delete button: immediate deletion with no confirmation (Constraint in SRS) --}}
                                    <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 border border-white/15 text-[#fbf8f2]/90 transition-all duration-200 hover:scale-110 hover:bg-red-500/30 hover:text-red-300" title="Delete">⌫</button>
                                    </form>
                                </div>
                            </div>
                        </blockquote>
                    @endif
                @endforeach

                {{-- Other users' quotes: Warm Marble Parchment cards --}}
                @foreach ($otherQuotes as $quote)
                    <blockquote class="relative rounded-2xl sm:rounded-3xl bg-[#fcfaf4]/96 backdrop-blur-md p-4 sm:p-6 text-[#0d2319] shadow-xl border border-[#d4af37]/30 transition-all duration-300 hover:shadow-[0_15px_35px_rgba(212,175,55,0.2)] hover:-translate-y-0.5">
                        <p class="text-base sm:text-lg md:text-xl font-medium leading-relaxed pr-11 sm:pr-12 text-[#0f281e] break-words">
                            <span class="text-lg sm:text-xl md:text-2xl text-[#aa771c] font-bold select-none inline-block align-baseline mr-1">«</span>
                            <span>{{ $quote->text }}</span>
                            <span class="text-lg sm:text-xl md:text-2xl text-[#aa771c] font-bold select-none inline-block align-baseline ml-1">»</span>
                        </p>
                        <div class="mt-3.5 sm:mt-4 flex items-center gap-2 text-xs font-semibold text-[#143a2b]/80">
                            <span class="rounded-full bg-[#143a2b]/10 border border-[#143a2b]/20 px-2.5 py-0.5 sm:py-1 text-[#143a2b] font-bold">
                                — {{ $quote->user->name }}
                            </span>
                            <span class="text-[#d4af37]">·</span>
                            <span>{{ $quote->created_at->format('M d, Y') }}</span>
                        </div>

                        {{-- Bookmark button --}}
                        <div class="absolute right-3.5 top-3.5 sm:right-5 sm:top-5">
                            <form action="{{ route('quotes.bookmark', $quote) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" title="{{ $quote->isBookmarkedBy(Auth::user()) ? 'Remove bookmark' : 'Bookmark quote' }}"
                                        class="flex h-9 w-9 items-center justify-center rounded-full bg-[#0a1e16]/5 border border-[#d4af37]/30 transition-all duration-200 hover:scale-110 hover:bg-[#d4af37]/20">
                                    @if ($quote->isBookmarkedBy(Auth::user()))
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="h-5 w-5 shrink-0" style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="#d4af37">
                                            <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 0 1-1.085.67L12 18.089l-7.165 3.58A.75.75 0 0 1 3.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93Z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="h-5 w-5 shrink-0 text-[#143a2b]/50 hover:text-[#d4af37]" style="width: 20px; height: 20px;" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                        </svg>
                                    @endif
                                </button>
                            </form>
                        </div>
                    </blockquote>
                @endforeach

                @if ($myQuotes->isEmpty() && $otherQuotes->isEmpty())
                    <div class="rounded-2xl sm:rounded-3xl border border-dashed border-[#d4af37]/30 bg-[#081812]/70 p-8 sm:p-12 text-center text-[#fbf8f2]/60">
                        <p class="text-lg font-medium font-amiri text-xl">لا توجد اقتباسات حتى الآن. كن أول من يشارك تدبّراً!</p>
                        <p class="text-xs sm:text-sm text-[#fbf8f2]/50 mt-1">No quotes yet. Be the first to share one!</p>
                    </div>
                @endif
            @endif
        </section>

    </div>

    {{-- Floating "+" button with Royal Emerald & Gold styling --}}
    <button type="button" popovertarget="quote-popup" aria-label="Share a quote"
        class="fixed bottom-5 right-5 sm:bottom-8 sm:right-8 z-40 flex h-13 w-13 sm:h-14 sm:w-14 items-center justify-center rounded-full bg-gradient-to-tr from-[#123829] via-[#1e543e] to-[#d4af37] text-white shadow-[0_10px_25px_rgba(212,175,55,0.35)] transition-all duration-300 hover:scale-110 hover:shadow-[0_15px_35px_rgba(212,175,55,0.55)] hover:brightness-110 border border-[#d4af37]/50 focus:outline-none focus-visible:ring-4 focus-visible:ring-[#d4af37]/40">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" class="h-6 w-6 sm:h-7 sm:w-7 shrink-0 text-white" style="width: 26px; height: 26px;" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
    </button>

    {{-- Pop-up form for sharing a quote --}}
    <div id="quote-popup" popover
        class="m-auto w-[92%] max-w-lg rounded-2xl sm:rounded-3xl bg-[#091a13]/97 text-[#fbf8f2] p-0 shadow-2xl border border-[#d4af37]/45 backdrop:bg-black/70 backdrop:backdrop-blur-md">

        <form method="POST" action="{{ route('quotes.store') }}" class="space-y-4 p-5 sm:p-6 md:p-8">
            @csrf

            <div class="flex items-center justify-between border-b border-[#d4af37]/20 pb-3.5 sm:pb-4">
                <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-[#fbf8f2] flex flex-wrap items-center gap-2">
                    <span class="font-amiri text-xl sm:text-2xl text-[#f3d574]">شارك تدبّراً</span>
                    <span class="text-[11px] sm:text-xs uppercase tracking-widest text-[#fbf8f2]/60 font-sans">Share a Quote</span>
                    <span class="text-base sm:text-lg">✨</span>
                </h2>
                <button type="button" popovertarget="quote-popup" popovertargetaction="hide" aria-label="Close"
                    class="rounded-full p-1.5 text-[#fbf8f2]/60 hover:bg-white/10 hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="h-[22px] w-[22px] shrink-0" style="width: 22px; height: 22px;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            @auth
                <div class="space-y-1.5">
                    <label for="quote-body" class="block text-xs sm:text-sm font-medium text-[#f3d574]">اكتب نص التدبّر أو الاقتباس / Your reflection</label>
                    <textarea id="quote-body" name="quote" rows="4" required minlength="3" maxlength="155" autofocus
                        placeholder="اكتب ما يجول بخاطرك من تدبّر أو حكمة مأثورة..." class="input resize-none"></textarea>
                    <p class="text-xs text-[#fbf8f2]/50">3–155 characters.</p>
                </div>

                <button type="submit" class="btn btn-secondary w-full mt-2 text-base">إرسال · Send</button>
            @else
                <div class="py-5 sm:py-6 text-center space-y-4">
                    <p class="text-[#fbf8f2]/80 text-sm">سجّل دخولك لتشارك تدبّراتك وحِكمك مع مجتمع تدبّر.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary inline-block">Log in to share a quote</a>
                </div>
            @endauth
        </form>
    </div>
@endsection

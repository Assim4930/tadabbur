<div class="grid h-full grid-cols-1 md:grid-cols-2 items-center max-w-6xl mx-auto">

    @yield('form')

    <div class="hidden md:flex md:items-center md:justify-center p-8">
        <div class="w-full max-w-md rounded-3xl p-10 bg-[#071711]/75 border border-[#d4af37]/30 shadow-2xl backdrop-blur-xl text-center flex flex-col items-center gap-6">
            <img src="{{ asset('images/tadabbur-logo.jpg') }}" alt="شعار تدبّر"
                 class="w-36 h-36 rounded-2xl object-cover border border-[#d4af37]/45 shadow-lg">

            <div class="space-y-3">
                <h3 class="text-3xl font-bold text-[#f3d574] font-amiri tracking-wide">
                    تدبّر — Tadabbur
                </h3>
                <div class="w-16 h-[1px] bg-gradient-to-r from-transparent via-[#d4af37]/70 to-transparent mx-auto"></div>
                <p class="text-xl text-[#fbf8f2]/95 font-amiri leading-relaxed" dir="rtl">
                    «كَلِمَةُ الحِكْمَةِ ضَالَّةُ المُؤْمِنِ، فَحَيْثُ وَجَدَهَا فَهُوَ أَحَقُّ بِهَا»
                </p>
                <p class="text-xs text-[#fbf8f2]/65 tracking-wider uppercase pt-1">
                    A Sanctuary for Wisdom &amp; Reflection
                </p>
            </div>
        </div>
    </div>

</div>

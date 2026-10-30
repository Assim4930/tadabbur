@extends('Layout.AuthImg')
@extends('Layout.app')

@section('title', 'Log In — تدبّر')
@section('content')
@section('form')

    <div class="flex items-center justify-center p-6 md:p-8">
        <form action="{{ route('login.store') }}" method="POST" class="mx-auto mt-2 w-full max-w-xl rounded-3xl p-8 md:p-10 bg-[#071711]/90 border border-[#d4af37]/35 shadow-2xl backdrop-blur-xl">
            @csrf

            <h2 class="mb-6 text-3xl font-bold text-center text-[#fbf8f2] font-amiri">
                تسجيل الدخول
                <span class="block text-xs uppercase tracking-widest text-[#f3d574] font-sans font-semibold mt-1">Welcome Back</span>
            </h2>

            @if (session('error'))
                <div class="mb-4 rounded-xl bg-red-900/60 border border-red-400/40 p-3 text-sm text-red-200 text-center">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4">
                <label for="email" class="label">Email / البريد الإلكتروني</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}"
                    class="input peer user-invalid:border-red-500" required
                    pattern="[^@\s]+@[^@\s]+\.[A-Za-z]{2,}">
                @error('email')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-[#fbf8f2]/60">
                    A valid email, e.g. name@example.com
                </p>
            </div>

            <div class="mb-5">
                <label for="password" class="label">Password / كلمة المرور</label>
                <input id="password" name="password" type="password"
                    class="input peer user-invalid:border-red-500" required minlength="8">
                @error('password')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-[#fbf8f2]/60">
                    At least 8 characters.
                </p>
            </div>

            <p class="mb-5 text-sm text-[#fbf8f2]/80">
                Don't have an account?
                <a href="{{ route('signup') }}" class="text-[#f3d574] hover:underline font-semibold">
                    Sign Up
                </a>
            </p>

            <button type="submit" class="btn btn-secondary w-full text-base">Log In · الدخول</button>
        </form>
    </div>

@endsection
@endsection

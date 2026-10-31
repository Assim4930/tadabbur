@extends('Layout.AuthImg')
@extends('Layout.app')

@section('title', 'Sign Up — تدبّر')

@section('content')
@section('form')

<div class="items-center justify-center p-4 sm:p-6 md:p-8">
    <form action="{{ route('signup.store') }}" method="POST"
          class="mx-auto mt-1 sm:mt-2 max-w-xl rounded-2xl sm:rounded-3xl p-5 sm:p-8 md:p-10 bg-[#071711]/90 border border-[#d4af37]/35 shadow-2xl backdrop-blur-xl">
        @csrf

        <h2 class="mb-5 sm:mb-6 text-2xl sm:text-3xl font-bold text-center text-[#fbf8f2] font-amiri">
            إنشاء حساب جديد
            <span class="block text-xs uppercase tracking-widest text-[#f3d574] font-sans font-semibold mt-1">Create an Account</span>
        </h2>

        <div class="mb-4">
            <label for="name" class="label">Name / الاسم</label>
            <input id="name" name="name" type="text"
                   value="{{ old('name') }}"
                   class="input peer user-invalid:border-red-500"
                   required minlength="2" maxlength="50"
                   pattern="[A-Za-z\u0600-\u06FF ]+">

            @error('name')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror

            <p class="mt-1 text-xs text-[#fbf8f2]/60">
                2–50 characters, letters only.
            </p>
        </div>

        <div class="mb-4">
            <label for="email" class="label">Email / البريد الإلكتروني</label>
            <input id="email" name="email" type="email"
                   value="{{ old('email') }}"
                   class="input peer user-invalid:border-red-500"
                   required
                   pattern="[^@\s]+@[^@\s]+\.[A-Za-z]{2,}">

            @error('email')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror

            <p class="mt-1 text-xs text-[#fbf8f2]/60">
                A valid email, e.g. name@example.com
            </p>
        </div>

        <div class="mb-4">
            <label for="password" class="label">Password / كلمة المرور</label>
            <input id="password" name="password" type="password"
                   class="input peer user-invalid:border-red-500"
                   required minlength="8">

            @error('password')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror

            <p class="mt-1 text-xs text-[#fbf8f2]/60">
                At least 8 characters.
            </p>
        </div>

        <div class="mb-5">
            <label for="password_confirmation" class="label">
                Confirm Password / تأكيد كلمة المرور
            </label>
            <input id="password_confirmation"
                   name="password_confirmation"
                   type="password"
                   class="input peer user-invalid:border-red-500"
                   required minlength="8">

            @error('password_confirmation')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror

            <p class="mt-1 text-xs text-[#fbf8f2]/60">
                Re-enter your password to confirm.
            </p>
        </div>

        <p class="mb-5 text-sm text-[#fbf8f2]/80">
            Already have an account?
            <a href="{{ route('login') }}" class="text-[#f3d574] hover:underline font-semibold">
                Log In
            </a>
        </p>

        <button type="submit" class="btn btn-secondary w-full text-base">
            Sign Up · إنشاء الحساب
        </button>
    </form>
</div>

@endsection
@endsection

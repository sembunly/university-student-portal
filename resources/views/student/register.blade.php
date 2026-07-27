<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('student.register.title') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 {{ app()->isLocale('en') ? 'font-en' : 'font-sans' }} text-slate-800 antialiased">
    @include('student.partials.page-loader')

    <div class="pointer-events-none fixed inset-0" aria-hidden="true">
        <img src="{{ asset('images/university-campus-login.webp') }}" alt="" class="h-full w-full object-cover">
        <div class="absolute inset-0 bg-slate-950/65"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-950/70 via-transparent to-slate-950/80"></div>
    </div>

    <main class="relative z-10 grid min-h-screen place-items-center px-4 py-10 sm:px-6">
        <div class="relative w-full max-w-lg">
            <section class="overflow-hidden rounded-3xl border border-white/80 bg-white/95 shadow-2xl shadow-blue-950/10 backdrop-blur">
                <div class="bg-gradient-to-br from-blue-800 via-blue-700 to-cyan-600 px-6 py-8 text-white sm:px-9">
                    <div class="flex items-center gap-4">
                        <div class="grid h-16 w-16 shrink-0 place-items-center rounded-2xl bg-white/15 ring-1 ring-white/25">
                            <svg class="h-9 w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/><path d="M19 3v6M16 6h6"/></svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-black sm:text-3xl">{{ __('student.register.title') }}</h1>
                            <p class="mt-1 text-sm font-semibold text-blue-100">{{ __('student.register.subtitle') }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('student.register.store') }}" method="POST" class="space-y-5 p-6 sm:p-9">
                    @csrf

                    <div>
                        <label for="phone" class="text-sm font-extrabold text-slate-700">{{ __('student.register.phone') }} <span class="text-red-500">*</span></label>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" autofocus required
                            placeholder="{{ __('student.register.phone_placeholder') }}"
                            class="mt-2 w-full rounded-xl border bg-white px-4 py-3.5 text-sm font-bold outline-none transition placeholder:font-normal placeholder:text-slate-400 focus:ring-4 {{ $errors->has('phone') ? 'border-red-400 focus:border-red-500 focus:ring-red-100' : 'border-slate-200 focus:border-blue-500 focus:ring-blue-100' }}">
                        @error('phone')<p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm leading-6 text-blue-900">
                        {{ __('student.register.id_note') }}
                    </div> -->

                    <div>
                        <label for="password" class="text-sm font-extrabold text-slate-700">{{ __('student.login.password') }} <span class="text-red-500">*</span></label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            placeholder="{{ __('student.login.password_placeholder') }}"
                            class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-bold outline-none transition placeholder:font-normal placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                        @error('password')<p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="text-sm font-extrabold text-slate-700">{{ __('student.register.password_confirmation') }} <span class="text-red-500">*</span></label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                            placeholder="{{ __('student.register.password_confirmation_placeholder') }}"
                            class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-bold outline-none transition placeholder:font-normal placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                    </div>

                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-900 px-5 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-blue-900/20 transition hover:-translate-y-0.5 hover:bg-blue-800">
                        {{ __('student.register.button') }}
                    </button>

                    <p class="text-center text-sm font-semibold text-slate-600">
                        {{ __('student.register.have_account') }}
                        <a href="{{ route('student.login') }}" class="font-extrabold text-blue-700 hover:text-blue-900">
                            {{ __('student.register.login_link') }}
                        </a>
                    </p>
                </form>
            </section>
        </div>
    </main>
</body>
</html>

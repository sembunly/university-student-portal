<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('student.login.title') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white {{ app()->isLocale('en') ? 'font-en' : 'font-sans' }} text-slate-800 antialiased selection:bg-indigo-100 selection:text-indigo-900">
    @include('student.partials.page-loader')

    <main class="grid min-h-screen lg:grid-cols-[minmax(0,1.45fr)_minmax(440px,.75fr)]">
        <section class="relative hidden min-h-screen overflow-hidden bg-slate-950 lg:block" aria-label="{{ __('student.login.campus_image') }}">
            <img src="{{ asset('images/university-campus-login.webp') }}"
                alt="{{ __('student.login.campus_image') }}"
                class="absolute inset-0 h-full w-full object-cover"
                fetchpriority="high">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 via-slate-950/25 to-slate-950/10"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-slate-950/20"></div>

            <div class="relative flex min-h-screen flex-col justify-between p-10 text-white xl:p-14">
                <div class="flex items-center gap-3">
                    <div class="grid h-12 w-12 place-items-center rounded-2xl border border-white/20 bg-white/10 backdrop-blur-md">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="M3 8.5 12 4l9 4.5-9 4.5-9-4.5Z"/>
                            <path d="M7 10.5V15c2.6 2 7.4 2 10 0v-4.5M21 9v6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-black">{{ __('student.common.university') }}</p>
                        <p class="text-xs font-bold uppercase tracking-[.18em] text-indigo-200">{{ __('student.common.portal') }}</p>
                    </div>
                </div>

                <div class="max-w-2xl pb-6">
                    <div class="mb-6 h-1 w-16 rounded-full bg-indigo-400"></div>
                    <h2 class="max-w-xl text-4xl font-black leading-tight tracking-tight xl:text-5xl">
                        {{ __('student.login.campus_heading') }}
                    </h2>
                    <p class="mt-5 max-w-xl text-base leading-8 text-slate-200 xl:text-lg">
                        {{ __('student.login.campus_message') }}
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3 text-xs font-bold text-white/90">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 backdrop-blur-md">
                            <svg class="h-4 w-4 text-emerald-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
                            {{ __('student.login.secure_access') }}
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 backdrop-blur-md">
                            <svg class="h-4 w-4 text-indigo-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                            {{ __('student.login.available_anytime') }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative flex min-h-screen items-center justify-center overflow-hidden bg-[#f8fafc] px-4 py-8 sm:px-8 lg:px-10 xl:px-14">
            <div class="pointer-events-none absolute right-0 top-0 h-72 w-72 rounded-full bg-indigo-100/70 blur-3xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute bottom-0 left-0 h-64 w-64 rounded-full bg-sky-100/70 blur-3xl" aria-hidden="true"></div>

            <div class="relative w-full max-w-md">
                <div class="mb-6 flex items-center justify-between lg:justify-end">
                    <div class="flex items-center gap-2 lg:hidden">
                        <div class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-700 text-white shadow-lg shadow-indigo-500/20">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path d="M3 8.5 12 4l9 4.5-9 4.5-9-4.5Z"/>
                                <path d="M7 10.5V15c2.6 2 7.4 2 10 0v-4.5M21 9v6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-900">{{ __('student.common.university') }}</p>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-indigo-500">{{ __('student.common.portal') }}</p>
                        </div>
                    </div>

                    <div class="flex rounded-xl border border-slate-200 bg-white p-1 shadow-sm" aria-label="{{ __('student.common.language') }}">
                        <a href="{{ route('language.switch', 'km') }}" lang="km" data-language-link
                            class="rounded-lg px-3 py-1.5 text-xs font-extrabold transition {{ app()->isLocale('km') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-500 hover:text-indigo-700' }}">ខ្មែរ</a>
                        <a href="{{ route('language.switch', 'en') }}" lang="en" data-language-link
                            class="rounded-lg px-3 py-1.5 text-xs font-extrabold transition {{ app()->isLocale('en') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-500 hover:text-indigo-700' }}">EN</a>
                    </div>
                </div>

                <section class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-[0_24px_65px_-30px_rgba(15,23,42,.3)] sm:p-8 xl:p-10">
                    <header class="text-center">
                        <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100">
                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                        </div>
                        <p class="mt-4 text-xs font-extrabold uppercase tracking-[.16em] text-indigo-500">{{ __('student.common.portal') }}</p>
                        <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-950 sm:text-3xl">{{ __('student.login.welcome') }}</h1>
                        <p class="mt-2 text-sm font-medium text-slate-500">{{ __('student.login.subtitle') }}</p>
                    </header>

                    <div class="my-7 h-px bg-slate-100"></div>

                    <form action="{{ route('student.login.attempt') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label for="login" class="text-sm font-extrabold text-slate-700">
                                {{ __('student.login.identifier') }} <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative mt-2">
                                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="11" r="2"/><path d="M14 10h4M14 14h4"/></svg>
                                <input id="login" name="login" value="{{ old('login') }}" autocomplete="username" autofocus required
                                    placeholder="{{ __('student.login.identifier_placeholder') }}"
                                    class="w-full rounded-xl border bg-white py-3.5 pl-12 pr-4 text-sm font-bold outline-none transition placeholder:font-normal placeholder:text-slate-400 focus:ring-4 {{ $errors->has('login') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-100' : 'border-slate-200 focus:border-indigo-500 focus:ring-indigo-100' }}">
                            </div>
                            @error('login')<p class="mt-2 text-xs font-semibold text-rose-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="password" class="text-sm font-extrabold text-slate-700">
                                {{ __('student.login.password') }} <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative mt-2">
                                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="5" y="10" width="14" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                                <input id="password" name="password" type="password" autocomplete="current-password" required
                                    placeholder="{{ __('student.login.password_placeholder') }}"
                                    class="w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-12 pr-12 text-sm font-bold outline-none transition placeholder:font-normal placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                                <button id="togglePassword" type="button" aria-label="{{ __('student.login.show_password') }}" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-2 text-slate-400 transition hover:bg-indigo-50 hover:text-indigo-700">
                                    <svg id="eyeIcon" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"/><circle cx="12" cy="12" r="2.5"/></svg>
                                </button>
                            </div>
                            @error('password')<p class="mt-2 text-xs font-semibold text-rose-600">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-indigo-600/20 transition hover:-translate-y-0.5 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                            {{ __('student.login.button') }}
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                        </button>

                        <p class="text-center text-sm font-semibold text-slate-500">
                            {{ __('student.login.no_account') }}
                            <a href="{{ route('student.register') }}" class="font-extrabold text-indigo-600 hover:text-indigo-800">
                                {{ __('student.login.register_link') }}
                            </a>
                        </p>
                    </form>

                    <div class="mt-7 flex items-center justify-center gap-2 border-t border-slate-100 pt-5 text-[11px] font-semibold text-slate-400">
                        <svg class="h-3.5 w-3.5 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="5" y="10" width="14" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                        {{ __('student.login.protected_connection') }}
                    </div>
                </section>

                <div class="mt-6 flex flex-wrap items-center justify-center gap-x-2 gap-y-1 text-center text-xs font-semibold text-slate-400">
                    <span>© {{ date('Y') }} {{ __('student.common.university') }}</span>
                    <span class="hidden h-1 w-1 rounded-full bg-slate-300 sm:block" aria-hidden="true"></span>
                    <span>
                        {{ __('student.common.developed_by') }}
                        <a href="https://www.bunli-it.site/" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 text-sm font-black tracking-wide text-indigo-600 transition hover:text-indigo-800">
                            SEM BUNLY
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 4h5v5M14 10l6-6M20 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h5"/></svg>
                        </a>
                    </span>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const password = document.getElementById('password');
            const toggle = document.getElementById('togglePassword');
            const loader = document.getElementById('pageLoader');

            toggle?.addEventListener('click', () => {
                password.type = password.type === 'password' ? 'text' : 'password';
            });

            document.querySelectorAll('[data-language-link]').forEach((link) => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();
                    loader?.classList.remove('invisible', 'opacity-0');
                    loader?.classList.add('visible', 'opacity-100');
                    window.setTimeout(() => window.location.assign(link.href), 300);
                });
            });
        });
    </script>
</body>
</html>

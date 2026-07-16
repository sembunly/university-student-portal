<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('student.login.title') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 {{ app()->isLocale('en') ? 'font-en' : 'font-sans' }} text-slate-800 antialiased">
    @include('student.partials.page-loader')

    <main class="relative grid min-h-screen place-items-center overflow-hidden px-4 py-10 sm:px-6">
        <div class="pointer-events-none absolute -left-24 -top-24 h-80 w-80 rounded-full bg-blue-200/50 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-28 -right-20 h-96 w-96 rounded-full bg-cyan-100/70 blur-3xl"></div>

        <div class="relative w-full max-w-lg">
            <!-- <div class="mb-4 flex justify-end">
                <div class="flex rounded-xl border border-slate-200 bg-white p-1 shadow-sm">
                    <a href="{{ route('language.switch', 'km') }}" lang="km" data-language-link
                        class="rounded-lg px-3 py-1.5 text-xs font-extrabold transition {{ app()->isLocale('km') ? 'bg-blue-700 text-white' : 'text-slate-500 hover:text-blue-700' }}">ខ្មែរ</a>
                    <a href="{{ route('language.switch', 'en') }}" lang="en" data-language-link
                        class="rounded-lg px-3 py-1.5 text-xs font-extrabold transition {{ app()->isLocale('en') ? 'bg-blue-700 text-white' : 'text-slate-500 hover:text-blue-700' }}">EN</a>
                </div>
            </div> -->

            <section class="overflow-hidden rounded-3xl border border-white/80 bg-white/95 shadow-2xl shadow-blue-950/10 backdrop-blur">
                <div class="bg-gradient-to-br from-blue-800 via-blue-700 to-cyan-600 px-6 py-8 text-white sm:px-9">
                    <div class="flex items-center gap-4">
                        <div class="grid h-16 w-16 shrink-0 place-items-center rounded-2xl bg-white/15 ring-1 ring-white/25">
                            <svg class="h-9 w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-black sm:text-3xl">{{ __('student.login.title') }}</h1>
                            <p class="mt-1 text-sm font-semibold text-blue-100">{{ __('student.login.subtitle') }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('student.login.attempt') }}" method="POST" class="space-y-5 p-6 sm:p-9">
                    @csrf

                    <div>
                        <label for="login" class="text-sm font-extrabold text-slate-700">{{ __('student.login.identifier') }} <span class="text-red-500">*</span></label>
                        <div class="relative mt-2">
                            <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="11" r="2"/><path d="M14 10h4M14 14h4"/></svg>
                            <input id="login" name="login" value="{{ old('login') }}" autocomplete="username" autofocus required
                                placeholder="{{ __('student.login.identifier_placeholder') }}"
                                class="w-full rounded-xl border bg-white py-3.5 pl-12 pr-4 text-sm font-bold outline-none transition placeholder:font-normal placeholder:text-slate-400 focus:ring-4 {{ $errors->has('login') ? 'border-red-400 focus:border-red-500 focus:ring-red-100' : 'border-slate-200 focus:border-blue-500 focus:ring-blue-100' }}">
                        </div>
                        @error('login')<p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password" class="text-sm font-extrabold text-slate-700">{{ __('student.login.password') }} <span class="text-red-500">*</span></label>
                        <div class="relative mt-2">
                            <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="10" width="14" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                placeholder="{{ __('student.login.password_placeholder') }}"
                                class="w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-12 pr-12 text-sm font-bold outline-none transition placeholder:font-normal placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                            <button id="togglePassword" type="button" aria-label="{{ __('student.login.show_password') }}" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-blue-700">
                                <svg id="eyeIcon" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"/><circle cx="12" cy="12" r="2.5"/></svg>
                            </button>
                        </div>
                        @error('password')<p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-900 px-5 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-blue-900/20 transition hover:-translate-y-0.5 hover:bg-blue-800">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 17l5-5-5-5M15 12H3M14 4h5a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-5"/></svg>
                        {{ __('student.login.button') }}
                    </button>

                    <div class="rounded-2xl border border-blue-100 bg-blue-50/70 p-4 text-xs leading-6 text-slate-600">
                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h.01"/></svg>
                            <p>{{ __('student.login.note') }}</p>
                        </div>
                    </div>

                    <p class="text-center text-sm font-semibold text-slate-600">
                        {{ __('student.login.no_account') }}
                        <a href="{{ route('student.register') }}" class="font-extrabold text-blue-700 hover:text-blue-900">
                            {{ __('student.login.register_link') }}
                        </a>
                    </p>
                </form>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const password = document.getElementById('password');
            const toggle = document.getElementById('togglePassword');
            const loader = document.getElementById('pageLoader');

            toggle.addEventListener('click', () => {
                password.type = password.type === 'password' ? 'text' : 'password';
            });

            document.querySelectorAll('[data-language-link]').forEach((link) => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();
                    loader.classList.remove('invisible', 'opacity-0');
                    loader.classList.add('visible', 'opacity-100');
                    window.setTimeout(() => window.location.assign(link.href), 500);
                });
            });
        });
    </script>
</body>
</html>

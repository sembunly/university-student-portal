<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ផ្ទាំងព័ត៌មាននិស្សិត') | {{ config('app.name', 'សាកលវិទ្យាល័យ') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-slate-50 {{ app()->isLocale('en') ? 'font-en' : 'font-sans' }} text-slate-800 antialiased">
    @include('student.partials.page-loader')

    <div class="min-h-screen lg:flex">
        <button id="sidebarOverlay" type="button" aria-label="បិទម៉ឺនុយ"
            class="fixed inset-0 z-40 hidden bg-slate-950/40 backdrop-blur-[1px] lg:hidden"></button>

        @include('student.partials.sidebar')

        <main class="min-w-0 flex-1">
            @include('student.partials.header')

            <div class="mx-auto max-w-[1500px] space-y-5 p-4 sm:p-6 lg:p-8">
                @if(session('success'))
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')

                @include('student.partials.footer')
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('studentSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const openButton = document.getElementById('openSidebar');
            const closeButton = document.getElementById('closeSidebar');

            if (!sidebar || !overlay || !openButton || !closeButton) return;

            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                openButton.setAttribute('aria-expanded', 'true');
                document.body.classList.add('overflow-hidden');
            };

            const closeSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                openButton.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('overflow-hidden');
            };

            openButton.addEventListener('click', openSidebar);
            closeButton.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);
            window.addEventListener('keydown', (event) => event.key === 'Escape' && closeSidebar());
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    openButton.setAttribute('aria-expanded', 'false');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loader = document.getElementById('pageLoader');
            const minimumLoadingTime = 500;
            let isNavigating = false;

            if (!loader) return;

            const showLoader = () => {
                loader.classList.remove('invisible', 'opacity-0');
                loader.classList.add('visible', 'opacity-100');
                loader.setAttribute('aria-hidden', 'false');
                document.body.classList.add('overflow-hidden');
            };

            const hideLoader = () => {
                loader.classList.add('invisible', 'opacity-0');
                loader.classList.remove('visible', 'opacity-100');
                loader.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
                isNavigating = false;
            };

            document.addEventListener('click', (event) => {
                const link = event.target.closest('a[href]');

                if (!link || isNavigating || link.hasAttribute('download') || link.dataset.noLoader !== undefined) return;
                if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
                if (link.target && link.target !== '_self') return;

                const destination = new URL(link.href, window.location.href);
                const samePageHash = destination.pathname === window.location.pathname
                    && destination.search === window.location.search
                    && destination.hash;

                if (destination.origin !== window.location.origin || samePageHash || link.getAttribute('href') === '#') return;

                event.preventDefault();
                isNavigating = true;
                showLoader();

                window.setTimeout(() => {
                    window.location.assign(destination.href);
                }, minimumLoadingTime);
            });

            window.addEventListener('pageshow', hideLoader);
        });
    </script>
    @stack('scripts')
</body>
</html>

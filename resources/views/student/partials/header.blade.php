<header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white/90 px-4 backdrop-blur sm:px-6 lg:px-8">
    <div class="flex items-center gap-3">
        <button id="openSidebar" type="button" aria-label="{{ __('student.common.open_menu') }}" aria-controls="studentSidebar" aria-expanded="false"
            class="rounded-xl border border-slate-200 p-2 text-slate-600 hover:bg-slate-50 lg:hidden">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <div>
            <p class="text-xs font-semibold text-slate-400">{{ __('student.common.system_name') }}</p>
            <h1 class="text-base font-extrabold text-slate-900">@yield('page-heading', __('student.pages.dashboard'))</h1>
        </div>
    </div>

    <div class="flex items-center gap-2">
        <div class="flex rounded-xl border border-slate-200 bg-slate-50 p-1" aria-label="{{ __('student.common.language') }}">
            <a href="{{ route('language.switch', 'km') }}" lang="km"
                class="rounded-lg px-2.5 py-1.5 text-xs font-extrabold transition {{ app()->isLocale('km') ? 'bg-blue-700 text-white shadow-sm' : 'text-slate-500 hover:text-blue-700' }}">ខ្មែរ</a>
            <a href="{{ route('language.switch', 'en') }}" lang="en"
                class="rounded-lg px-2.5 py-1.5 text-xs font-extrabold transition {{ app()->isLocale('en') ? 'bg-blue-700 text-white shadow-sm' : 'text-slate-500 hover:text-blue-700' }}">EN</a>
        </div>
        <button type="button" aria-label="{{ __('student.common.notifications') }}" class="relative hidden rounded-xl border border-slate-200 p-2.5 text-slate-600 transition hover:bg-slate-50 sm:block">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg>
            <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
        </button>
        <div class="hidden text-right sm:block">
            <p class="text-sm font-bold text-slate-800">{{ app()->isLocale('en') ? $student['name_en'] : $student['name_km'] }}</p>
            <p class="text-xs text-slate-500">{{ __('student.STUDENT') }}</p>
        </div>
    </div>
</header>

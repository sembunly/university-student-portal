@php
    $localizedStudentName = app()->isLocale('en') ? data_get($student, 'name_en') : data_get($student, 'name_km');
    $studentDisplayName = filled($localizedStudentName)
        ? $localizedStudentName
        : (data_get($student, 'student_id') !== '—' ? data_get($student, 'student_id') : data_get($student, 'phone'));
@endphp

<header class="sticky top-0 z-30 flex h-[72px] items-center justify-between border-b border-slate-200/70 bg-white/85 px-4 backdrop-blur-xl sm:px-6 lg:px-8 xl:px-9">
    <div class="flex items-center gap-3">
        <button id="openSidebar" type="button" aria-label="{{ __('student.common.open_menu') }}" aria-controls="studentSidebar" aria-expanded="false"
            class="rounded-xl border border-slate-200 bg-white p-2.5 text-slate-600 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700 lg:hidden">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <div>
            <div class="flex items-center gap-1.5 text-[11px] font-bold text-slate-400">
                <span>{{ __('student.common.portal') }}</span>
                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                <span class="text-indigo-500">{{ __('student.common.student') }}</span>
            </div>
            <h1 class="mt-0.5 text-base font-black text-slate-900">@yield('page-heading', __('student.pages.dashboard'))</h1>
        </div>
    </div>

    <div class="flex items-center gap-2">
        <div class="flex rounded-xl border border-slate-200 bg-slate-100/70 p-1" aria-label="{{ __('student.common.language') }}">
            <a href="{{ route('language.switch', 'km') }}" lang="km"
                class="rounded-lg px-2.5 py-1.5 text-xs font-extrabold transition {{ app()->isLocale('km') ? 'bg-white text-indigo-700 shadow-sm ring-1 ring-slate-200/60' : 'text-slate-500 hover:text-indigo-700' }}">ខ្មែរ</a>
            <a href="{{ route('language.switch', 'en') }}" lang="en"
                class="rounded-lg px-2.5 py-1.5 text-xs font-extrabold transition {{ app()->isLocale('en') ? 'bg-white text-indigo-700 shadow-sm ring-1 ring-slate-200/60' : 'text-slate-500 hover:text-indigo-700' }}">EN</a>
        </div>
        <button type="button" aria-label="{{ __('student.common.notifications') }}" class="relative hidden rounded-xl border border-slate-200 bg-white p-2.5 text-slate-500 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700 sm:block">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg>
            <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
        </button>
        <div class="hidden items-center gap-3 pl-1 md:flex">
            <div class="text-right">
                <p class="max-w-40 truncate text-sm font-extrabold text-slate-800">{{ $studentDisplayName }}</p>
                <p class="text-[11px] font-semibold text-slate-400">{{ __('student.STUDENT') }}</p>
            </div>
            <div class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-sm font-black text-white shadow-md shadow-indigo-500/20">
                {{ mb_substr($studentDisplayName, 0, 1) }}
            </div>
        </div>
    </div>
</header>

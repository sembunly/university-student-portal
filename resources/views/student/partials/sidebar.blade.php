@php
    $localizedStudentName = app()->isLocale('en') ? data_get($student, 'name_en') : data_get($student, 'name_km');
    $studentDisplayName = filled($localizedStudentName)
        ? $localizedStudentName
        : (data_get($student, 'student_id') !== '—' ? data_get($student, 'student_id') : data_get($student, 'phone'));
@endphp

<aside id="studentSidebar"
    class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200/70 bg-white transition-transform duration-300 lg:sticky lg:top-0 lg:h-screen lg:w-[292px] lg:translate-x-0">
    <div class="flex h-[92px] items-center gap-3 px-5">
        <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-indigo-500 via-indigo-600 to-violet-700 text-white shadow-lg shadow-indigo-600/20">
            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path d="M3 8.5 12 4l9 4.5-9 4.5-9-4.5Z"/>
                <path d="M7 10.5V15c2.6 2 7.4 2 10 0v-4.5M21 9v6"/>
            </svg>
        </div>
        <div class="min-w-0">
            <p class="truncate text-base font-black text-slate-900">{{ __('student.common.university') }}</p>
            <p class="mt-0.5 text-[10px] font-extrabold uppercase tracking-[.18em] text-indigo-500">{{ __('student.common.portal') }}</p>
        </div>
        <button id="closeSidebar" type="button" aria-label="{{ __('student.common.close_menu') }}"
            class="ml-auto rounded-lg p-2 text-slate-500 hover:bg-slate-100 lg:hidden">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 6 12 12M18 6 6 18"/></svg>
        </button>
    </div>

    <!-- <div class="mx-4 mb-6 flex items-center gap-3 rounded-2xl border border-slate-200/80 bg-slate-50/80 p-3">
        @if(!empty($student['avatar']))
            <img src="{{ $student['avatar'] }}" alt="{{ __('student.common.photo_of', ['name' => $studentDisplayName]) }}"
                class="h-12 w-12 rounded-xl object-cover ring-2 ring-white">
        @else
            <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-indigo-100 text-lg font-black text-indigo-700 ring-2 ring-white">
                {{ mb_substr($studentDisplayName, 0, 1) }}
            </div>
        @endif
        <div class="min-w-0">
            <p class="truncate text-sm font-black text-slate-900">{{ $studentDisplayName }}</p>
            <p class="mt-1 text-xs font-semibold text-slate-400">{{ $student['student_id'] }}</p>
        </div>
    </div> -->

    @php
        $studentMenu = [
            ['label' => __('student.nav.home'), 'href' => route('student.dashboard'), 'icon' => 'home', 'active' => request()->routeIs('student.dashboard')],
            ['label' => __('student.nav.personal_information'), 'href' => route('student.information.show'), 'icon' => 'user', 'active' => request()->routeIs('student.information.*')],
            ['label' => __('student.nav.curriculum'), 'href' => route('student.curriculum'), 'icon' => 'curriculum', 'active' => request()->routeIs('student.curriculum')],
        ];
    @endphp

    <nav class="flex-1 space-y-1.5 overflow-y-auto px-4 pb-5" aria-label="{{ __('student.common.student_menu') }}">
        <p class="mb-3 px-3 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">{{ __('student.common.student_menu') }}</p>
        @foreach($studentMenu as $item)
            <a href="{{ $item['href'] }}" @if(!empty($item['active'])) aria-current="page" @endif
                class="group relative flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-extrabold transition
                    {{ !empty($item['active']) ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                @if(!empty($item['active']))
                    <span class="absolute -left-4 h-6 w-1 rounded-r-full bg-indigo-600" aria-hidden="true"></span>
                @endif
                @if($item['icon'] === 'home')
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 11 9-8 9 8"/><path d="M5 10v10h14V10M9 20v-6h6v6"/></svg>
                @elseif($item['icon'] === 'user')
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                @elseif($item['icon'] === 'curriculum')
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H11v16H6.5A2.5 2.5 0 0 0 4 21.5Z"/><path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H13v16h4.5a2.5 2.5 0 0 1 2.5 2.5Z"/></svg>
                @elseif($item['icon'] === 'eye')
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"/><circle cx="12" cy="12" r="2.5"/></svg>
                @elseif($item['icon'] === 'history')
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5M12 7v5l3 2"/></svg>
                @else
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h10M18 7h2M4 17h2M10 17h10"/><circle cx="16" cy="7" r="2"/><circle cx="8" cy="17" r="2"/></svg>
                @endif
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    <div class="border-t border-slate-100 p-4">
        <form action="{{ route('student.logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-extrabold text-slate-700 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 17l5-5-5-5M15 12H3M14 4h5a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-5"/></svg>
                {{ __('student.common.logout') }}
            </button>
        </form>
    </div>
</aside>

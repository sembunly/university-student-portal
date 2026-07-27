@extends('layouts.student')

@section('title', __('student.pages.dashboard'))
@section('page-heading', __('student.pages.dashboard'))

@section('content')
    @php
        $hasRegistration = $hasRegistration ?? false;
        $profileCompletion = min(100, max(0, $profileCompletion ?? 0));
        $informationRoute = $hasRegistration
            ? route('student.information.show')
            : route('student.information.edit');
        $localizedName = app()->isLocale('en') ? $student['name_en'] : $student['name_km'];
        $dashboardName = filled($localizedName)
            ? $localizedName
            : ($student['student_id'] !== '—' ? $student['student_id'] : $student['phone']);

        $summaryCards = [
            ['label' => __('student.dashboard.student_id'), 'value' => $student['student_id'], 'tone' => 'indigo', 'icon' => 'id'],
            ['label' => __('student.dashboard.phone'), 'value' => $student['phone'], 'tone' => 'sky', 'icon' => 'phone'],
            ['label' => __('student.dashboard.email'), 'value' => $student['email'], 'tone' => 'amber', 'icon' => 'mail'],
            ['label' => __('student.dashboard.profile_status'), 'value' => $profileCompletion.'%', 'tone' => 'emerald', 'icon' => 'status'],
        ];

        $personalInformation = [
            __('student.dashboard.name_km') => $student['name_km'],
            __('student.dashboard.name_en') => $student['name_en'],
            __('student.dashboard.student_id') => $student['student_id'],
            __('student.dashboard.date_of_birth') => $student['date_of_birth'],
            __('student.dashboard.gender') => $student['gender'],
            __('student.dashboard.nationality') => $student['nationality'],
            __('student.dashboard.phone') => $student['phone'],
            __('student.dashboard.email') => $student['email'],
        ];
    @endphp

    <section class="dashboard-hero relative isolate overflow-hidden rounded-[2rem] bg-slate-950 px-5 py-6 text-white shadow-[0_24px_60px_-28px_rgba(15,23,42,.75)] sm:px-8 sm:py-8 xl:px-10">
        <div class="absolute -right-16 -top-24 h-72 w-72 rounded-full bg-indigo-500/30 blur-3xl" aria-hidden="true"></div>
        <div class="absolute -bottom-28 left-1/3 h-64 w-64 rounded-full bg-cyan-400/20 blur-3xl" aria-hidden="true"></div>
        <div class="dashboard-grid absolute inset-0 opacity-30" aria-hidden="true"></div>

        <div class="relative grid items-center gap-8 lg:grid-cols-[minmax(0,1fr)_260px]">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-3 py-1.5 text-xs font-bold text-slate-200 backdrop-blur">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 shadow-[0_0_0_4px_rgba(52,211,153,.12)]"></span>
                    {{ __('student.dashboard.portal_ready') }}
                </div>
                <p class="mt-6 text-sm font-bold text-indigo-200">{{ __('student.dashboard.welcome') }}</p>
                <h2 class="mt-2 text-2xl font-black leading-relaxed tracking-tight sm:text-4xl">
                    {{ __('student.dashboard.greeting', ['name' => $dashboardName]) }}
                </h2>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-300 sm:text-base">
                    <!-- {{ $hasRegistration
                        ? __('student.dashboard.registered_message')
                        : __('student.dashboard.unregistered_message') }}
                </p> -->
                <div class="mt-7 flex flex-wrap items-center gap-3">
                    <a href="{{ $informationRoute }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-extrabold text-slate-950 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:bg-indigo-50 focus:outline-none focus:ring-4 focus:ring-white/20">
                        {{ $hasRegistration ? __('student.dashboard.view_profile') : __('student.dashboard.register_profile') }}
                        <svg class="h-4 w-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" aria-hidden="true">
                            <path d="m9 18 6-6-6-6"/>
                        </svg>
                    </a>
                    <span class="inline-flex items-center gap-2 px-1 text-xs font-semibold text-slate-300">
                        <svg class="h-4 w-4 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                        {{ __('student.dashboard.secure_note') }}
                    </span>
                </div>
            </div>

            <div class="mx-auto flex w-full max-w-[260px] items-center gap-5 rounded-3xl border border-white/10 bg-white/[.08] p-5 backdrop-blur-md lg:block lg:text-center">
                <div class="profile-ring mx-auto grid h-28 w-28 shrink-0 place-items-center rounded-full"
                    style="--progress: {{ $profileCompletion * 3.6 }}deg"
                    role="progressbar"
                    aria-label="{{ __('student.dashboard.completion') }}"
                    aria-valuenow="{{ $profileCompletion }}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    <div class="grid h-[88px] w-[88px] place-items-center rounded-full bg-slate-950/90">
                        <span class="text-2xl font-black">{{ $profileCompletion }}<span class="text-sm text-indigo-200">%</span></span>
                    </div>
                </div>
                <div class="lg:mt-4">
                    <p class="text-sm font-extrabold">{{ __('student.dashboard.completion') }}</p>
                    <p class="mt-1 text-xs leading-5 text-slate-300">
                        {{ $profileCompletion === 100
                            ? __('student.dashboard.complete')
                            : __('student.dashboard.keep_going') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-4 sm:grid-cols-2 2xl:grid-cols-4" aria-label="{{ __('student.dashboard.summary') }}">
        @foreach($summaryCards as $item)
            @php
                $toneClasses = [
                    'indigo' => 'bg-indigo-50 text-indigo-600 ring-indigo-100',
                    'sky' => 'bg-sky-50 text-sky-600 ring-sky-100',
                    'amber' => 'bg-amber-50 text-amber-600 ring-amber-100',
                    'emerald' => 'bg-emerald-50 text-emerald-600 ring-emerald-100',
                ];
            @endphp
            <article class="group rounded-2xl border border-slate-200/80 bg-white p-4 shadow-[0_8px_30px_-20px_rgba(15,23,42,.45)] transition duration-300 hover:-translate-y-1 hover:border-indigo-200 hover:shadow-[0_18px_38px_-22px_rgba(79,70,229,.35)] sm:p-5">
                <div class="flex items-center gap-4">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl ring-1 {{ $toneClasses[$item['tone']] }} transition duration-300 group-hover:scale-105">
                        @if($item['icon'] === 'id')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="11" r="2"/><path d="M6 16c.8-2 5.2-2 6 0M14 10h4M14 14h4"/></svg>
                        @elseif($item['icon'] === 'phone')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 2h4l2 5-3 2a15 15 0 0 0 6 6l2-3 5 2v4a4 4 0 0 1-4 4C9.2 22 2 14.8 2 6a4 4 0 0 1 4-4Z"/></svg>
                        @elseif($item['icon'] === 'mail')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                        @else
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 19V9M10 19V5M16 19v-7M22 19H2"/></svg>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="truncate text-xs font-bold text-slate-400">{{ $item['label'] }}</p>
                        <p class="mt-1 truncate text-base font-black text-slate-900" title="{{ $item['value'] }}">{{ $item['value'] }}</p>
                    </div>
                </div>
            </article>
        @endforeach
    </section>

    <section class="grid items-start gap-5 xl:grid-cols-[minmax(0,1.45fr)_minmax(310px,.65fr)]">
        <article id="student-information" class="scroll-mt-24 overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white shadow-[0_12px_35px_-25px_rgba(15,23,42,.4)]">
            <header class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-5 sm:px-7">
                <div class="flex items-center gap-3">
                    <div class="grid h-11 w-11 place-items-center rounded-2xl bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900">{{ __('student.dashboard.personal_information') }}</h3>
                        <p class="mt-0.5 text-xs font-medium text-slate-400">{{ __('student.dashboard.personal_subtitle') }}</p>
                    </div>
                </div>
                <a href="{{ route('student.information.edit') }}"
                    class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-extrabold text-slate-700 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/></svg>
                    {{ $hasRegistration ? __('student.dashboard.edit') : __('student.dashboard.register') }}
                </a>
            </header>

            @if($hasRegistration)
                <dl class="grid sm:grid-cols-2">
                    @foreach($personalInformation as $label => $value)
                        <div class="border-b border-slate-100 px-5 py-4 last:border-b-0 sm:px-7 sm:[&:nth-last-child(-n+2)]:border-b-0 sm:[&:nth-child(odd)]:border-r">
                            <dt class="text-xs font-bold text-slate-400">{{ $label }}</dt>
                            <dd class="mt-1.5 break-words text-sm font-extrabold text-slate-800">{{ filled($value) ? $value : '—' }}</dd>
                        </div>
                    @endforeach
                </dl>
            @else
                <div class="px-5 py-10 text-center sm:px-7">
                    <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-indigo-50 text-indigo-600">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/></svg>
                    </div>
                    <h3 class="mt-4 font-black text-slate-900">{{ __('student.dashboard.no_information') }}</h3>
                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">{{ __('student.dashboard.no_information_help') }}</p>
                    <a href="{{ route('student.information.edit') }}" class="mt-5 inline-flex rounded-xl bg-indigo-600 px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-indigo-600/20 transition hover:-translate-y-0.5 hover:bg-indigo-700">
                        {{ __('student.dashboard.register_now') }}
                    </a>
                </div>
            @endif
        </article>

        <div class="space-y-5">
            <article class="rounded-[1.75rem] border border-slate-200/80 bg-white p-5 shadow-[0_12px_35px_-25px_rgba(15,23,42,.4)] sm:p-6">
                <div class="flex items-start gap-4">
                    <div class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-amber-50 text-amber-600 ring-1 ring-amber-100">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-wider text-amber-600">{{ __('student.dashboard.location') }}</p>
                        <h3 class="mt-1 font-black text-slate-900">{{ __('student.dashboard.current_address') }}</h3>
                        <p class="mt-3 break-words text-sm leading-7 text-slate-500">{{ $student['address'] }}</p>
                    </div>
                </div>
            </article>

            <article class="rounded-[1.75rem] border border-indigo-100 bg-indigo-50/70 p-5 sm:p-6">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-indigo-500">{{ __('student.dashboard.next_step') }}</p>
                        <h3 class="mt-1 font-black text-slate-900">
                            {{ $hasRegistration ? __('student.dashboard.review_profile') : __('student.dashboard.finish_profile') }}
                        </h3>
                    </div>
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-white text-indigo-600 shadow-sm">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                    </span>
                </div>
                <p class="mt-3 text-sm leading-6 text-slate-500">{{ __('student.dashboard.next_step_help') }}</p>
                <a href="{{ $informationRoute }}" class="mt-4 inline-flex items-center gap-2 text-sm font-extrabold text-indigo-700 hover:text-indigo-900">
                    {{ __('student.dashboard.continue') }}
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </article>
        </div>
    </section>
@endsection

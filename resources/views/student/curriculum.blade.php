@extends('layouts.student')

@section('title', __('student.pages.curriculum'))
@section('page-heading', __('student.pages.curriculum'))

@section('content')
    @php
        $currentSemester = 6;
        $totalSemesters = 8;
        $programProgress = (int) round(($currentSemester / $totalSemesters) * 100);
        $programDetails = [
            [
                'label' => __('student.curriculum.duration'),
                'value' => __('student.curriculum.duration_value'),
                'tone' => 'indigo',
                'icon' => 'calendar',
            ],
            [
                'label' => __('student.curriculum.semesters'),
                'value' => __('student.curriculum.semesters_value'),
                'tone' => 'sky',
                'icon' => 'layers',
            ],
            [
                'label' => __('student.curriculum.credits'),
                'value' => __('student.curriculum.credits_value'),
                'tone' => 'amber',
                'icon' => 'award',
            ],
            [
                'label' => __('student.curriculum.status'),
                'value' => __('student.curriculum.status_value'),
                'tone' => 'emerald',
                'icon' => 'status',
            ],
        ];
        $semesterSubjects = [
            1 => [
                ['code' => 'SE101', 'name' => __('student.curriculum.subjects.programming_fundamentals'), 'credits' => 4],
                ['code' => 'SE102', 'name' => __('student.curriculum.subjects.computer_mathematics'), 'credits' => 4],
                ['code' => 'SE103', 'name' => __('student.curriculum.subjects.it_essentials'), 'credits' => 4],
                ['code' => 'GE101', 'name' => __('student.curriculum.subjects.academic_english'), 'credits' => 4],
            ],
            2 => [
                ['code' => 'SE111', 'name' => __('student.curriculum.subjects.object_oriented_java'), 'credits' => 4],
                ['code' => 'SE112', 'name' => __('student.curriculum.subjects.web_fundamentals'), 'credits' => 4],
                ['code' => 'SE113', 'name' => __('student.curriculum.subjects.discrete_mathematics'), 'credits' => 4],
                ['code' => 'SE114', 'name' => __('student.curriculum.subjects.data_structures'), 'credits' => 4],
            ],
            3 => [
                ['code' => 'SE201', 'name' => __('student.curriculum.subjects.database_systems'), 'credits' => 4],
                ['code' => 'SE202', 'name' => __('student.curriculum.subjects.frontend_development'), 'credits' => 4],
                ['code' => 'SE203', 'name' => __('student.curriculum.subjects.algorithms'), 'credits' => 4],
                ['code' => 'SE204', 'name' => __('student.curriculum.subjects.software_engineering'), 'credits' => 4],
            ],
            4 => [
                ['code' => 'SE211', 'name' => __('student.curriculum.subjects.backend_development'), 'credits' => 4],
                ['code' => 'SE212', 'name' => __('student.curriculum.subjects.rest_api_design'), 'credits' => 4],
                ['code' => 'SE213', 'name' => __('student.curriculum.subjects.operating_systems'), 'credits' => 4],
                ['code' => 'SE214', 'name' => __('student.curriculum.subjects.ui_ux_design'), 'credits' => 4],
            ],
            5 => [
                ['code' => 'SE301', 'name' => __('student.curriculum.subjects.advanced_java'), 'credits' => 4],
                ['code' => 'SE302', 'name' => __('student.curriculum.subjects.spring_boot'), 'credits' => 4],
                ['code' => 'SE303', 'name' => __('student.curriculum.subjects.mobile_development'), 'credits' => 4],
                ['code' => 'SE304', 'name' => __('student.curriculum.subjects.software_testing'), 'credits' => 4],
            ],
            6 => [
                ['code' => 'SE311', 'name' => __('student.curriculum.subjects.full_stack_development'), 'credits' => 4],
                ['code' => 'SE312', 'name' => __('student.curriculum.subjects.advanced_databases'), 'credits' => 4],
                ['code' => 'SE313', 'name' => __('student.curriculum.subjects.cloud_devops'), 'credits' => 4],
                ['code' => 'SE314', 'name' => __('student.curriculum.subjects.software_security'), 'credits' => 4],
            ],
            7 => [
                ['code' => 'SE401', 'name' => __('student.curriculum.subjects.microservices'), 'credits' => 4],
                ['code' => 'SE402', 'name' => __('student.curriculum.subjects.software_architecture'), 'credits' => 4],
                ['code' => 'SE403', 'name' => __('student.curriculum.subjects.agile_project_management'), 'credits' => 4],
                ['code' => 'SE404', 'name' => __('student.curriculum.subjects.research_methods'), 'credits' => 4],
            ],
            8 => [
                ['code' => 'SE411', 'name' => __('student.curriculum.subjects.capstone_project'), 'credits' => 4],
                ['code' => 'SE412', 'name' => __('student.curriculum.subjects.internship'), 'credits' => 4],
                ['code' => 'SE413', 'name' => __('student.curriculum.subjects.emerging_technologies'), 'credits' => 4],
                ['code' => 'GE401', 'name' => __('student.curriculum.subjects.professional_ethics'), 'credits' => 4],
            ],
        ];
    @endphp

    <section class="relative isolate overflow-hidden rounded-[2rem] bg-gradient-to-br from-indigo-950 via-indigo-900 to-violet-900 px-5 py-7 text-white shadow-[0_24px_60px_-28px_rgba(49,46,129,.75)] sm:px-8 sm:py-9 xl:px-10">
        <div class="dashboard-grid absolute inset-0 opacity-30" aria-hidden="true"></div>
        <div class="absolute -right-16 -top-24 h-72 w-72 rounded-full bg-violet-400/25 blur-3xl" aria-hidden="true"></div>
        <div class="absolute -bottom-28 left-1/3 h-64 w-64 rounded-full bg-cyan-400/15 blur-3xl" aria-hidden="true"></div>

        <div class="relative grid items-center gap-8 lg:grid-cols-[minmax(0,1fr)_280px]">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-3 py-1.5 text-xs font-extrabold text-indigo-100 backdrop-blur">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H11v16H6.5A2.5 2.5 0 0 0 4 21.5Z"/><path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H13v16h4.5a2.5 2.5 0 0 1 2.5 2.5Z"/></svg>
                    {{ __('student.curriculum.eyebrow') }}
                </div>
                <p class="mt-6 text-sm font-bold text-indigo-200">{{ __('student.curriculum.degree') }}</p>
                <h2 class="mt-2 text-3xl font-black leading-tight tracking-tight sm:text-4xl xl:text-5xl">
                    {{ __('student.curriculum.major') }}
                </h2>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-indigo-100/80 sm:text-base">
                    {{ __('student.curriculum.description') }}
                </p>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/[.08] p-5 backdrop-blur-md">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-indigo-200">{{ __('student.curriculum.progress') }}</p>
                        <p class="mt-2 text-3xl font-black">{{ $programProgress }}%</p>
                    </div>
                    <div class="grid h-12 w-12 place-items-center rounded-2xl bg-emerald-400/15 text-emerald-300 ring-1 ring-emerald-300/20">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 19V9M10 19V5M16 19v-7M22 19H2"/></svg>
                    </div>
                </div>
                <div class="mt-5 h-2 overflow-hidden rounded-full bg-white/10">
                    <div class="h-full rounded-full bg-gradient-to-r from-cyan-300 to-emerald-300" style="width: {{ $programProgress }}%"></div>
                </div>
                <p class="mt-3 text-xs leading-5 text-indigo-100/70">{{ __('student.curriculum.progress_help') }}</p>
            </div>
        </div>
    </section>

    <section class="grid gap-4 sm:grid-cols-2 2xl:grid-cols-4" aria-label="{{ __('student.pages.curriculum') }}">
        @foreach($programDetails as $detail)
            @php
                $toneClasses = [
                    'indigo' => 'bg-indigo-50 text-indigo-600 ring-indigo-100',
                    'sky' => 'bg-sky-50 text-sky-600 ring-sky-100',
                    'amber' => 'bg-amber-50 text-amber-600 ring-amber-100',
                    'emerald' => 'bg-emerald-50 text-emerald-600 ring-emerald-100',
                ];
            @endphp
            <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-[0_8px_30px_-20px_rgba(15,23,42,.45)] transition duration-300 hover:-translate-y-1 hover:border-indigo-200">
                <div class="flex items-center gap-4">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl ring-1 {{ $toneClasses[$detail['tone']] }}">
                        @if($detail['icon'] === 'calendar')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/></svg>
                        @elseif($detail['icon'] === 'layers')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m12 2 9 5-9 5-9-5 9-5Z"/><path d="m3 12 9 5 9-5M3 17l9 5 9-5"/></svg>
                        @elseif($detail['icon'] === 'award')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="5"/><path d="m8.5 12-1 9 4.5-2 4.5 2-1-9"/></svg>
                        @else
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-slate-400">{{ $detail['label'] }}</p>
                        <p class="mt-1 text-sm font-black text-slate-900">{{ $detail['value'] }}</p>
                    </div>
                </div>
            </article>
        @endforeach
    </section>

    <section class="overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white shadow-[0_12px_35px_-25px_rgba(15,23,42,.4)]">
        <header class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 px-5 py-5 sm:px-7">
            <div>
                <h3 class="font-black text-slate-900">{{ __('student.curriculum.roadmap') }}</h3>
                <p class="mt-1 text-xs font-medium text-slate-400">{{ __('student.curriculum.roadmap_help') }}</p>
            </div>
            <div class="rounded-xl bg-slate-50 px-3 py-2 text-xs font-extrabold text-slate-500 ring-1 ring-slate-200">
                {{ __('student.curriculum.degree_type') }} · {{ __('student.curriculum.undergraduate') }}
            </div>
        </header>

        <div class="grid gap-4 p-5 sm:grid-cols-2 sm:p-7 xl:grid-cols-4">
            @for($semester = 1; $semester <= $totalSemesters; $semester++)
                @php
                    $year = (int) ceil($semester / 2);
                    $isCompleted = $semester < $currentSemester;
                    $isCurrent = $semester === $currentSemester;
                @endphp
                <article class="relative overflow-hidden rounded-2xl border p-5
                    {{ $isCurrent
                        ? 'border-indigo-300 bg-indigo-50 shadow-lg shadow-indigo-100'
                        : ($isCompleted ? 'border-emerald-100 bg-emerald-50/50' : 'border-slate-200 bg-slate-50/50') }}">
                    @if($isCurrent)
                        <span class="absolute right-0 top-0 h-16 w-16 -translate-y-8 translate-x-8 rounded-full bg-indigo-200/60" aria-hidden="true"></span>
                    @endif
                    <div class="relative flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wider {{ $isCurrent ? 'text-indigo-600' : 'text-slate-400' }}">
                                {{ __('student.curriculum.year', ['year' => $year]) }}
                            </p>
                            <h4 class="mt-2 font-black text-slate-900">{{ __('student.curriculum.semester', ['semester' => $semester]) }}</h4>
                        </div>
                        <div class="grid h-9 w-9 shrink-0 place-items-center rounded-xl
                            {{ $isCurrent ? 'bg-indigo-600 text-white' : ($isCompleted ? 'bg-emerald-100 text-emerald-600' : 'bg-white text-slate-400 ring-1 ring-slate-200') }}">
                            @if($isCompleted)
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
                            @elseif($isCurrent)
                                <span class="h-2.5 w-2.5 rounded-full bg-white ring-4 ring-white/25"></span>
                            @else
                                <span class="text-xs font-black">{{ $semester }}</span>
                            @endif
                        </div>
                    </div>
                    <p class="relative mt-5 text-xs font-extrabold
                        {{ $isCurrent ? 'text-indigo-700' : ($isCompleted ? 'text-emerald-600' : 'text-slate-400') }}">
                        {{ $isCurrent
                            ? __('student.curriculum.current')
                            : ($isCompleted ? __('student.curriculum.completed') : __('student.curriculum.upcoming')) }}
                    </p>
                </article>
            @endfor
        </div>
    </section>

    <section class="overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white shadow-[0_12px_35px_-25px_rgba(15,23,42,.4)]">
        <header class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 px-5 py-5 sm:px-7">
            <div class="flex items-center gap-3">
                <div class="grid h-11 w-11 place-items-center rounded-2xl bg-violet-50 text-violet-600 ring-1 ring-violet-100">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
                </div>
                <div>
                    <h3 class="font-black text-slate-900">{{ __('student.curriculum.subject_plan') }}</h3>
                    <p class="mt-1 text-xs font-medium text-slate-400">{{ __('student.curriculum.subject_plan_help') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 rounded-xl bg-indigo-50 px-3 py-2 text-xs font-extrabold text-indigo-700 ring-1 ring-indigo-100">
                <span>32 {{ __('student.curriculum.subjects_label') }}</span>
                <span class="h-1 w-1 rounded-full bg-indigo-300"></span>
                <span>128 {{ __('student.curriculum.credit_short') }}</span>
            </div>
        </header>

        <div class="grid gap-5 p-5 sm:p-7 xl:grid-cols-2">
            @foreach($semesterSubjects as $semester => $subjects)
                @php
                    $year = (int) ceil($semester / 2);
                    $isCompleted = $semester < $currentSemester;
                    $isCurrent = $semester === $currentSemester;
                    $semesterCredits = collect($subjects)->sum('credits');
                @endphp
                <article class="overflow-hidden rounded-2xl border
                    {{ $isCurrent
                        ? 'border-indigo-300 shadow-lg shadow-indigo-100/70'
                        : ($isCompleted ? 'border-emerald-100' : 'border-slate-200') }}">
                    <header class="flex items-center justify-between gap-4 px-5 py-4
                        {{ $isCurrent ? 'bg-indigo-600 text-white' : ($isCompleted ? 'bg-emerald-50' : 'bg-slate-50') }}">
                        <div>
                            <p class="text-[10px] font-extrabold uppercase tracking-[.16em]
                                {{ $isCurrent ? 'text-indigo-100' : ($isCompleted ? 'text-emerald-600' : 'text-slate-400') }}">
                                {{ __('student.curriculum.year', ['year' => $year]) }}
                            </p>
                            <h4 class="mt-1 font-black {{ $isCurrent ? 'text-white' : 'text-slate-900' }}">
                                {{ __('student.curriculum.semester', ['semester' => $semester]) }}
                            </h4>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-extrabold
                                {{ $isCurrent
                                    ? 'bg-white/15 text-white ring-1 ring-white/20'
                                    : ($isCompleted ? 'bg-emerald-100 text-emerald-700' : 'bg-white text-slate-500 ring-1 ring-slate-200') }}">
                                {{ $isCurrent
                                    ? __('student.curriculum.current')
                                    : ($isCompleted ? __('student.curriculum.completed') : __('student.curriculum.upcoming')) }}
                            </span>
                            <p class="mt-1.5 text-[10px] font-bold {{ $isCurrent ? 'text-indigo-100' : 'text-slate-400' }}">
                                {{ $semesterCredits }} {{ __('student.curriculum.credit_short') }}
                            </p>
                        </div>
                    </header>

                    <div class="divide-y divide-slate-100">
                        @foreach($subjects as $subject)
                            <div class="group flex items-center gap-3 px-5 py-3.5 transition hover:bg-slate-50">
                                <div class="grid h-9 w-9 shrink-0 place-items-center rounded-xl text-[10px] font-black
                                    {{ $isCurrent ? 'bg-indigo-50 text-indigo-600' : 'bg-slate-100 text-slate-500' }}">
                                    {{ str_replace(['SE', 'GE'], '', $subject['code']) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">{{ $subject['code'] }}</p>
                                    <p class="mt-0.5 text-sm font-extrabold text-slate-800">{{ $subject['name'] }}</p>
                                </div>
                                <span class="shrink-0 rounded-lg bg-slate-50 px-2 py-1 text-[10px] font-bold text-slate-400">
                                    {{ $subject['credits'] }} {{ __('student.curriculum.credit_short') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection

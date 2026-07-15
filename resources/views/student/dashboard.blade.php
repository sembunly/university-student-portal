@extends('layouts.student')

@section('title', __('student.pages.dashboard'))
@section('page-heading', __('student.pages.dashboard'))

@section('content')
    @php
        $student = $student ?? [
            'name_km' => 'Your Name',
            'name_en' => 'SEM BUNLY',
            'student_id' => '00058475',
            'phone' => '010 800 921',
            'email' => 'sembunly.biu@gmail.com',
            'date_of_birth' => '14 មករា 2005',
            'gender' => 'ប្រុស',
            'nationality' => 'ខ្មែរ',
            'faculty' => 'ព័ត៌មានវិទ្យា និងវិទ្យាសាស្ត្រ',
            'major' => 'វិស្វកម្មសុហ្វវែរ',
            'degree' => 'បរិញ្ញាបត្រ',
            'year' => 'ឆ្នាំទី ៣',
            'semester' => 'ឆមាសទី ១',
            'campus' => 'ទីតាំងទី ១',
            'address' => 'ភូមិសន្សំកុសល សង្កាត់បឹងទំពុនទី១ ខណ្ឌមានជ័យ រាជធានីភ្នំពេញ',
            'avatar' => null,
        ];

        $profileCompletion = $profileCompletion ?? 100;
        $announcements = $announcements ?? [
            ['title' => 'ការចុះឈ្មោះចូលរៀន (ថ្មី)', 'description' => 'និស្សិតអាចចុះឈ្មោះមុខវិជ្ជាសម្រាប់ឆមាសថ្មីបានចាប់ពីថ្ងៃនេះ។'],
            ['title' => 'កាលវិភាគប្រឡង (ឆមាសទី១)', 'description' => 'សូមពិនិត្យកាលវិភាគប្រឡង និងបន្ទប់ប្រឡងឲ្យបានច្បាស់លាស់។'],
        ];
    @endphp

                {{-- Welcome --}}
                <section class="grid gap-5 xl:grid-cols-[minmax(0,1.65fr)_minmax(280px,.75fr)]">
                    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-800 via-blue-700 to-cyan-600 p-6 text-white shadow-xl shadow-blue-900/10 sm:p-8">
                        <div class="absolute -right-16 -top-20 h-64 w-64 rounded-full border-[35px] border-white/10"></div>
                        <div class="absolute -bottom-24 right-24 h-48 w-48 rounded-full bg-white/10 blur-2xl"></div>
                        <div class="relative max-w-2xl">
                            <span class="inline-flex rounded-full bg-white/15 px-3 py-1 text-xs font-bold ring-1 ring-white/20">ឆ្នាំសិក្សា ២០២៥–២០២៦</span>
                            <p class="mt-5 text-sm font-semibold text-blue-100">សូមស្វាគមន៍មកកាន់ប្រព័ន្ធនិស្សិត</p>
                            <h2 class="mt-2 text-2xl font-black leading-relaxed sm:text-3xl">ជំរាបសួរ, {{ $student['name_km'] }}!</h2>
                            <p class="mt-2 max-w-xl text-sm leading-7 text-blue-100">តាមដានព័ត៌មានសិក្សា កាលវិភាគ លទ្ធផលប្រឡង និងសេចក្តីជូនដំណឹងរបស់អ្នកនៅទីនេះ។</p>
                            <a href="{{ route('student.information.show') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-white px-4 py-3 text-sm font-bold text-blue-800 shadow-lg transition hover:-translate-y-0.5 hover:bg-blue-50">
                                មើលព័ត៌មានផ្ទាល់ខ្លួន
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                            </a>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-bold text-slate-500">ភាពពេញលេញនៃប្រវត្តិរូប</p>
                                <p class="mt-2 text-4xl font-black text-slate-900">{{ $profileCompletion }}%</p>
                            </div>
                            <div class="grid h-12 w-12 place-items-center rounded-2xl bg-emerald-50 text-emerald-600">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg>
                            </div>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-500">បំពេញព័ត៌មានរបស់អ្នកឲ្យបានគ្រប់គ្រាន់ ដើម្បីងាយស្រួលប្រើប្រាស់ប្រព័ន្ធ។</p>
                        <div class="mt-6 h-2.5 overflow-hidden rounded-full bg-slate-100" role="progressbar" aria-label="ភាពពេញលេញនៃប្រវត្តិរូប" aria-valuenow="{{ $profileCompletion }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="h-full rounded-full bg-gradient-to-r from-blue-700 to-cyan-500" style="width: {{ min(100, max(0, $profileCompletion)) }}%"></div>
                        </div>
                    </div>
                </section>

                {{-- Quick summary --}}
                <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="ព័ត៌មានសង្ខេប">
                    @foreach([
                        ['label' => 'លេខសម្គាល់និស្សិត', 'value' => $student['student_id'], 'color' => 'blue', 'icon' => 'id'],
                        ['label' => 'កម្រិតសិក្សា', 'value' => $student['degree'], 'color' => 'violet', 'icon' => 'book'],
                        ['label' => 'ឆ្នាំសិក្សា', 'value' => $student['year'], 'color' => 'amber', 'icon' => 'calendar'],
                        ['label' => 'ឆមាសបច្ចុប្បន្ន', 'value' => $student['semester'], 'color' => 'emerald', 'icon' => 'chart'],
                    ] as $item)
                        @php
                            $colorClasses = [
                                'blue' => 'bg-blue-50 text-blue-700',
                                'violet' => 'bg-violet-50 text-violet-700',
                                'amber' => 'bg-amber-50 text-amber-700',
                                'emerald' => 'bg-emerald-50 text-emerald-700',
                            ];
                        @endphp
                        <div class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl {{ $colorClasses[$item['color']] }}">
                                @if($item['icon'] === 'id')
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="11" r="2"/><path d="M6 16c.8-2 5.2-2 6 0M14 10h4M14 14h4"/></svg>
                                @elseif($item['icon'] === 'book')
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V4H6.5A2.5 2.5 0 0 0 4 6.5v13Z"/><path d="M8 8h8M8 12h6"/></svg>
                                @elseif($item['icon'] === 'calendar')
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 5h18v16H3zM3 9h18M8 3v4M16 3v4"/></svg>
                                @else
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19V9M10 19V5M16 19v-7M22 19H2"/></svg>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="truncate text-xs font-semibold text-slate-500">{{ $item['label'] }}</p>
                                <p class="mt-1 truncate text-base font-extrabold text-slate-900">{{ $item['value'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </section>

                <section class="grid gap-5 xl:grid-cols-[minmax(0,1.15fr)_minmax(320px,.85fr)]">
                    {{-- Student info --}}
                    <article id="student-information" class="scroll-mt-24 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="grid h-10 w-10 place-items-center rounded-xl bg-blue-50 text-blue-700">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900">ព័ត៌មានផ្ទាល់ខ្លួន</h3>
                                    <p class="mt-0.5 text-xs text-slate-500">ព័ត៌មានមូលដ្ឋានរបស់និស្សិត</p>
                                </div>
                            </div>
                            <a href="{{ route('student.information.edit') }}" class="rounded-lg px-3 py-2 text-xs font-bold text-blue-700 hover:bg-blue-50">កែប្រែ</a>
                        </div>
                        <dl class="mt-2 divide-y divide-slate-100">
                            @foreach([
                                'ឈ្មោះជាភាសាខ្មែរ' => $student['name_km'],
                                'ឈ្មោះជាភាសាអង់គ្លេស' => $student['name_en'],
                                'លេខសម្គាល់និស្សិត' => $student['student_id'],
                                'ថ្ងៃខែឆ្នាំកំណើត' => $student['date_of_birth'],
                                'ភេទ' => $student['gender'],
                                'សញ្ជាតិ' => $student['nationality'],
                                'លេខទូរស័ព្ទ' => $student['phone'],
                                'អ៊ីមែល' => $student['email'],
                            ] as $label => $value)
                                <div class="grid gap-1 py-3.5 sm:grid-cols-[210px_1fr] sm:gap-5">
                                    <dt class="text-sm font-semibold text-slate-500">{{ $label }}</dt>
                                    <dd class="break-words text-sm font-bold text-slate-800">{{ $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </article>

                    <div class="space-y-5">
                        {{-- Study information --}}
                        <article id="study-information" class="scroll-mt-24 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                            <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                                <div class="grid h-10 w-10 place-items-center rounded-xl bg-violet-50 text-violet-700">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m2 10 10-5 10 5-10 5-10-5Z"/><path d="M6 12.5V17c3 2 9 2 12 0v-4.5"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900">ព័ត៌មានការសិក្សា</h3>
                                    <p class="mt-0.5 text-xs text-slate-500">កម្មវិធីសិក្សាបច្ចុប្បន្ន</p>
                                </div>
                            </div>
                            <dl class="mt-3 space-y-3">
                                @foreach([
                                    'មហាវិទ្យាល័យ' => $student['faculty'],
                                    'ជំនាញ' => $student['major'],
                                    'កម្រិត' => $student['degree'],
                                    'ទីតាំងសិក្សា' => $student['campus'],
                                ] as $label => $value)
                                    <div class="rounded-xl bg-slate-50 px-4 py-3">
                                        <dt class="text-xs font-semibold text-slate-500">{{ $label }}</dt>
                                        <dd class="mt-1 text-sm font-bold leading-6 text-slate-800">{{ $value }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </article>

                        {{-- Address --}}
                        <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                            <div class="flex items-start gap-3">
                                <div class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-amber-50 text-amber-700">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900">អាសយដ្ឋានបច្ចុប្បន្ន</h3>
                                    <p class="mt-2 text-sm leading-7 text-slate-600">{{ $student['address'] }}</p>
                                </div>
                            </div>
                        </article>
                    </div>
                </section>

                {{-- Announcements --}}
                <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="grid h-10 w-10 place-items-center rounded-xl bg-red-50 text-red-600">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 11 16-6v14L3 13v-2ZM11 16v4H7l-1-6"/></svg>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900">សេចក្តីជូនដំណឹង</h3>
                                <p class="mt-0.5 text-xs text-slate-500">ព័ត៌មានថ្មីៗពីសាកលវិទ្យាល័យ</p>
                            </div>
                        </div>
                        <a href="#" class="text-xs font-bold text-blue-700 hover:underline">មើលទាំងអស់</a>
                    </div>
                    <div class="mt-4 grid gap-3 lg:grid-cols-2">
                        @forelse($announcements as $announcement)
                            <a href="#" class="group rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:border-blue-200 hover:bg-blue-50/60">
                                <div class="flex items-start gap-3">
                                    <span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full bg-blue-600 ring-4 ring-blue-100"></span>
                                    <div>
                                        <h4 class="text-sm font-extrabold text-slate-900 group-hover:text-blue-700">{{ $announcement['title'] }}</h4>
                                        <p class="mt-1.5 text-sm leading-6 text-slate-500">{{ $announcement['description'] }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="col-span-full py-5 text-center text-sm text-slate-500">មិនទាន់មានសេចក្តីជូនដំណឹងថ្មីទេ។</p>
                        @endforelse
                    </div>
                </section>

@endsection

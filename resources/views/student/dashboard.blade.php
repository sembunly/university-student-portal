@extends('layouts.student')

@section('title', __('student.pages.dashboard'))
@section('page-heading', __('student.pages.dashboard'))

@section('content')
    @php
        $hasRegistration = $hasRegistration ?? false;
        $profileCompletion = $profileCompletion ?? 0;
        $informationRoute = $hasRegistration
            ? route('student.information.show')
            : route('student.information.edit');
        $dashboardName = filled($student['name_km'])
            ? $student['name_km']
            : ($student['student_id'] !== '—' ? $student['student_id'] : $student['phone']);
    @endphp

                {{-- Welcome --}}
                <section class="grid gap-5 xl:grid-cols-[minmax(0,1.65fr)_minmax(280px,.75fr)]">
                    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-800 via-blue-700 to-cyan-600 p-6 text-white shadow-xl shadow-blue-900/10 sm:p-8">
                        <div class="absolute -right-16 -top-20 h-64 w-64 rounded-full border-[35px] border-white/10"></div>
                        <div class="absolute -bottom-24 right-24 h-48 w-48 rounded-full bg-white/10 blur-2xl"></div>
                        <div class="relative max-w-2xl">
                            <p class="text-sm font-semibold text-blue-100">សូមស្វាគមន៍មកកាន់ប្រព័ន្ធនិស្សិត</p>
                            <h2 class="mt-2 text-2xl font-black leading-relaxed sm:text-3xl">ជំរាបសួរ, {{ $dashboardName }}!</h2>
                            <p class="mt-2 max-w-xl text-sm leading-7 text-blue-100">
                                {{ $hasRegistration
                                    ? 'តាមដាន និងគ្រប់គ្រងព័ត៌មាននិស្សិតរបស់អ្នកនៅទីនេះ។'
                                    : 'គណនីរបស់អ្នកត្រូវបានបង្កើតរួចហើយ។ សូមចុះឈ្មោះព័ត៌មាននិស្សិតដើម្បីបំពេញប្រវត្តិរូប។' }}
                            </p>
                            <a href="{{ $informationRoute }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-white px-4 py-3 text-sm font-bold text-blue-800 shadow-lg transition hover:-translate-y-0.5 hover:bg-blue-50">
                                {{ $hasRegistration ? 'មើលព័ត៌មានផ្ទាល់ខ្លួន' : 'ចុះឈ្មោះព័ត៌មាននិស្សិត' }}
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
                        <p class="mt-3 text-sm leading-6 text-slate-500">
                            {{ $hasRegistration
                                ? 'កែប្រែព័ត៌មានរបស់អ្នកនៅពេលមានការផ្លាស់ប្តូរ។'
                                : 'មិនទាន់មានព័ត៌មាននិស្សិតទេ។ ចុចប៊ូតុងចុះឈ្មោះដើម្បីចាប់ផ្តើម។' }}
                        </p>
                        <div class="mt-6 h-2.5 overflow-hidden rounded-full bg-slate-100" role="progressbar" aria-label="ភាពពេញលេញនៃប្រវត្តិរូប" aria-valuenow="{{ $profileCompletion }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="h-full rounded-full bg-gradient-to-r from-blue-700 to-cyan-500" style="width: {{ min(100, max(0, $profileCompletion)) }}%"></div>
                        </div>
                    </div>
                </section>

                {{-- Quick summary --}}
                <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="ព័ត៌មានសង្ខេប">
                    @foreach([
                        ['label' => 'លេខសម្គាល់និស្សិត', 'value' => $student['student_id'], 'color' => 'blue', 'icon' => 'id'],
                        ['label' => 'លេខទូរស័ព្ទ', 'value' => $student['phone'], 'color' => 'violet', 'icon' => 'phone'],
                        ['label' => 'អ៊ីមែល', 'value' => $student['email'], 'color' => 'amber', 'icon' => 'mail'],
                        ['label' => 'ភាពពេញលេញ', 'value' => $profileCompletion.'%', 'color' => 'emerald', 'icon' => 'status'],
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
                                @elseif($item['icon'] === 'phone')
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2h4l2 5-3 2a15 15 0 0 0 6 6l2-3 5 2v4a4 4 0 0 1-4 4C9.2 22 2 14.8 2 6a4 4 0 0 1 4-4Z"/></svg>
                                @elseif($item['icon'] === 'mail')
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
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
                            <a href="{{ route('student.information.edit') }}" class="rounded-lg px-3 py-2 text-xs font-bold text-blue-700 hover:bg-blue-50">
                                {{ $hasRegistration ? 'កែប្រែ' : 'ចុះឈ្មោះ' }}
                            </a>
                        </div>
                        @if($hasRegistration)
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
                        @else
                            <div class="mt-5 rounded-2xl border border-dashed border-blue-200 bg-blue-50/60 p-6 text-center">
                                <p class="text-sm font-bold text-slate-700">មិនទាន់មានព័ត៌មាននិស្សិតក្នុងប្រព័ន្ធទេ។</p>
                                <a href="{{ route('student.information.edit') }}" class="mt-4 inline-flex rounded-xl bg-blue-700 px-5 py-3 text-sm font-extrabold text-white hover:bg-blue-800">
                                    ចុះឈ្មោះព័ត៌មានឥឡូវនេះ
                                </a>
                            </div>
                        @endif
                    </article>

                    <div class="space-y-5">
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

@endsection

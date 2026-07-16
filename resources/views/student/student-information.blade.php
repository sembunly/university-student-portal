@extends('layouts.student')

@section('title', __('student.pages.information'))
@section('page-heading', __('student.pages.information'))

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <nav class="flex items-center gap-2 text-sm font-semibold text-slate-500" aria-label="Breadcrumb">
            <a href="{{ route('student.dashboard') }}" class="transition hover:text-blue-700">ទំព័រដើម</a>
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m9 18 6-6-6-6" />
            </svg>
            <span class="text-slate-900">ពិនិត្យព័ត៌មាននិស្សិត</span>
        </nav>
        <a href="{{ route('student.information.edit') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-blue-700/20 transition hover:bg-blue-800">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z" />
            </svg>
            កែប្រែព័ត៌មាននិស្សិត
        </a>
    </div>

    <div class="rounded-3xl border border-blue-100 bg-gradient-to-r from-blue-800 to-blue-600 p-5 text-white shadow-lg shadow-blue-900/10 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <div class="grid h-16 w-16 shrink-0 place-items-center rounded-2xl bg-white/15 text-2xl font-black ring-1 ring-white/20">
                {{ mb_substr(app()->isLocale('en') ? $student->name_en : $student->name_km, 0, 1) }}
            </div>
            <div>
                <p class="text-sm font-semibold text-blue-100">លេខសម្គាល់និស្សិត {{ $student->student_id }}</p>
                <h1 class="mt-1 text-2xl font-black">{{ $student->name_km }}</h1>
                <p class="mt-1 text-sm font-semibold text-blue-100">{{ $student->name_en }}</p>
            </div>
        </div>
    </div>

    <div class="space-y-5">
        @foreach($informationSections as $section)
            @include('student.partials.information-section', [
                'title' => $section['title'],
                'subtitle' => $section['subtitle'] ?? null,
                'items' => $section['items'],
            ])
        @endforeach
    </div>
@endsection

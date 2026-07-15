@extends('layouts.student')

@section('title', __('student.pages.information'))
@section('page-heading', __('student.pages.information'))

@section('content')
    @php
        $student = $student ?? [
            'name_km' => 'សែម ប៊ុនលី',
            'name_en' => 'SEM BUNLY',
            'student_id' => '00058475',
            'phone' => '010800921',
            'email' => 'sembunly.biu@gmail.com',
            'degree' => 'បរិញ្ញាបត្រ',
            'year' => 'ឆ្នាំទី ៣',
            'semester' => 'ឆមាសទី ១',
            'avatar' => null,
        ];

        $informationSections = [
            [
                'title' => 'ប្រវត្តិរូបផ្ទាល់ខ្លួន',
                'subtitle' => 'ព័ត៌មានសម្គាល់អត្តសញ្ញាណរបស់និស្សិត',
                'items' => [
                    ['label' => 'លេខសម្គាល់និស្សិត', 'value' => '00058475'],
                    ['label' => 'នាមត្រកូល (ខ្មែរ)', 'value' => 'សែម'],
                    ['label' => 'នាមខ្លួន (ខ្មែរ)', 'value' => 'ប៊ុនលី'],
                    ['label' => 'នាមត្រកូល (ឡាតាំង)', 'value' => 'SEM'],
                    ['label' => 'នាមខ្លួន (ឡាតាំង)', 'value' => 'BUNLY'],
                    ['label' => 'ឈ្មោះចិន', 'value' => 'មិនមាន'],
                    ['label' => 'ភេទ', 'value' => 'ប្រុស'],
                    ['label' => 'ប្រភេទឯកសារ', 'value' => 'អត្តសញ្ញាណប័ណ្ណ'],
                    ['label' => 'លេខឯកសារ', 'value' => '010101010'],
                    ['label' => 'សញ្ជាតិ', 'value' => 'ខ្មែរ'],
                    ['label' => 'ប្រទេស', 'value' => 'កម្ពុជា'],
                    ['label' => 'ថ្ងៃខែឆ្នាំកំណើត', 'value' => '14-01-2005'],
                ],
            ],
            [
                'title' => 'ទីកន្លែងកំណើត',
                'items' => [
                    ['label' => 'អាសយដ្ឋានកំណើត (ខ្មែរ)', 'value' => 'ភូមិចុងកោះតូច ឃុំតាលន់ ស្រុកស្អាង ខេត្តកណ្ដាល', 'full' => true],
                    ['label' => 'អាសយដ្ឋានកំណើត (ឡាតាំង)', 'value' => "Phum Chong Kaoh Touch, Khum Ta Lon, Srok S'ang, Kandal Province", 'full' => true],
                ],
            ],
            [
                'title' => 'ព័ត៌មានទំនាក់ទំនង',
                'items' => [
                    ['label' => 'លេខទូរស័ព្ទផ្ទាល់ខ្លួន', 'value' => '010800921'],
                    ['label' => 'អ៊ីមែល', 'value' => 'sembunly.biu@gmail.com'],
                ],
            ],
            [
                'title' => 'អាសយដ្ឋានបច្ចុប្បន្ន',
                'items' => [
                    ['label' => 'អាសយដ្ឋានបច្ចុប្បន្ន (ខ្មែរ)', 'value' => 'ភូមិសន្សំកុសល ១ សង្កាត់បឹងទំពុនទី១ ខណ្ឌមានជ័យ រាជធានីភ្នំពេញ', 'full' => true],
                    ['label' => 'អាសយដ្ឋានបច្ចុប្បន្ន (ឡាតាំង)', 'value' => 'Phum Sansam Kosal Muoy, Sangkat Boeng Tumpun 1, Khan Mean Chey, Phnom Penh Capital', 'full' => true],
                    ['label' => 'អាសយដ្ឋានទំនាក់ទំនងនៅភ្នំពេញ (ខ្មែរ)', 'value' => 'ភូមិសន្សំកុសល ១ សង្កាត់បឹងទំពុនទី១ ខណ្ឌមានជ័យ រាជធានីភ្នំពេញ', 'full' => true],
                    ['label' => 'អាសយដ្ឋានទំនាក់ទំនងនៅភ្នំពេញ (ឡាតាំង)', 'value' => 'Phum Sansam Kosal Muoy, Sangkat Boeng Tumpun 1, Khan Mean Chey, Phnom Penh Capital', 'full' => true],
                ],
            ],
            [
                'title' => 'ព័ត៌មានឪពុក',
                'items' => [
                    ['label' => 'ឈ្មោះឪពុក (ខ្មែរ)', 'value' => 'Test'],
                    ['label' => 'ឈ្មោះឪពុក (ឡាតាំង)', 'value' => 'SEM MANH'],
                    ['label' => 'ថ្ងៃខែឆ្នាំកំណើតឪពុក', 'value' => 'Test'],
                    ['label' => 'សញ្ជាតិឪពុក', 'value' => 'ខ្មែរ'],
                    ['label' => 'ប្រទេសឪពុក', 'value' => 'កម្ពុជា'],
                    ['label' => 'ខេត្ត/រាជធានី', 'value' => 'កណ្ដាល'],
                    ['label' => 'មុខរបរឪពុក', 'value' => 'Test'],
                    ['label' => 'លេខទូរស័ព្ទឪពុក', 'value' => '096 776 025'],
                    ['label' => 'អាសយដ្ឋានឪពុក (ខ្មែរ)', 'value' => 'ខេត្តកណ្ដាល'],
                    ['label' => 'អាសយដ្ឋានឪពុក (ឡាតាំង)', 'value' => 'Kandal Province'],
                ],
            ],
            [
                'title' => 'ព័ត៌មានម្តាយ',
                'items' => [
                    ['label' => 'ឈ្មោះម្តាយ (ខ្មែរ)', 'value' => 'Test'],
                    ['label' => 'ឈ្មោះម្តាយ (ឡាតាំង)', 'value' => 'SAM SOKPHY'],
                    ['label' => 'ថ្ងៃខែឆ្នាំកំណើតម្តាយ', 'value' => '10-06-1970'],
                    ['label' => 'សញ្ជាតិម្តាយ', 'value' => 'ខ្មែរ'],
                    ['label' => 'ប្រទេសម្តាយ', 'value' => 'កម្ពុជា'],
                    ['label' => 'ខេត្ត/រាជធានី', 'value' => 'កណ្ដាល'],
                    ['label' => 'មុខរបរម្តាយ', 'value' => 'Test'],
                    ['label' => 'លេខទូរស័ព្ទម្តាយ', 'value' => '069800921'],
                    ['label' => 'អាសយដ្ឋានម្តាយ (ខ្មែរ)', 'value' => 'ខេត្តកណ្ដាល'],
                    ['label' => 'អាសយដ្ឋានម្តាយ (ឡាតាំង)', 'value' => 'Kandal Province'],
                ],
            ],
            [
                'title' => 'ប្រវត្តិគ្រួសារ',
                'items' => [
                    ['label' => 'ឈ្មោះអាណាព្យាបាល', 'value' => 'Test'],
                    ['label' => 'លេខទូរស័ព្ទអាណាព្យាបាល', 'value' => '069800921'],
                    ['label' => 'ស្ថានភាពគ្រួសារ', 'value' => 'នៅលីវ'],
                ],
            ],
            [
                'title' => 'បឋមសិក្សា',
                'items' => [
                    ['label' => 'សាលាបឋមសិក្សា', 'value' => 'តាលន់'],
                    ['label' => 'ឆ្នាំចាប់ផ្តើមបឋមសិក្សា', 'value' => '2012'],
                    ['label' => 'ឆ្នាំបញ្ចប់បឋមសិក្សា', 'value' => '2017'],
                    ['label' => 'ខេត្ត/រាជធានីនៃសាលាបឋមសិក្សា', 'value' => 'កណ្ដាល'],
                ],
            ],
            [
                'title' => 'អនុវិទ្យាល័យ',
                'items' => [
                    ['label' => 'អនុវិទ្យាល័យ', 'value' => 'តាលន់'],
                    ['label' => 'ឆ្នាំចាប់ផ្តើមអនុវិទ្យាល័យ', 'value' => '2018'],
                    ['label' => 'ឆ្នាំបញ្ចប់អនុវិទ្យាល័យ', 'value' => '2020'],
                    ['label' => 'ខេត្ត/រាជធានីនៃអនុវិទ្យាល័យ', 'value' => 'កណ្ដាល'],
                ],
            ],
            [
                'title' => 'វិទ្យាល័យ និងបាក់ឌុប',
                'items' => [
                    ['label' => 'ប្រទេសនៃវិទ្យាល័យ', 'value' => 'កម្ពុជា'],
                    ['label' => 'ខេត្ត/រាជធានីនៃវិទ្យាល័យ', 'value' => 'កណ្ដាល'],
                    ['label' => 'វិទ្យាល័យ', 'value' => 'វិទ្យាល័យ ហ៊ុន សែន ស្អាង'],
                    ['label' => 'ឆ្នាំចាប់ផ្តើមវិទ្យាល័យ', 'value' => '2021'],
                    ['label' => 'ឆ្នាំបញ្ចប់វិទ្យាល័យ', 'value' => '2023'],
                    ['label' => 'លេខកូដបាក់ឌុប', 'value' => 'មិនមាន'],
                    ['label' => 'លទ្ធផលបាក់ឌុប', 'value' => 'មិនមាន'],
                    ['label' => 'ឆ្នាំបញ្ចប់បាក់ឌុប', 'value' => 'មិនមាន'],
                    ['label' => 'ប្រភេទសិស្ស', 'value' => 'មិនមាន'],
                    ['label' => 'និទ្ទេសបាក់ឌុប', 'value' => 'មិនមាន'],
                    ['label' => 'រូបភាពឯកសារបាក់ឌុប', 'value' => 'មិនទាន់មានឯកសារ', 'full' => true],
                ],
            ],
        ];
    @endphp

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

    <div
        class="rounded-3xl border border-blue-100 bg-gradient-to-r from-blue-800 to-blue-600 p-5 text-white shadow-lg shadow-blue-900/10 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <div
                class="grid h-16 w-16 shrink-0 place-items-center rounded-2xl bg-white/15 text-2xl font-black ring-1 ring-white/20">
                ស</div>
            <div>
                <p class="text-sm font-semibold text-blue-100">លេខសម្គាល់និស្សិត {{ $student['student_id'] }}</p>
                <h1 class="mt-1 text-2xl font-black">{{ $student['name_km'] }}</h1>
                <p class="mt-1 text-sm font-semibold text-blue-100">{{ $student['name_en'] }}</p>
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

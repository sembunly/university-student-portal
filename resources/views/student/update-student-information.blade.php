@extends('layouts.student')

@section('title', __('student.pages.edit_information'))
@section('page-heading', __('student.pages.edit_information'))

@section('content')
    @php
        $student = $student ?? [
            'name_km' => 'សែម ប៊ុនលី',
            'name_en' => 'SEM BUNLY',
            'student_id' => '00058475',
            'phone' => '010 800 921',
            'email' => 'sembunly.biu@gmail.com',
            'date_of_birth' => '2005-01-14',
            'gender' => 'ប្រុស',
            'nationality' => 'ខ្មែរ',
            'faculty' => 'ព័ត៌មានវិទ្យា និងវិទ្យាសាស្ត្រ',
            'major' => 'វិស្វកម្មសុហ្វវែរ',
            'degree' => 'បរិញ្ញាបត្រ',
            'year' => 'ឆ្នាំទី ២',
            'semester' => 'ឆមាសទី ១',
            'campus' => 'ទីតាំងទី ១',
            'address' => 'ភូមិសន្សំកុសល សង្កាត់បឹងទំពុនទី១ ខណ្ឌមានជ័យ រាជធានីភ្នំពេញ',
            'avatar' => null,
        ];
        $inputClass = 'mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100';
        $labelClass = 'text-sm font-bold text-slate-700';
    @endphp

    <nav class="flex items-center gap-2 text-sm font-semibold text-slate-500" aria-label="Breadcrumb">
        <a href="{{ route('student.dashboard') }}" class="transition hover:text-blue-700">ទំព័រដើម</a>
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <a href="{{ route('student.information.show') }}" class="transition hover:text-blue-700">ពិនិត្យព័ត៌មាននិស្សិត</a>
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span class="text-slate-900">កែប្រែ</span>
    </nav>

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700" role="alert">
            <p class="font-extrabold">សូមពិនិត្យព័ត៌មានខាងក្រោមម្តងទៀត៖</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('student.information.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-slate-200 bg-blue-50/70 px-5 py-4 sm:px-6">
                <div class="grid h-10 w-10 place-items-center rounded-xl bg-blue-100 text-blue-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                </div>
                <div>
                    <h2 class="font-extrabold text-slate-900">ព័ត៌មានផ្ទាល់ខ្លួន</h2>
                    <p class="mt-0.5 text-xs text-slate-500">សូមបំពេញព័ត៌មានដែលមានសញ្ញា <span class="text-red-500">*</span></p>
                </div>
            </div>

            <div class="grid gap-5 p-5 sm:p-6 lg:grid-cols-2">
                <div>
                    <label for="name_km" class="{{ $labelClass }}">ឈ្មោះជាភាសាខ្មែរ <span class="text-red-500">*</span></label>
                    <input id="name_km" name="name_km" value="{{ old('name_km', $student['name_km']) }}" class="{{ $inputClass }}" required>
                </div>
                <div>
                    <label for="name_en" class="{{ $labelClass }}">ឈ្មោះជាភាសាអង់គ្លេស <span class="text-red-500">*</span></label>
                    <input id="name_en" name="name_en" value="{{ old('name_en', $student['name_en']) }}" class="{{ $inputClass }}" required>
                </div>
                <div>
                    <label for="student_id" class="{{ $labelClass }}">លេខសម្គាល់និស្សិត</label>
                    <input id="student_id" value="{{ $student['student_id'] }}" class="{{ $inputClass }} bg-slate-100 text-slate-500" disabled>
                </div>
                <div>
                    <label for="date_of_birth" class="{{ $labelClass }}">ថ្ងៃខែឆ្នាំកំណើត</label>
                    <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', $student['date_of_birth']) }}" class="{{ $inputClass }}">
                </div>
                <fieldset>
                    <legend class="{{ $labelClass }}">ភេទ <span class="text-red-500">*</span></legend>
                    <div class="mt-2 grid grid-cols-2 gap-3">
                        @foreach(['ប្រុស', 'ស្រី'] as $gender)
                            <label class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border border-slate-200 px-4 py-3 text-sm font-bold has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-700">
                                <input type="radio" name="gender" value="{{ $gender }}" class="accent-blue-700" @checked(old('gender', $student['gender']) === $gender)>
                                {{ $gender }}
                            </label>
                        @endforeach
                    </div>
                </fieldset>
                <div>
                    <label for="nationality" class="{{ $labelClass }}">សញ្ជាតិ</label>
                    <select id="nationality" name="nationality" class="{{ $inputClass }}">
                        <option @selected(old('nationality', $student['nationality']) === 'ខ្មែរ')>ខ្មែរ</option>
                        <option>ផ្សេងៗ</option>
                    </select>
                </div>
                <div>
                    <label for="phone" class="{{ $labelClass }}">លេខទូរស័ព្ទ <span class="text-red-500">*</span></label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone', $student['phone']) }}" class="{{ $inputClass }}" required>
                </div>
                <div>
                    <label for="email" class="{{ $labelClass }}">អ៊ីមែល</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $student['email']) }}" class="{{ $inputClass }}">
                </div>
            </div>
        </section>

        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-slate-200 bg-blue-50/70 px-5 py-4 sm:px-6">
                <div class="grid h-10 w-10 place-items-center rounded-xl bg-blue-100 text-blue-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>
                </div>
                <h2 class="font-extrabold text-slate-900">ព័ត៌មានអាសយដ្ឋាន</h2>
            </div>
            <div class="space-y-6 p-5 sm:p-6">
                @foreach([
                    ['title' => 'អាសយដ្ឋានបច្ចុប្បន្ន', 'prefix' => 'current'],
                    ['title' => 'អាសយដ្ឋានអចិន្ត្រៃយ៍', 'prefix' => 'permanent'],
                ] as $address)
                    <fieldset class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4 sm:p-5">
                        <legend class="px-2 text-sm font-extrabold text-blue-900">{{ $address['title'] }}</legend>
                        <div class="grid gap-5 lg:grid-cols-2">
                            <div>
                                <label class="{{ $labelClass }}">រាជធានី/ខេត្ត <span class="text-red-500">*</span></label>
                                <select name="{{ $address['prefix'] }}_province" class="{{ $inputClass }}"><option>ភ្នំពេញ</option><option>កណ្ដាល</option><option>សៀមរាប</option></select>
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">ក្រុង/ស្រុក/ខណ្ឌ <span class="text-red-500">*</span></label>
                                <select name="{{ $address['prefix'] }}_district" class="{{ $inputClass }}"><option>មានជ័យ</option><option>ចំការមន</option><option>សែនសុខ</option></select>
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">ឃុំ/សង្កាត់ <span class="text-red-500">*</span></label>
                                <select name="{{ $address['prefix'] }}_commune" class="{{ $inputClass }}"><option>បឹងទំពុនទី១</option><option>បឹងទំពុនទី២</option></select>
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">ភូមិ <span class="text-red-500">*</span></label>
                                <input name="{{ $address['prefix'] }}_village" value="សន្សំកុសល" class="{{ $inputClass }}">
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">លេខផ្ទះ</label>
                                <input name="{{ $address['prefix'] }}_house" class="{{ $inputClass }}">
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">លេខផ្លូវ</label>
                                <input name="{{ $address['prefix'] }}_street" class="{{ $inputClass }}">
                            </div>
                        </div>
                    </fieldset>
                @endforeach
            </div>
        </section>

        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-slate-200 bg-blue-50/70 px-5 py-4 sm:px-6">
                <div class="grid h-10 w-10 place-items-center rounded-xl bg-blue-100 text-blue-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="8" r="3"/><circle cx="17" cy="10" r="2.5"/><path d="M3 20a6 6 0 0 1 12 0M14 16a5 5 0 0 1 7 4"/></svg>
                </div>
                <h2 class="font-extrabold text-slate-900">ព័ត៌មានគ្រួសារ</h2>
            </div>
            <div class="grid gap-6 p-5 sm:p-6 xl:grid-cols-2">
                @foreach([
                    ['title' => 'ព័ត៌មានឪពុក', 'prefix' => 'father', 'name' => 'Test', 'phone' => '096 776 256'],
                    ['title' => 'ព័ត៌មានម្ដាយ', 'prefix' => 'mother', 'name' => 'Test', 'phone' => '069 800 921'],
                ] as $guardian)
                    <fieldset class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4 sm:p-5">
                        <legend class="px-2 text-sm font-extrabold text-blue-900">{{ $guardian['title'] }}</legend>
                        <div class="space-y-4">
                            <div>
                                <label class="{{ $labelClass }}">គោត្តនាម និងនាម</label>
                                <input name="{{ $guardian['prefix'] }}_name" value="{{ $guardian['name'] }}" class="{{ $inputClass }}">
                            </div>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="{{ $labelClass }}">មុខរបរ</label>
                                    <input name="{{ $guardian['prefix'] }}_occupation" value="Test" class="{{ $inputClass }}">
                                </div>
                                <div>
                                    <label class="{{ $labelClass }}">លេខទូរស័ព្ទ</label>
                                    <input name="{{ $guardian['prefix'] }}_phone" value="{{ $guardian['phone'] }}" class="{{ $inputClass }}">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                @endforeach
                <div>
                    <label for="emergency_name" class="{{ $labelClass }}">ឈ្មោះអ្នកទំនាក់ទំនងបន្ទាន់ <span class="text-red-500">*</span></label>
                    <input id="emergency_name" name="emergency_name" value="Test" class="{{ $inputClass }}">
                </div>
                <div>
                    <label for="emergency_phone" class="{{ $labelClass }}">លេខទូរស័ព្ទបន្ទាន់ <span class="text-red-500">*</span></label>
                    <input id="emergency_phone" name="emergency_phone" value="069 800 921" class="{{ $inputClass }}">
                </div>
            </div>
        </section>

        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-slate-200 bg-blue-50/70 px-5 py-4 sm:px-6">
                <div class="grid h-10 w-10 place-items-center rounded-xl bg-blue-100 text-blue-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V4H6.5A2.5 2.5 0 0 0 4 6.5v13Z"/><path d="M8 8h8M8 12h6"/></svg>
                </div>
                <h2 class="font-extrabold text-slate-900">ប្រវត្តិសិក្សា</h2>
            </div>
            <div class="grid gap-5 p-5 sm:p-6 lg:grid-cols-2">
                <div>
                    <label for="high_school" class="{{ $labelClass }}">ឈ្មោះវិទ្យាល័យ</label>
                    <input id="high_school" name="high_school" value="វិទ្យាល័យ ប៊ុន រ៉ានី ហ៊ុន សែន" class="{{ $inputClass }}">
                </div>
                <div>
                    <label for="graduation_year" class="{{ $labelClass }}">ឆ្នាំបញ្ចប់ការសិក្សា</label>
                    <select id="graduation_year" name="graduation_year" class="{{ $inputClass }}">
                        @foreach(range(date('Y'), 2015) as $year)<option @selected($year === 2023)>{{ $year }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label for="education_province" class="{{ $labelClass }}">រាជធានី/ខេត្តនៃវិទ្យាល័យ</label>
                    <select id="education_province" name="education_province" class="{{ $inputClass }}"><option>កណ្ដាល</option><option>ភ្នំពេញ</option></select>
                </div>
                <div>
                    <label for="certificate" class="{{ $labelClass }}">ឯកសារបញ្ជាក់ការសិក្សា</label>
                    <input id="certificate" name="certificate" type="file" accept=".jpg,.jpeg,.png,.pdf" class="{{ $inputClass }} file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:font-bold file:text-blue-700">
                    <p class="mt-2 text-xs text-slate-500">JPG, PNG ឬ PDF — ទំហំអតិបរមា 2 MB</p>
                </div>
            </div>
        </section>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <label class="flex cursor-pointer items-start gap-3">
                <input type="checkbox" name="declaration" value="1" class="mt-1 h-5 w-5 rounded border-slate-300 accent-blue-700" required @checked(old('declaration'))>
                <span>
                    <span class="text-sm font-extrabold leading-6 text-slate-800">ខ្ញុំសូមប្រកាសថា ព័ត៌មាន និងឯកសារខាងលើពិតជាត្រឹមត្រូវ។ <span class="text-red-500">*</span></span>
                    <span class="mt-1 block text-xs leading-5 text-slate-500">I hereby declare that the above information and supporting documents are accurate and true.</span>
                </span>
            </label>
        </div>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('student.information.show') }}" class="rounded-xl border border-slate-200 bg-white px-6 py-3 text-center text-sm font-extrabold text-slate-700 transition hover:bg-slate-50">បោះបង់</a>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-6 py-3 text-sm font-extrabold text-white shadow-lg shadow-blue-700/20 transition hover:bg-blue-800">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 3h12l2 2v16H5zM8 3v6h8V3M8 21v-7h8v7"/></svg>
                រក្សាទុកការកែប្រែ
            </button>
        </div>
    </form>
@endsection

<section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
    <div class="flex items-center gap-3 border-b border-slate-200 bg-blue-50/70 px-5 py-4 sm:px-6">
        <div class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-blue-100 text-blue-700">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>
            </svg>
        </div>
        <div>
            <h2 class="font-extrabold text-slate-900">{{ $title }}</h2>
            @isset($subtitle)
                <p class="mt-0.5 text-xs text-slate-500">{{ $subtitle }}</p>
            @endisset
        </div>
    </div>

    <dl class="grid gap-3 p-5 sm:grid-cols-2 sm:p-6">
        @foreach($items as $item)
            <div class="rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3.5 {{ !empty($item['full']) ? 'sm:col-span-2' : '' }}">
                <dt class="text-xs font-bold leading-5 text-slate-500">{{ $item['label'] }}</dt>
                <dd class="mt-1 break-words text-sm font-extrabold leading-6 text-slate-900">{{ $item['value'] ?: 'មិនមាន' }}</dd>
            </div>
        @endforeach
    </dl>
</section>

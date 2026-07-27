<footer class="flex flex-col gap-3 border-t border-slate-200 py-5 text-xs font-semibold text-slate-400 sm:flex-row sm:items-center sm:justify-between">
    <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
        <span>© {{ date('Y') }} {{ __('student.common.university') }}</span>
        <span class="h-1 w-1 rounded-full bg-slate-300" aria-hidden="true"></span>
        <span>
            {{ __('student.common.developed_by') }}
            <a href="https://www.bunli-it.site/" target="_blank" rel="noopener noreferrer"
                class="inline-flex items-center gap-1.5 text-sm font-black tracking-wide text-indigo-600 transition hover:text-indigo-800">
                SEM BUNLY
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 4h5v5M14 10l6-6M20 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h5"/></svg>
            </a>
        </span>
    </div>
    @if(config('mail.from.address'))
        <p>{{ __('student.common.technical_support') }}: {{ config('mail.from.address') }}</p>
    @endif
</footer>

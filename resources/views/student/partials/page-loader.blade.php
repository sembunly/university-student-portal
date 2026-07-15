<div id="pageLoader" aria-hidden="true" aria-live="polite" aria-busy="true"
    class="invisible fixed inset-0 z-[100] grid place-items-center bg-slate-950/45 opacity-0 backdrop-blur-md transition-opacity duration-300">
    <div class="relative mx-4 w-full max-w-xs overflow-hidden rounded-3xl border border-white/40 bg-white/95 px-8 py-9 text-center shadow-2xl shadow-blue-950/30">
        <div class="absolute inset-x-0 top-0 h-1 overflow-hidden bg-blue-100">
            <div class="h-full w-1/2 animate-[loader-slide_1s_ease-in-out_infinite] rounded-full bg-gradient-to-r from-blue-700 to-cyan-400"></div>
        </div>

        <div class="relative mx-auto h-24 w-24">
            <div class="absolute inset-0 animate-ping rounded-full bg-blue-200/60"></div>
            <div class="absolute inset-2 animate-spin rounded-full border-4 border-blue-100 border-r-blue-700 border-t-cyan-500"></div>
            <div class="absolute inset-5 grid place-items-center rounded-2xl bg-gradient-to-br from-blue-700 to-blue-950 text-white shadow-lg shadow-blue-800/30">
                <svg class="h-9 w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path d="M3 8.5 12 4l9 4.5-9 4.5-9-4.5Z"/>
                    <path d="M7 10.5V15c2.6 2 7.4 2 10 0v-4.5M21 9v6"/>
                </svg>
            </div>
        </div>

        <p class="mt-5 text-base font-extrabold text-slate-900">{{ __('student.common.loading') }}</p>
        <div class="mt-4 flex items-center justify-center gap-2" aria-hidden="true">
            <span class="h-2 w-2 animate-bounce rounded-full bg-blue-700 [animation-delay:-.3s]"></span>
            <span class="h-2 w-2 animate-bounce rounded-full bg-blue-600 [animation-delay:-.15s]"></span>
            <span class="h-2 w-2 animate-bounce rounded-full bg-cyan-500"></span>
        </div>
    </div>
</div>

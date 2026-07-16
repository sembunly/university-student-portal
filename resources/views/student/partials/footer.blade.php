<footer class="flex flex-col gap-2 border-t border-slate-200 py-5 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
    <p>© {{ date('Y') }}</p>
    @if(config('mail.from.address'))
        <p>ជំនួយបច្ចេកទេស: {{ config('mail.from.address') }}</p>
    @endif
</footer>

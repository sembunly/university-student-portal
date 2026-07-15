<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', 'km');

        if (! in_array($locale, ['km', 'en'], true)) {
            $locale = 'km';
        }

        App::setLocale($locale);

        $languageFile = lang_path($locale.'.php');

        if (is_file($languageFile)) {
            $translations = require $languageFile;
            $lines = [];

            foreach (Arr::dot($translations) as $key => $value) {
                $lines['student.'.$key] = $value;
            }

            Lang::addLines($lines, $locale);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    private const SUPPORTED_LOCALES = ['en', 'bg'];

    public function switch(string $locale, Request $request): RedirectResponse
    {
        if (! in_array($locale, self::SUPPORTED_LOCALES, true)) {
            abort(400, 'Unsupported language.');
        }

        App::setLocale($locale);

        return Redirect::back()->withCookie(
            cookie('locale', $locale, 60 * 24 * 30)
        );
    }
}

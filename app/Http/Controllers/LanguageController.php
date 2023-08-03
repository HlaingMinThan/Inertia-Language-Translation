<?php

namespace App\Http\Controllers;

use App\Lang\Language;

class LanguageController extends Controller
{
    public function store()
    {
        session()->put('language', Language::tryFrom(request('language', config('app.locale')))?->value);
        return back();
    }
}

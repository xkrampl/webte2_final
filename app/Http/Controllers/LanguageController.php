<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function __invoke($language)
    {
        Session()->put('locale', $language);
        return redirect()->back();
    }
}

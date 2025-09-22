<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Switch application language
     */
    public function switchLanguage($locale)
    {
        if (in_array($locale, ['en', 'id'])) {
            session(['app_locale' => $locale]);
        }
        
        return back();
    }
}
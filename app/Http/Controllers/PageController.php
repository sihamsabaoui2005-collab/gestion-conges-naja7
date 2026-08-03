<?php
// Place ce fichier dans : app/Http/Controllers/PageController.php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function features()
    {
        return view('pages.features');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}

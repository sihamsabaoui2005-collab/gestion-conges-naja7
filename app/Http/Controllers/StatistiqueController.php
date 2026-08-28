<?php

namespace App\Http\Controllers;

class StatistiqueController extends Controller
{
    public function index()
    {
        return view('statistiques.index');
    }
}
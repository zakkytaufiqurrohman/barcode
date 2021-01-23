<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KlaperController extends Controller
{
    function index()
    {
        return view('klaper.index');
    }
}

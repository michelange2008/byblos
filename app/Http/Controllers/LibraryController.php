<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LibraryController extends Controller
{
    function index()
    {
        return view('dashboard');    
    }
}

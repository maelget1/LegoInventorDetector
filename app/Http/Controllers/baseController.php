<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class baseController extends Controller
{
    //
    public function home()
    {
        return view('home')->with('name', '')->with('class', '')->with('val', '');
    }

    public function inventaire()
    {
        return view('inventaire');
    }
}

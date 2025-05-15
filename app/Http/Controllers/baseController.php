<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class baseController extends Controller
{
    //
    public function home()
    {
        return view('home')->with('name', '')->with('class', '')->with('val', '')->with('num', '')->with('desc', '');
    }

    public function inventaire()
    {
        return view('inventaire');
    }

    public function updatePieceCount(Request $request)
    {
        $label = $request->input('label');
        $delta = $request->input('delta');
        // Update your session or DB here, e.g.:
        $num = session('num');
        $num[$label] = ($num[$label] + $delta);
        session(['num' => $num]);
        return response()->json(['success' => true, 'count' => $num[$label]]);
    }
}

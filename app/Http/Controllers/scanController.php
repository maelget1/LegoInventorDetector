<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class scanController extends Controller
{
    //
    public function submit(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:50',
            'class' => 'required|string|max:6',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // handle the image file
        $pre = $request->getSchemeAndHttpHost() . '/images/';
        $last = time() . '.' . $request->file('image')->extension();
        $filename = $pre . $last;
        $request->file('image')->move(public_path('images'), $filename);

        return view('home')->with('name', $request->name)
            ->with('class', $request->class);
    }
}

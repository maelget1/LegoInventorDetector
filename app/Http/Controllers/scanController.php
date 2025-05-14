<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class scanController extends Controller
{
    //
    public function submit(Request $request)
    {
        ini_set('memory_limit', '4096M'); // Augmente la limite de mémoire à 4096MB
        set_time_limit(60);
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
        $val = shell_exec('python ' . resource_path('py/CreateRaw.py') . ' ' . public_path('images/') . $last);

        return view('home')->with('name', $request->name)
            ->with('class', $request->class)
            ->with('val', $val);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class scanController extends Controller
{
    //
    public function submit(Request $request)
    {
        ini_set('memory_limit', '4096M');
        set_time_limit(60);

        // Validation côté serveur
        $request->validate([
            'name' => 'required|string|max:50',
            'class' => 'required|string|max:6',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // stock l'image
        $pre = $request->getSchemeAndHttpHost() . '/images/';
        $last = time() . '.' . $request->file('image')->extension();
        $filename = $pre . $last;
        $request->file('image')->move(public_path('images'), $filename);

        //exécute le script python
        $val = shell_exec('python ' . resource_path('py/CreateRaw.py') . ' ' . public_path('images/') . $last);

        //rendre un vrai format JSON
        $val = $this->cleanJSON($val);

        $num = $this->getNum($val);

        $desc = $this->getData($val);

        return view('home')->with('name', $request->name)
            ->with('class', $request->class)
            ->with('val', $val)
            ->with('num', $num)
            ->with('desc', $desc);
    }

    private function cleanJSON($val)
    {
        // Remove trailing " 0"
        $val = preg_replace('/}\s*[^}]*$/', '}', $val);

        // Replace single quotes with double quotes
        $val = str_replace("'", '"', $val);

        // Quote the keys
        $val = preg_replace('/([{,]\s*)(\w+)\s*:/', '$1"$2":', $val);

        return json_decode($val,true);
    }

    private function getNum($val)
    {
        $labels = array_column($val['results'], 'label');

        return array_count_values($labels);
    }

    private function getData($val)
    {
        $descriptions = [];
        foreach($val['results'] as $result) {
            $num = explode(' - ', $result['label']);
            $descriptions[$result['label']] = DB::table('t_pieces')->where('pie_numero', $num[0])->value('pie_description');
        }
        return $descriptions;
    }
}

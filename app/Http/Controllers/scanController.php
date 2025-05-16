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

        session(['num' => $num]);

        return view('home')->with('name', $request->name)
            ->with('class', $request->class)
            ->with('val', $val)
            ->with('desc', $desc)
            ->with('bricks', $this->getBricks());
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

    public function searchDescription(Request $request)
    {
        $searchTerm = $request->input('input');
        $val = explode(' - ', $searchTerm);
        $result = DB::table('t_pieces')
            ->where('pie_numero', 'LIKE', '%' . $val[0] . '%')
            ->where('pie_couleur', 'LIKE', '%' . $val[1] . '%')
            ->value('pie_description');

        return response()->json(['success' => true, 'description' => $result]);
    }

    private function getBricks()
    {
        $bricks = [];
        $vals = DB::table('t_pieces')->get();
        foreach($vals as $val) {
            $bricks[] = $val->pie_numero . " - " . $val->pie_couleur;  // Use object notation and string concatenation
        }
        return $bricks;
    }
}

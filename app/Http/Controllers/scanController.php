<?php
/*
ETML
Auteur: Maël Gétain
Date: 21.05.2025
Description: Class scanController. Les intéractions liées à la page scan se font ici
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class scanController extends Controller
{    
    /**
     * updatePieceCount
     *
     * va incrémenter ou décrémenter le nombre de pièces scannées en fonction du clique
     * @param  mixed $request
     * @return json
     */
    public function updatePieceCount(Request $request)
    {
        $label = $request->input('label');
        $delta = $request->input('delta');
        $num = session('num');
        $num[$label] += $delta;
        session(['num' => $num]);
        return response()->json(['success' => true]);
    }
    
    /**
     * submit
     * fonction qui va gérer le formulaire de scan et lancer le processus IA
     * @param  mixed $request
     * @return void
     */
    public function submit(Request $request)
    {
        ini_set('memory_limit', '4096M');
        set_time_limit(60);

        // Validation côté serveur
        $request->validate([
            'name' => 'required|string|max:50',
            'class' => 'required|string|max:6',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'id' => 'required|integer',
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
        session(['val' => $val]);
        if($request->id != 0){
            session(['id' => $request->id]);
            $id = $request->id;
        }
        else{
            $id = 0;
        }
        

        return view('home')->with('name', $request->name)
            ->with('class', $request->class)
            ->with('desc', $desc)
            ->with('id', $id)
            ->with('bricks', $this->getBricks());
    }
    
    /**
     * cleanJSON
     *
     * nettoie le JSON renvoyé par le script python afin de le rendre exploitable
     * @param  mixed $val
     * @return json
     */
    private function cleanJSON($val)
    {
        // Enlève le caractère à la fin
        $val = preg_replace('/}\s*[^}]*$/', '}', $val);

        // Remplace le guillement simple par double
        $val = str_replace("'", '"', $val);

        // Mettre les guillemets sur les clés
        $val = preg_replace('/([{,]\s*)(\w+)\s*:/', '$1"$2":', $val);

        return json_decode($val, true);
    }
    
    /**
     * getNum
     *
     * permet de récupérer le nombre de pièces scannées (si certaines apparaissent plusieurs fois cela sert)
     * @param  mixed $val
     * @return array
     */
    private function getNum($val)
    {
        $labels = array_column($val['results'], 'label');

        return array_count_values($labels);
    }
    
    /**
     * getData
     *
     * permet de récupérer la description des pièces scannées
     * @param  mixed $val
     * @return array
     */
    private function getData($val)
    {
        $descriptions = [];
        foreach ($val['results'] as $result) {
            $num = explode(' - ', $result['label']);
            $descriptions[$result['label']] = DB::table('t_pieces')->where('pie_numero', $num[0])->value('pie_description');
        }
        return $descriptions;
    }
    
    /**
     * searchDescription
     *
     * fonction qui va récupérer la description de la pièce qui sera selectionnée lors du clique sur le +
     * @param  mixed $request
     * @return json
     */
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
    
    /**
     * getBricks
     *
     * permet de récupérer toutes les pièces de la base de données (pour suggérer dans la datalist)
     * @return array
     */
    private function getBricks()
    {
        $bricks = [];
        $vals = DB::table('t_pieces')->get();
        foreach ($vals as $val) {
            $bricks[] = $val->pie_numero . " - " . $val->pie_couleur;
        }
        return $bricks;
    }
    
    /**
     * removeItem
     *
     * fonction qui va supprimer un élément de la liste des pièces scannées (donc avant validation)
     * @param  mixed $request
     * @return json
     */
    public function removeItem(Request $request)
    {
        $label = $request->input('label');
        $val = session('val');

        //permet de supprimer le bon élément de la liste
        $val['results'] = array_filter($val['results'], function ($item) use ($label) {
            return $item['label'] !== $label;
        });

        // Supprime aussi l'élément de la session num
        $num = session('num');
        unset($num[$label]);

        // Mets à jour les variables de session
        session(['val' => $val]);
        session(['num' => $num]);
        return response()->json(['success' => true]);
    }
    
    /**
     * addItem
     *
     * fonction lors du clique du + elle permet de prendre la valeur noté pour l'ajouter à la liste temporaire (avant validation donc)
     * @param  mixed $request
     * @return json
     */
    public function addItem(Request $request)
    {
        $label = $request->input('input');
        $val = session('val');
        $val['results'][] = [
            'label' => $label,
        ];
        session(['val' => $val]);
        $num = session('num');
        $num[$label] = 1;
        session(['num' => $num]);
        return response()->json(['success' => true]);
    }
}

<?php
/*
ETML
Auteur: Maël Gétain
Date: 21.05.2025
Description: Class listController. Les intéractions liées à la page inventaire se font ici
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SweetAlert2\Laravel\Swal;

class listController extends Controller
{

    /**
     * inventory
     * 
     * cette fonction permet d'inventorier les pièces scannées au bon élève
     * @param  mixed $request
     * @return void
     */
    public function inventory(Request $request)
    {
        if (session('val') == true && session('val')['results'] != []) {
            $request->validate([
                'name' => 'required|string|max:50',
                'class' => 'required|string|max:6',
            ]);

            if (null == session('id'))
                DB::table('t_eleves')->insert([
                    'ele_nom' => $request->name,
                    'ele_classe' => $request->class,
                ]);

            $eleveID = DB::table('t_eleves')->where('ele_nom', $request->name)->value('ele_id');

            $pieces = session('val');
            $num = session('num');

            foreach ($pieces['results'] as $piece) {
                $label = explode(' - ', $piece['label'])[0];
                $pieceID = DB::table('t_pieces')->where('pie_numero', $label)->value('pie_id');
                DB::table('t_posseders')->insert([
                    'fk_pie_id' => $pieceID,
                    'fk_ele_id' => $eleveID,
                    'pos_quantite' => $num[$piece['label']]
                ]);
            }
            Swal::toastInfo([
                'title' => 'Éléments ajoutés à l\'inventaire',
                'icon' => 'success',
                'position' => 'bottom-end',
            ]);

            session()->forget(['val', 'num']);
        }
        else{
            Swal::toastInfo([
                'title' => 'Aucune pièce dans la liste',
                'icon' => 'error',
                'position' => 'bottom-end',
            ]);
        }

        return redirect()->route('home');
    }

    /**
     * getInventory
     *
     * fonction qui  permet de récupérer toutes les valeurs inventoriées
     * @return void
     */
    private function getInventory()
    {
        $inventory = DB::table('t_posseders')
            ->join('t_pieces', 't_posseders.fk_pie_id', '=', 't_pieces.pie_id')
            ->join('t_eleves', 't_posseders.fk_ele_id', '=', 't_eleves.ele_id')
            ->select('t_pieces.pie_numero', 't_pieces.pie_couleur', 't_eleves.ele_nom', 't_eleves.ele_classe', 't_posseders.pos_quantite', 't_pieces.pie_description', 't_eleves.ele_id', 't_pieces.pie_id')
            ->get()->toArray();
        $finalInventory = [];
        foreach ($inventory as $item) {
            $key = $item->ele_id;
            if (!isset($finalInventory[$key])) {
                $finalInventory[$key] = [
                    'class' => $item->ele_classe,
                    'name' => $item->ele_nom,
                    'pieces' => []
                ];
            }

            $finalInventory[$key]['pieces'][] = [
                'id' => $item->pie_id,
                'numero' => $item->pie_numero,
                'couleur' => $item->pie_couleur,
                'description' => $item->pie_description,
                'quantite' => $item->pos_quantite
            ];
        }

        return $finalInventory;
    }

    /**
     * showInventory
     *
     * fonction qui va afficher l'inventaire avec ses valeurs
     * @return void
     */
    public function showInventory()
    {
        $val = $this->getInventory();
        return view('inventaire', ['inventory' => $val, 'id' => '']);
    }

    /**
     * verify
     *
     * fonction qui va appeler la page de scan tout en lui spécifiant l'id de l'élève à controler
     * @param  mixed $id
     * @return void
     */
    public function verify($id)
    {
        $name = DB::table('t_eleves')->where('ele_id', $id)->value('ele_nom');
        $class = DB::table('t_eleves')->where('ele_id', $id)->value('ele_classe');
        return view('home')
            ->with('name', $name)
            ->with('class', $class)
            ->with('val', '')
            ->with('num', '')
            ->with('desc', '')
            ->with('bricks', [])
            ->with('id', $id);
    }

    /**
     * check
     *
     * fonction qui va nous vérifier si le retour correspond à l'inventaire. Elle va renvoyer la liste de pièces retournées afin de la travailler dans la vue
     * @param  mixed $request
     * @return void
     */
    public function check(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);


        $scanned = session('val');
        $howMany = session('num');
        $piecesScanned = [];
        foreach ($scanned['results'] as $piece) {
            $label = explode(' - ', $piece['label'])[0];
            $pieceID = DB::table('t_pieces')->where('pie_numero', $label)->value('pie_id');
            $piecesScanned[$pieceID] = $howMany[$piece['label']];
        }

        session()->forget(['val', 'num']);
        return view('inventaire', ['inventory' => $this->getInventory(), 'scanned' => $piecesScanned, 'id' => $request->id]);
    }

    /**
     * delete
     *
     * supprime les pièces asociées à l'élève de l'inventaire
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
        DB::table('t_posseders')->where('fk_ele_id', $id)->delete();
        Swal::toastInfo([
            'title' => 'L\'enregistrement a bien été retiré de l\'inventaire',
            'icon' => 'success',
            'position' => 'bottom-end',
        ]);
        return redirect()->route('inventaire');
    }
}

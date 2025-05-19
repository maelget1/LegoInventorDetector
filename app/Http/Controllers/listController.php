<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SweetAlert2\Laravel\Swal;

class listController extends Controller
{
    //
    public function inventory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'class' => 'required|string|max:6',
        ]);

        if(null !== session('id'))
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

        return redirect()->route('home');
    }

    public function showInventory()
    {
        $inventory = DB::table('t_posseders')
            ->join('t_pieces', 't_posseders.fk_pie_id', '=', 't_pieces.pie_id')
            ->join('t_eleves', 't_posseders.fk_ele_id', '=', 't_eleves.ele_id')
            ->select('t_pieces.pie_numero', 't_pieces.pie_couleur', 't_eleves.ele_nom', 't_eleves.ele_classe', 't_posseders.pos_quantite', 't_pieces.pie_description', 't_eleves.ele_id')
            ->get();
        $inventory = collect($inventory)->groupBy('ele_nom')->toArray();

        return view('inventaire',['inventory' => $inventory]);
    }

    public function verify($id){
        $value = DB::table('t_eleves')->where('ele_id', $id)->value('ele_nom', 'ele_classe');
        return view('home')
            ->with('name', $value->ele_nom)
            ->with('class', $value->ele_classe)
            ->with('val', '')
            ->with('num', '')
            ->with('desc', '')
            ->with('bricks', [])
            ->with('id', $id);
    }
}

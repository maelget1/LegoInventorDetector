<?php
/*
ETML
Auteur: Maël Gétain
Date: 21.05.2025
Description: Class baseController. Les intéractions basique lié au démarrage de l'application
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class baseController extends Controller
{
    /**
     * home
     *
     * permet de revenir à la page d'accueil (et de remettre les sessions à 0 dans le même temps)
     * @return void
     */
    public function home()
    {
        session()->forget(['val', 'num', 'id']);
        return view('home')->with('name', '')->with('class', '')->with('val', '')->with('num', '')->with('desc', '')->with('bricks', [])->with('id', 0);
    }
}

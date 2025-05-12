<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Chemin vers le fichier CSV
        $csvFile = public_path('parts.csv');
        
        // Vérifier si le fichier existe
        if (!file_exists($csvFile)) {
            echo "Fichier CSV introuvable: $csvFile\n";
            return;
        }
        
        // Ouvrir le fichier en mode lecture
        $file = fopen($csvFile, 'r');
        
        // Lire l'en-tête (première ligne)
        $header = fgetcsv($file, 0, ';');
        
        // Lire les données ligne par ligne
        while (($data = fgetcsv($file, 0, ';')) !== FALSE) {
            if (count($data) === 4) { // vérifie le nombre de colonnes
                DB::table('t_pieces')->insert([
                    'pie_numero' => $data[0],
                    'pie_quantite' => $data[1],
                    'pie_couleur' => $data[2],
                    'pie_description' => $data[3]
                ]);
            }
        }
        
        fclose($file);
        
        echo "Importation terminée !\n";
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_pieces', function (Blueprint $table) {
            $table->increments('pie_id');
            $table->string('pie_numero',20);
            $table->integer('pie_quantite',);
            $table->string('pie_couleur',50);
            $table->text('pie_description');
            $table->primary('pie_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_pieces');
    }
};

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
        Schema::create('t_posseders', function (Blueprint $table) {
            $table->unsignedInteger('fk_pie_id',);
            $table->unsignedInteger('fk_ele_id',);
            $table->integer('pos_quantite',);
            $table->primary(['fk_pie_id', 'fk_ele_id']);
            $table->foreign('fk_pie_id')->references('pie_id')->on('t_pieces')->onDelete('cascade');
            $table->foreign('fk_ele_id')->references('ele_id')->on('t_eleves')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_posseders');
    }
};

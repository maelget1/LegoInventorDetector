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
        Schema::create('t_eleves', function (Blueprint $table) {
            $table->increments('ele_id');
            $table->string('ele_nom',50);
            $table->string('ele_classe',6);
            $table->primary('ele_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_eleves');
    }
};

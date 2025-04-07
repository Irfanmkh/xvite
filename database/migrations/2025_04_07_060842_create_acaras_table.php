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
        Schema::create('acaras', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->id();
            $table->date('tgl_resepsi');
            $table->date('tgl_akad')->nullable();
            $table->time('jam_akad')->nullable();
            $table->time('jam_resepsi');
            $table->string('venue');
            $table->string('venue_akad')->nullable();
            $table->string('lokasi');
            $table->string('link_maps');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acaras');
    }
};

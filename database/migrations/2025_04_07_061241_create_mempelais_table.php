<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mempelais', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->id();
            $table->string('fullname_pria');
            $table->string('anakKe_pria');
            $table->string('fullname_wanita');
            $table->string('anakKe_wanita');
            $table->string('nickname_pria');
            $table->string('ig_pria')->nullable();
            $table->string('nickname_wanita');
            $table->string('ig_wanita')->nullable();
            $table->string('namaAyah_pria');
            $table->string('namaIbu_pria');
            $table->string('namaAyah_wanita');
            $table->string('namaIbu_wanita');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mempelais');
    }
};

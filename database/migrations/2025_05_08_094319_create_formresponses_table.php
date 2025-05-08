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
        Schema::create('formresponses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // relasi ke users
            $table->foreignId('tema_id')->constrained()->onDelete('cascade'); // relasi ke temas

            $table->string('field_name');  // Nama field (misal: nama_pria, lokasi_akad)
            $table->text('value')->nullable(); // Isi dari form, bisa teks panjang


            $table->unique(['user_id', 'tema_id', 'field_name']); // Unik per user-tema-field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formresponses');
    }
};

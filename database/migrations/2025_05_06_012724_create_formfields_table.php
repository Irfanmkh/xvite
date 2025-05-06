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
        Schema::create('formfields', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('label');
            $table->enum('tipe', ['text', 'textarea', 'file', 'date']); // tipe input
            $table->boolean('is_required')->default(false);
            $table->integer('order')->default(0); // urutan tampil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formfields');
    }
};

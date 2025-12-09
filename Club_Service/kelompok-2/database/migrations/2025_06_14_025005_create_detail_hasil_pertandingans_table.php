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
        Schema::create('detail_hasil_pertandingans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hasil_pertandingan_id')->constrained('hasil_pertandingans')->onDelete('cascade');
            $table->string('nama');

            // Kolom lemparan 1–5
            $table->float('lemparan1')->nullable();
            $table->float('lemparan2')->nullable();
            $table->float('lemparan3')->nullable();
            $table->float('lemparan4')->nullable();
            $table->float('lemparan5')->nullable();
            $table->float('skor')->nullable();
            $table->integer('rangking')->nullable();
            $table->text('catatan_juri')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_hasil_pertandingans');
    }
};

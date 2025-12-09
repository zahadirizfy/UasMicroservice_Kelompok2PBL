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
        Schema::create('pertandingans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pertandingan');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Relasi ke tabel penyelenggara_events
            $table->foreignId('penyelenggara_event_id')
                  ->constrained('penyelenggara_events')
                  ->onDelete('cascade');

            // Relasi ke tabel juris
            $table->foreignId('juri_id')
                  ->constrained('juris')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertandingans');
    }
};

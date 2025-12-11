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
        Schema::create('jadwal_pertandingans', function (Blueprint $table) {
            $table->id();

            // Relasi ke pertandingan
            $table->foreignId('pertandingan_id')
                ->constrained('pertandingans')
                ->onDelete('cascade');

            // Kolom data jadwal
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('lokasi');
            $table->text('deskripsi')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pertandingans');
    }
};

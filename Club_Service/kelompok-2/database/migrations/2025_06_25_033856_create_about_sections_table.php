<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi_singkat'); // deskripsi pendek (kiri)
            $table->text('deskripsi_lengkap'); // deskripsi panjang (kanan)
            $table->string('image'); // gambar kiri
            $table->string('second_image')->nullable(); // gambar kanan
            $table->string('video_link')->nullable(); // link video YouTube
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};

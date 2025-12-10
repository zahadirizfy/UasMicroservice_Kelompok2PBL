<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapLatihansTable extends Migration
{
    public function up()
    {
        Schema::create('rekap_latihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->unsignedTinyInteger('jarak');
            $table->decimal('lemparan1', 5, 2)->nullable();
            $table->decimal('lemparan2', 5, 2)->nullable();
            $table->decimal('lemparan3', 5, 2)->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekap_latihans');
    }
}

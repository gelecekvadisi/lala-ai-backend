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
        Schema::create('exams', function (Blueprint $table) {
            $table->string('id')->primary(); // id alanını string ve primary key olarak ayarlıyoruz
            $table->string("name");
            $table->string("image_name");
            $table->string("assistant_id");
            $table->string("sinif_duzeyi");
            $table->string("soru_sayisi");
            $table->string("zorluk_seviyesi");
            $table->string("konu");
            $table->string("spreadsheet_id");
            $table->boolean("status")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};

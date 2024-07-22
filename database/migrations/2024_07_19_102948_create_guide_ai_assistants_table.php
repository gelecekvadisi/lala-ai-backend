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
        Schema::create('guide_ai_assistants', function (Blueprint $table) {
            $table->string('id')->primary(); // id alanını string ve primary key olarak ayarlıyoruz
            $table->string('name');
            $table->string('image_name');
            $table->string('assistant_id');
            $table->string('inputs');
            $table->string('instructions_generator');
            $table->string('spreadsheet_name');
            $table->string('spreadsheet_id');
            $table->boolean("status")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guide_ai_assistants');
    }
};

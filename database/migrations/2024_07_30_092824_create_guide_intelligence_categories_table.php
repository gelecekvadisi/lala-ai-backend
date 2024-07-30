<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuideIntelligenceCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('guide_intelligence_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('google_sheet_name');
            $table->string('image_name');
            $table->text('inputs');
            $table->text('instructions_generator');
            $table->text('google_sheets_columns');
            $table->integer('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guide_intelligence_categories');
    }
}
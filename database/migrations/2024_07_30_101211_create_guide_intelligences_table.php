<?php

use App\Models\GuideIntelligenceCategory;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuideIntelligencesTable extends Migration
{
    public function up()
    {
        Schema::create('guide_intelligences', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('assistant_id');
            $table->string('google_sheets_id');
            $table->string('image_name');
            $table->text('data');
            $table->integer('status');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(GuideIntelligenceCategory::class, 'category_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guide_intelligences');
    }
}

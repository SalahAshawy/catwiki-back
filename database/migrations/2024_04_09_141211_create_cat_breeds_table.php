<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatBreedsTable extends Migration
{
    public function up()
    {
        Schema::create('cat_breeds', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->text('description')->nullable();        
            $table->string('temperament')->nullable();
            $table->string('origin')->nullable();
            $table->string('life_span')->nullable();
            $table->integer('adaptability')->nullable();
            $table->integer('affection_level')->nullable();
            $table->integer('child_friendly')->nullable();
            $table->integer('grooming')->nullable();
            $table->integer('intelligence')->nullable();
            $table->integer('health_issues')->nullable();
            $table->integer('social_needs')->nullable();
            $table->integer('stranger_friendly')->nullable();
            $table->integer('search_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cat_breeds');
    }
}

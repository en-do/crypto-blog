<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parsings', function (Blueprint $table) {
            $table->id();

            $table->integer('domain_id');
            $table->string('query');
            $table->string('language')->default('en');
            $table->string('country')->nullable();
            $table->date('from_at')->nullable();
            $table->date('to_at')->nullable();
            $table->enum('sort', ['relevancy', 'popularity', 'publishedAt', 'random'])->default('publishedAt');
            $table->integer('limit')->default(100);
            $table->boolean('active')->default(false);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parsings');
    }
};

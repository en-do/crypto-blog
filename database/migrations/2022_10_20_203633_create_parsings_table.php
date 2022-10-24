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
            $table->integer('category_id');
            $table->string('query');
            $table->string('category');
            $table->string('language');
            $table->string('country');
            $table->string('sort_by');
            $table->date('from_at');
            $table->date('to_at');
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

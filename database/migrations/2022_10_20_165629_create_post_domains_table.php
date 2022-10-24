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
        Schema::create('post_domains', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('domain_id');
            $table->unsignedBigInteger('post_id');
            $table->foreign('domain_id')->references('id')->on('domains');
            $table->foreign('post_id')->references('id')->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_domains');
    }
};

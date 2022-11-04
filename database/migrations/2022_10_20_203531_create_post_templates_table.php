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
        Schema::create('post_templates', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id');
            $table->integer('domain_id')->nullable();
            $table->string('image');
            $table->string('title');
            $table->text('vars');
            $table->text('content');
            $table->integer('order')->default(0);
            $table->string('slug');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
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
        Schema::dropIfExists('post_templates');
    }
};

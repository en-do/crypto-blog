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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id');
            $table->string('image')->nullable();
            $table->string('title');
            $table->text('content')->nullable();
            $table->integer('order')->default(0);
            $table->integer('view')->default(0);
            $table->string('slug')->unique();
            $table->enum('source', ['dashboard', 'parsing', 'template'])->default('dashboard');
            $table->enum('status', ['published', 'draft', 'moderation'])->default('moderation');

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
        Schema::dropIfExists('posts');
    }
};

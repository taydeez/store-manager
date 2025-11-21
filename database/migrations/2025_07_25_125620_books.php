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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('added_by')->unsigned();
            $table->string('title');
            $table->string('image_url')->nullable();
            $table->integer('quantity');
            $table->float('price');
            $table->json('tags')->nullable();
            $table->enum('available', ['true', 'false'])->default('true');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('added_by')->references('id')->on('users')->onDelete('no action');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['added_by']);
        });
        Schema::dropIfExists('books');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('store_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id')->nullable();
            $table->unsignedBigInteger('store_front_id');
            $table->integer('book_quantity');
            $table->string('stocked_quantity');
            $table->enum('is_available', ['true', 'false'])->default('true');
            $table->enum('admin_disabled', ['true', 'false'])->default(null)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('store_front_id')->references('id')->on('store_fronts')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_inventories', function (Blueprint $table) {
            //$table->dropForeign(['store_front_id']);
            $table->dropForeign(['books']);
        });
        Schema::dropIfExists('store_inventories');
    }
};

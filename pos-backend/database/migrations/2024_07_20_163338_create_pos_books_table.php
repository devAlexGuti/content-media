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
        Schema::create('pos_book', function (Blueprint $table) {
            $table->id('book_id');
            $table->string('isbn',13)->nullable()->unique();
            $table->string('name',100)->nullable();
            $table->integer('stock')->nullable();
            $table->decimal('current_price', 10, 2)->nullable();
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
        Schema::dropIfExists('pos_book');
    }
};

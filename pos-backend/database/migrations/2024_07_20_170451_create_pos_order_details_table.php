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
        Schema::create('pos_order_detail', function (Blueprint $table) {
            $table->id('order_detail_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('book_id');
            $table->decimal('detail_price', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('pos_order')->onDelete('cascade');
            $table->foreign('book_id')->references('book_id')->on('pos_book')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pos_order_detail');
    }
};

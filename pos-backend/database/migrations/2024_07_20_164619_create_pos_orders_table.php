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
        Schema::create('pos_order', function (Blueprint $table) {
            $table->id('order_id');
            $table->unsignedBigInteger('client_id')->nullable()->unique();
            $table->decimal('total', 10, 2)->nullable();
            $table->tinyInteger('doc_type')->nullable();
            $table->string('doc_number', 20)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('client_id')->on('pos_client')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pos_order');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarminventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farminventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('farm_id');
            $table->unsignedBigInteger('farm_item_id');
            $table->decimal('quantity', 10, 2);
            $table->string('unit'); // kg, liters, etc.
            $table->text('notes')->nullable();
            $table->date('collected_on');
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('farm_id')->references('id')->on('farms')->onDelete('cascade');
            $table->foreign('farm_item_id')->references('id')->on('farm_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farminventories');
    }
}

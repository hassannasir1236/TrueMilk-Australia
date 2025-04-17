<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('phone', 20);
            $table->text('description')->nullable();
            
            // link to states table
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')
                ->references('id')->on('states')
                ->onDelete('cascade');
            
            // owner (user) — in case you want to assign a farm to a user
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('set null');
            
            // extras for future features:
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->decimal('farm_size', 8, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            
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
        Schema::dropIfExists('farms');
    }
}

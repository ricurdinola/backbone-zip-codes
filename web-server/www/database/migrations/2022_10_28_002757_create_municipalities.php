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
        Schema::create('municipalities', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('name',100);
            $table->foreignId('federal_entity_id')->references('id')->on('federal_entities');
            $table->timestamps();
            $table->softdeletes();
            $table->primary(['id', 'federal_entity_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('municipalities');
    }
};

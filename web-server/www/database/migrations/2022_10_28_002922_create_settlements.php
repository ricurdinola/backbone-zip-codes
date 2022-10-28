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
        Schema::create('settlements', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('name',150);
            $table->foreignId('municipality_id')->references('id')->on('municipalities');
            $table->foreignId('federal_entity_id')->references('id')->on('federal_entities');

            $table->string('zip_code',6);
            //$table->string('d_cp',6);
            //$table->string('c_oficina',6);
            $table->foreignId('zone_id')->references('id')->on('zones_types');
            $table->foreignId('settlement_type_id')->references('id')->on('settlements_types');
            $table->string('locality_name',150)->nullable();

            $table->primary(['id', 'municipality_id','federal_entity_id']);
            $table->timestamps();
            $table->softdeletes();
            $table->index('zip_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settlements');
    }
};

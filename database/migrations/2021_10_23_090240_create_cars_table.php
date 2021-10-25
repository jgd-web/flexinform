<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id')->index()->comment('ügyfél autójának azonosítója (ügyfelenként egyedi)');
            $table->unsignedBigInteger('client_id')->index()->comment('ügyfél egyedi azonosítója');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unique(['car_id', 'client_id']);
            $table->string('type', 10)->comment('szerviz alkalom (ügyfél és autójaként egyedi)');
            $table->dateTime('registered')->comment('regisztrálás időpontja');
            $table->unsignedTinyInteger('ownbrand')->comment('értéke 1 ha saját márkás, értéke 0 ha nem saját márkás');
            $table->smallInteger('accident')->comment('balesetek száma');
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
        Schema::dropIfExists('cars');
    }
}

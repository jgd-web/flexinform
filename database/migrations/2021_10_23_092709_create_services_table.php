<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->index()->comment('ügyfél egyedi azonosítója');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('car_id')->index()->comment('ügyfél autójának azonosítója (ügyfelenként egyedi)');
            $table->unsignedSmallInteger('lognumber')->index()->comment('szerviz alkalom (ügyfél és autójaként egyedi)');
            $table->unique(['car_id', 'client_id', 'lognumber']);
            $table->string('event', 100)->comment('esemény típusa');
            $table->dateTime('eventtime')->nullable()->comment('esemény időpontja');
            $table->unsignedInteger('document_id')->index()->comment('munkanlap azonosítója');
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
        Schema::dropIfExists('services');
    }
}

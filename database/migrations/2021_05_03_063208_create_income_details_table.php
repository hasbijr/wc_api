<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('income_id');
            $table->dateTime('tanggal_donasi');
            $table->text('no_referensi');
            $table->text('nama');
            $table->text('handphone');
            $table->integer('nominal');
            $table->longText('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('income_id')->references('id')->on('incomes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income_details');
    }
}

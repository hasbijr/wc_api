<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutcomeDistributionPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outcome_distribution_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outcome_distribution_id');
            $table->unsignedBigInteger('distribution_type_id')->nullable();
            $table->string('nama_point');
            $table->date('tanggal')->nullable();
            $table->integer('jumlah_dana');
            $table->integer('jumlah_paket')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('outcome_distribution_id', 'od_foreign')->references('id')->on('outcome_distributions');
            $table->foreign('distribution_type_id', 'jd_foreign')->references('id')->on('distribution_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outcome_distribution_points');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutcomeDistributionPointEvidencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outcome_distribution_point_evidences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outcome_distribution_point_id');
            $table->string('nama_file');
            $table->string('path');
            $table->string('ekstensi');
            $table->integer('ukuran');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('outcome_distribution_point_id', 'odp_id_foreign')->references('id')->on('outcome_distribution_points');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outcome_distribution_point_evidences');
    }
}

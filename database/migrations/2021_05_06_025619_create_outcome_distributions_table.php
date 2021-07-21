<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutcomeDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outcome_distributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outcome_id');
            $table->enum('tipe', ['agen', 'yayasan']);
            $table->unsignedBigInteger('campaign_agent_id')->nullable();
            $table->integer('nominal');
            $table->integer('biaya_administrasi');
            $table->boolean('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('outcome_id')->references('id')->on('outcomes');
            $table->foreign('campaign_agent_id')->references('id')->on('campaign_agents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outcome_distributions');
    }
}

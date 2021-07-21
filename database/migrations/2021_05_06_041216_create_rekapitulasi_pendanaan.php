<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRekapitulasiPendanaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE VIEW rekapitulasi_pendanaan as
        SELECT DISTINCT
            \'income\' AS type,
            a.campaign_id as campaign_id,
            sum( b.nominal ) AS nominal,
            a.sumber_dana AS sumber_dana,
            a.id AS pendanaan_id,
            a.created_at AS created_at
        FROM
            incomes a
            JOIN income_details b ON b.income_id = a.id
        GROUP BY
            a.campaign_id,
            a.id,
            a.sumber_dana,
            a.created_at

        UNION

        SELECT DISTINCT
            \'outcome\' AS type,
            a.campaign_id AS campaign_id,
            (sum( nominal ) + sum( biaya_administrasi )) AS nominal,
            \'\' AS sumber_dana,
            a.id AS pendanaan_id,
            a.created_at AS created_at
        FROM
            outcomes a
            LEFT JOIN outcome_distributions b ON b.outcome_id = a.id
        GROUP BY
            a.campaign_id,
            a.id,
            a.created_at
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW rekapitulasi_pendanaan');
    }
}

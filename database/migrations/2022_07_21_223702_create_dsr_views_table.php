<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDsrViewsTable extends Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement('
            CREATE OR REPLACE VIEW dsr_views AS
            SELECT dsr.case_id, dsr.latest_ebitda, dsr.commitment_as_per_ccris, (sum(dsr.e75)*12) + sum(dsr.e80) AS total_financing_commitment
            FROM (
                SELECT cl.id AS case_id, cf.ebitda AS latest_ebitda, cc.final_total*12 AS commitment_as_per_ccris, SUM(cfi.proposed_limit) AS e75, 0 AS e80
                FROM case_financials cf
                LEFT JOIN case_lists cl ON cf.case_id = cl.id
                LEFT JOIN case_commitments cc ON cl.id = cc.case_id
                LEFT JOIN case_financing_instruments cfi ON cfi.case_id = cl.id
                WHERE cf.group_id = 1 AND cfi.financing_instrument_id != 7
                AND ISNULL(cf.deleted_at)
                AND ISNULL(cl.deleted_at)
                AND ISNULL(cc.deleted_at)
                AND ISNULL(cfi.deleted_at)

                UNION

                SELECT cl.id AS case_id, cf.ebitda AS latest_ebitda, cc.final_total*12 AS commitment_as_per_ccris, 0 AS e75, cfi.proposed_limit AS e80
                FROM case_financials cf
                LEFT JOIN case_lists cl ON cf.case_id = cl.id
                LEFT JOIN case_commitments cc ON cl.id = cc.case_id
                LEFT JOIN case_financing_instruments cfi ON cfi.case_id = cl.id
                WHERE cf.group_id = 1 AND cfi.financing_instrument_id = 7
                AND ISNULL(cf.deleted_at)
                AND ISNULL(cl.deleted_at)
                AND ISNULL(cc.deleted_at)
                AND ISNULL(cfi.deleted_at)

                UNION

                SELECT cl.id AS case_id, cf.ebitda AS latest_ebitda, cc.final_total*12 AS commitment_as_per_ccris, 0 AS e75, 0 AS e80
                FROM case_financials cf
                LEFT JOIN case_lists cl ON cf.case_id = cl.id
                LEFT JOIN case_commitments cc ON cl.id = cc.case_id
                WHERE cf.group_id = 1
                AND ISNULL(cf.deleted_at)
                AND ISNULL(cl.deleted_at)
                AND ISNULL(cc.deleted_at)

            ) AS dsr
            GROUP BY dsr.case_id
        ');
    }

    public function down()
    {
        Schema::dropIfExists('dsr_views');
    }
}

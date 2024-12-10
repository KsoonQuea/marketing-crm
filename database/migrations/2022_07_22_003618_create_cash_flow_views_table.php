<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashFlowViewsTable extends Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement('
            CREATE OR REPLACE VIEW cash_flow_views AS
            SELECT cl.id AS case_id, bs.total_avg_credit AS bankStt_credit, bs.total_avg_month_end_balance AS bankStt_month,
cc.final_total AS case_commitment_total, cdc.final_total AS director_commitment_total
FROM case_commitments cc
LEFT JOIN case_lists cl ON cc.case_id = cl.id
LEFT JOIN bank_statements bs ON cl.id = bs.case_id
LEFT JOIN case_director_commitments cdc ON cdc.case_id = cl.id
WHERE ISNULL(cc.deleted_at)
AND ISNULL(cl.deleted_at)
AND ISNULL(bs.deleted_at)
AND ISNULL(cdc.deleted_at)
        ');
    }

    public function down()
    {
        Schema::dropIfExists('cash_flow_views');
    }
}

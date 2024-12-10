<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseGearingViewsTable extends Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement('
            CREATE OR REPLACE VIEW case_gearing_views as
            SELECT gearing.case_id, gearing.total_tnw, SUM(gearing.new_financing_amount) AS new_financing_amount FROM (
	SELECT cl.id AS case_id, cf.tnw AS total_tnw , 0 AS new_financing_amount
   FROM case_financials cf
   LEFT JOIN case_lists cl ON cf.case_id = cl.id
   WHERE cf.group_id = 1 AND ISNULL(`cf`.`deleted_at`) AND ISNULL(`cl`.`deleted_at`)

   union

   SELECT cl.id AS case_id, cf.tnw AS total_tnw , cfi.total_proposed_limit AS new_financing_amount
   FROM case_financials cf
   LEFT JOIN case_lists cl ON cf.case_id = cl.id
   LEFT JOIN case_financing_instruments cfi ON cl.id = cfi.case_id
   WHERE cf.group_id = 1 AND ISNULL(`cf`.`deleted_at`) AND ISNULL(`cfi`.`deleted_at`) AND ISNULL(`cl`.`deleted_at`)
) AS gearing
GROUP BY gearing.case_id
        ');
    }

    public function down()
    {
        Schema::dropIfExists('case_gearing_views');
    }
}

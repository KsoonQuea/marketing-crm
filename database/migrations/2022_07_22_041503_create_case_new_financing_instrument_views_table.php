<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseNewFinancingInstrumentViewsTable extends Migration
{
    public function up()
    {

        \Illuminate\Support\Facades\DB::statement('
            CREATE OR REPLACE VIEW case_new_financing_instrument_views as
            SELECT cfi.case_id, fi.loan_product, cfi.proposed_limit, cfi.interest_rate,  cfi.tenor AS tenor_value,
fi.able_edit_type, fi.tenor AS tenor_name, cfi.commitments, cfi.total_proposed_limit, cfi.total_commitments
FROM case_financing_instruments cfi
LEFT JOIN financing_instruments fi ON cfi.financing_instrument_id = fi.id
WHERE ISNULL(`cfi`.`deleted_at`) AND ISNULL(`fi`.`deleted_at`)
        ');
    }

    public function down()
    {
        Schema::dropIfExists('case_new_financing_instrument_views');
    }
}

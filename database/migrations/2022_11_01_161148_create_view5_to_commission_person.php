<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateView5ToCommissionPerson extends Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("
                CREATE OR REPLACE VIEW commission_person_report as
                SELECT cmsd_report.*,  SUM(cmsd_report.cms) AS 'total_cms' FROM(

SELECT YEAR(payments.date) AS 'or_year', MONTH(payments.date) AS 'or_month',
payments.date AS 'or_date',
users.id AS 'user_id', users.name, if(SUM(overridings.commission) IS NULL, 0 , SUM(overridings.commission)) AS 'cms'
FROM users
left JOIN case_overridings AS overridings ON users.id = overridings.user_id
left JOIN case_disburse_details AS details ON details.id = overridings.case_disburse_detail_id
left JOIN payments ON payments.case_disburse_detail_id = details.id

WHERE overridings.deleted_at IS NULL AND details.deleted_at IS NULL AND payments.deleted_at IS NULL

GROUP BY users.id

UNION

SELECT YEAR(payments.date) AS 'or_year', MONTH(payments.date) AS 'or_month',
payments.date AS 'or_date',
users.id AS 'user_id', users.name, if(SUM(details.bfe_commission) IS NULL, 0 , SUM(details.bfe_commission)) AS 'cms'

FROM users
left JOIN case_lists AS cases ON cases.salesman_id = users.id
left JOIN case_disburses AS disburses ON disburses.case_list_id = cases.id
left JOIN case_disburse_details AS details ON disburses.id = details.case_disburse_id
left JOIN payments ON payments.case_disburse_detail_id = details.id

WHERE cases.deleted_at IS NULL AND disburses.deleted_at IS NULL AND details.deleted_at IS NULL AND payments.deleted_at IS NULL

GROUP BY users.id

) AS cmsd_report

GROUP BY cmsd_report.or_year, cmsd_report.or_month, cmsd_report.user_id
;
            ");
    }

    public function down()
    {
        Schema::dropIfExists('view5_to_commission_person');
    }
}

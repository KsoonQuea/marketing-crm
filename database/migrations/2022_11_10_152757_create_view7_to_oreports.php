<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateView7ToOreports extends Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("
                CREATE OR REPLACE VIEW outstanding_reports as
                SELECT o_report.*, (o_report.fee + o_report.sst + o_report.disb) AS 'total'
FROM (

SELECT YEAR(invoices.date) AS 'inv_year', MONTH(invoices.date) AS 'inv_month',
invoices.date AS 'inv_date', invoices.file_num AS 'inv_no', invoices.company_name AS 'particular',
disburses.service_fee_amount AS 'fee', if(invoices.sst_status = 1, (disburses.service_fee_amount * 0.06), 0) AS 'sst',
0 AS 'disb',
payments.date AS 'or_date', payments.cheque_no, payments.`or`, payments.sst_paid_date,

invoices.disbursement_type AS 'disbursement_type',
details.payments_status AS 'payment_status',
details.account_stage AS 'account_stage',

details.id AS 'case_disburse_detail_id'

FROM case_disburse_details AS details
LEFT JOIN case_disburses AS disburses ON details.case_disburse_id = disburses.id
left JOIN payments ON payments.case_disburse_detail_id = details.id
JOIN invoices ON invoices.case_disburse_detail_id = details.id

WHERE details.deleted_at IS NULL AND payments.deleted_at IS NULL AND invoices.deleted_at IS NULL
AND details.account_stage >= 2 AND details.case_disburse_id IS NOT NULL AND details.account_stage IS NOT NULL

GROUP BY details.case_disburse_id

union

SELECT YEAR(invoices.date) AS 'inv_year', MONTH(invoices.date) AS 'inv_month',
invoices.date AS 'inv_date', invoices.file_num AS 'inv_no', invoices.company_name AS 'particular',
0 AS 'fee', if(invoices.sst_status = 1, (invoices.service_fee * 0.06), 0) AS 'sst',
invoices.service_fee AS 'disb',
null AS 'or_date', NULL AS 'cheque_no', NULL AS 'or', NULL AS 'sst_paid_date',

invoices.disbursement_type AS 'disbursement_type',
null AS 'payment_status',
null AS 'account_stage',

null AS 'case_disburse_id'

FROM invoices

WHERE invoices.deleted_at IS NULL AND invoices.disbursement_type = 1

) AS o_report
ORDER BY o_report.inv_date, o_report.or_date
            ");
    }

    public function down()
    {
        Schema::dropIfExists('view7_to_oreports');
    }
}

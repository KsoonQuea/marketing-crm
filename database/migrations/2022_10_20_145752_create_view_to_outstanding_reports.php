<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewToOutstandingReports extends Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("
                CREATE OR REPLACE VIEW outstanding_reports as
                SELECT o_report.*, if(o_report.disbursement_type = 1, o_report.fee, 0) AS 'disb', (o_report.fee + o_report.sst) AS 'total'
                FROM (

                SELECT YEAR(invoices.date) AS 'inv_year', MONTH(invoices.date) AS 'inv_month',
                invoices.date AS 'inv_date', invoices.file_num AS 'inv_no', invoices.company_name AS 'particular',
                invoices.service_fee AS 'fee', if(invoices.sst_status = 1, (invoices.service_fee * 6 /100), 0) AS 'sst',
                payments.date AS 'or_date', payments.cheque_no, payments.`or`, payments.sst_paid_date,

                invoices.disbursement_type AS 'disbursement_type',
                details.payments_status AS 'payment_status',
                details.account_stage AS 'account_stage'

                FROM case_lists AS cases
                LEFT JOIN case_disburses AS disburses ON cases.id = disburses.case_list_id
                LEFT JOIN case_disburse_details AS details ON disburses.id = details.case_disburse_id
                LEFT JOIN payments ON payments.case_disburse_detail_id = details.id
                LEFT JOIN invoices ON invoices.case_disburse_detail_id = details.id

                WHERE cases.deleted_at IS NULL AND disburses.deleted_at IS NULL AND details.deleted_at IS NULL AND
                payments.deleted_at IS NULL AND invoices.deleted_at IS NULL

                AND details.account_stage >= 2

                GROUP BY details.case_disburse_id
                ORDER BY invoices.date

                ) AS o_report;
            ");
    }

    public function down()
    {
        Schema::dropIfExists('view_to_outstanding_reports');
    }
}

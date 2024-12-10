<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateView5ToCommissionReports extends Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("
                CREATE OR REPLACE VIEW commission_reports as
                SELECT cms_report.*
                FROM (

                SELECT YEAR(payments.date) AS 'or_year', MONTH(payments.date) AS 'or_month',
                payments.date AS 'or_date', payments.`or` AS 'or', invoices.company_name AS 'particular',
                disburses.approved_amount AS 'approved_amount', invoices.file_num AS 'inv_no', disburses.service_fee_amount AS 'service_amount',
                details.banker_name AS 'banker_name', details.banker_commission AS 'banker_cms', details.banker_commission_pay_day AS 'banker_pay_out',
                cases.salesman_id AS 'bfe_id', bfe_name AS 'bfe_name', details.bfe_commission AS 'bfe_cms', details.bfe_commission_pay_day AS 'bfe_pay_out',

                details.payments_status AS 'payment_status',
                details.account_stage AS 'account_stage',

                details.case_disburse_id AS 'case_disburse_id',
                details.id AS 'case_disburse_detail_id'

                FROM case_disburse_details AS details
                LEFT JOIN case_disburses AS disburses ON details.case_disburse_id = disburses.id
                LEFT JOIN case_lists AS cases ON cases.id = disburses.case_list_id
                LEFT JOIN payments ON payments.case_disburse_detail_id = details.id
                JOIN invoices ON invoices.case_disburse_detail_id = details.id
                LEFT JOIN case_overridings AS overridings ON overridings.case_disburse_detail_id = details.id

                WHERE details.deleted_at IS NULL AND payments.deleted_at IS NULL AND invoices.deleted_at IS NULL
                AND invoices.disbursement_type = 0
                AND details.payments_status = 2
                AND details.account_stage >= 4

                GROUP BY details.id

                ) AS cms_report;
            ");
    }

    public function down()
    {
        Schema::dropIfExists('view5_to_commission_reports');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateView3ToSalesReports extends Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("
                CREATE OR REPLACE VIEW sales_reports as
                SELECT YEAR(disburses.approval_date) AS 'year', MONTH(disburses.approval_date) AS 'month', MONTHNAME(disburses.approval_date) AS 'month_name',
                cases.company_name AS 'client',  banks.name AS 'product', disburses.approval_date AS 'approval_date',
                disburses.approved_amount AS 'approved_amount', disburses.service_fee_percent AS 'rate',
                disburses.service_fee_amount AS 'fee', invoices.file_num AS 'inv', payments.date AS 'client_pay_date',

                details.bfe_name AS 'bfe_name', details.bfe_commission_rate AS 'bfe_percent', details.bfe_commission AS 'bfe_commission',
                details.bfe_commission_pay_day AS 'bfe_pay_out',

                details.banker_name AS 'banker_name', details.banker_commission_rate AS 'banker_percent', details.banker_commission AS 'banker_commission',
                details.banker_commission_pay_day AS 'banker_pay_out',

                details.id AS 'case_disburse_detail_id',
                details.payments_status AS 'payment_status',
                details.account_stage AS 'account_stage'

                FROM case_lists AS cases
                LEFT JOIN case_disburses AS disburses ON cases.id = disburses.case_list_id
                LEFT JOIN case_disburse_details AS details ON disburses.id = details.case_disburse_id
                LEFT JOIN banks ON disburses.bank_id = banks.id
                LEFT JOIN payments ON payments.case_disburse_detail_id = details.id
                LEFT JOIN invoices ON invoices.case_disburse_detail_id = details.id

                WHERE cases.deleted_at IS NULL AND disburses.deleted_at IS NULL AND details.deleted_at IS NULL AND banks.deleted_at IS NULL AND
                payments.deleted_at IS NULL AND invoices.deleted_at IS NULL

                AND details.account_stage >= 1

                GROUP BY details.case_disburse_id
                ORDER BY disburses.approval_date asc ;
            ");
    }

    public function down()
    {
        Schema::dropIfExists('view3_to_sales_reports');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateView3ToCollectionReports extends Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("
                CREATE OR REPLACE VIEW collection_reports as
                SELECT YEAR(disburses.approval_date) AS 'year', MONTH(disburses.approval_date) AS 'month',
                cases.company_name AS 'client', disburses.approved_amount AS 'approved_amount', disburses.service_fee_amount AS 'fee',
                details.bfe_name AS 'bfe_name', banks.name AS 'bank', details.banker_name AS 'banker_name', disburses.approval_date AS 'approval_date',

                proformas.file_num AS 'pro_no', proformas.date AS 'pro_date',
                invoices.file_num AS 'inv_no', invoices.date AS 'inv_date',
                payments.`or` AS 'or_no', payments.date AS 'or_date',

                details.id AS 'case_disburse_detail_id',
                details.payments_status AS 'payment_status',
                details.account_stage AS 'account_stage'

                FROM case_lists AS cases
                LEFT JOIN case_disburses AS disburses ON cases.id = disburses.case_list_id
                LEFT JOIN case_disburse_details AS details ON disburses.id = details.case_disburse_id
                LEFT JOIN banks ON disburses.bank_id = banks.id
                LEFT JOIN payments ON payments.case_disburse_detail_id = details.id
                LEFT JOIN proformas ON proformas.case_disburse_detail_id = details.id
                LEFT JOIN invoices ON invoices.case_disburse_detail_id = details.id

                WHERE cases.deleted_at IS NULL AND disburses.deleted_at IS NULL AND details.deleted_at IS NULL AND banks.deleted_at IS NULL AND
                payments.deleted_at IS NULL AND proformas.deleted_at IS NULL AND invoices.deleted_at IS NULL

                AND details.account_stage >= 1 AND (invoices.disbursement_type = 0 OR invoices.disbursement_type IS NULL)

                GROUP BY details.case_disburse_id
                ORDER BY disburses.approval_date ;
            ");
    }

    public function down()
    {
        Schema::dropIfExists('view3_to_collection_reports');
    }
}

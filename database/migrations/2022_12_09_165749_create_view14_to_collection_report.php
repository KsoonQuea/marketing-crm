<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateView14ToCollectionReport extends Migration
{
    public function up()
    {
//        \Illuminate\Support\Facades\DB::statement("
//                CREATE OR REPLACE VIEW collection_reports as
//SELECT
//if(collection.or_date IS NOT NULL, 'or', if(collection.inv_date IS NOT NULL, 'inv', if(collection.pro_date IS NOT NULL, 'pro', '' )) ) AS 'stage_name',
//collectionReportFunc(collection.pro_date, collection.inv_date, collection.or_date, 1) AS 'year_month_arr',
//collectionReportFunc(collection.pro_date, collection.inv_date, collection.or_date, 2) AS 'year_arr',
//collectionReportFunc(collection.pro_date, collection.inv_date, collection.or_date, 3) AS 'month_arr',
//
//collection.*
//FROM (
//    SELECT YEAR(disburses.approval_date) AS 'year', MONTH(disburses.approval_date) AS 'month',
//    cases.company_name AS 'client', disburses.approved_amount AS 'approved_amount', disburses.service_fee_amount AS 'fee',
//    details.bfe_name AS 'bfe_name', banks.name AS 'bank', details.banker_name AS 'banker_name', disburses.approval_date AS 'approval_date',
//
//    proformas.file_num AS 'pro_no', proformas.date AS 'pro_date',
//    invoices.file_num AS 'inv_no', invoices.date AS 'inv_date',
//    payments.`or` AS 'or_no', payments.latest_date AS 'or_date',
//
//    SUM(payments.paid_amount) AS 'paid_amount',
//    COUNT(payments.id) AS 'payment_count',
//    if(COUNT(payments.id) = 0, 0, (if(payments.sum_paid >= disburses.service_fee_amount, 2, 1))) AS 'payment_status',
//
//    details.id AS 'case_disburse_detail_id',
//    details.account_stage AS 'account_stage'
//
//    FROM case_lists AS cases
//    LEFT JOIN case_disburses AS disburses 		ON cases.id = disburses.case_list_id
//    LEFT JOIN case_disburse_details AS details 	ON disburses.id = details.case_disburse_id
//    LEFT JOIN banks 										ON disburses.bank_id = banks.id
//    LEFT JOIN proformas 								ON proformas.case_disburse_detail_id = details.id
//    LEFT JOIN invoices 									ON invoices.case_disburse_detail_id = details.id
//    LEFT JOIN (
//    	SELECT *, MAX(DATE) AS 'latest_date', SUM(paid_amount) AS 'sum_paid' FROM payments
//WHERE deleted_at IS NULL
//GROUP BY case_disburse_detail_id
//ORDER BY date DESC, id desc
//	 ) AS payments
//	 ON payments.case_disburse_detail_id = details.id
//
//    WHERE cases.deleted_at IS NULL AND disburses.deleted_at IS NULL AND details.deleted_at IS NULL AND banks.deleted_at IS NULL AND
//    payments.deleted_at IS NULL AND proformas.deleted_at IS NULL AND invoices.deleted_at IS NULL
//
//    AND details.account_stage >= 1 AND (invoices.disbursement_type = 0 OR invoices.disbursement_type IS NULL)
//    AND payments.`status` = 1
//
//    GROUP BY details.case_disburse_id
//
//    UNION
//
//    SELECT YEAR(disburses.approval_date) AS 'year', MONTH(disburses.approval_date) AS 'month',
//    cases.company_name AS 'client', disburses.approved_amount AS 'approved_amount', disburses.service_fee_amount AS 'fee',
//    details.bfe_name AS 'bfe_name', banks.name AS 'bank', details.banker_name AS 'banker_name', disburses.approval_date AS 'approval_date',
//
//    proformas.file_num AS 'pro_no', proformas.date AS 'pro_date',
//    invoices.file_num AS 'inv_no', invoices.date AS 'inv_date',
//    payments.`or` AS 'or_no', payments.latest_date AS 'or_date',
//
//    SUM(payments.paid_amount) AS 'paid_amount',
//    COUNT(payments.id) AS 'payment_count',
//    if(COUNT(payments.id) = 0, 0, (if(payments.sum_paid >= disburses.service_fee_amount, 2, 1))) AS 'payment_status',
//
//    details.id AS 'case_disburse_detail_id',
//
//    details.account_stage AS 'account_stage'
//
//    FROM case_lists AS cases
//    LEFT JOIN case_disburses AS disburses 			ON cases.id = disburses.case_list_id
//    LEFT JOIN case_disburse_details AS details 	ON disburses.id = details.case_disburse_id
//    LEFT JOIN banks 		ON disburses.bank_id = banks.id
//    LEFT JOIN proformas 	ON proformas.case_disburse_detail_id = details.id
//    LEFT JOIN invoices 	ON invoices.case_disburse_detail_id = details.id
//    LEFT JOIN (
//    	SELECT *, MAX(DATE) AS 'latest_date', SUM(paid_amount) AS 'sum_paid' FROM payments
//WHERE deleted_at IS NULL
//GROUP BY case_disburse_detail_id
//ORDER BY date DESC, id desc
//	 ) AS payments
//	 ON payments.case_disburse_detail_id = details.id
//
//    WHERE cases.deleted_at IS NULL AND disburses.deleted_at IS NULL AND details.deleted_at IS NULL AND banks.deleted_at IS NULL AND
//    payments.deleted_at IS NULL AND proformas.deleted_at IS NULL AND invoices.deleted_at IS NULL
//
//    AND details.account_stage >= 1 AND (invoices.disbursement_type = 0 OR invoices.disbursement_type IS NULL)
//    AND payments.`status` IS NULL
//
//    GROUP BY details.case_disburse_id
//
//) AS collection
//
//ORDER BY collection.approval_date
//            ");
    }

    public function down()
    {
        Schema::dropIfExists('view14_to_collection_report');
    }
}

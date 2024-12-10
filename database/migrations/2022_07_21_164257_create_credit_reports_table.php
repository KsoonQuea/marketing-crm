<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCreditReportsTable extends Migration
{
    public function up()
    {
        DB::statement('
            CREATE OR REPLACE VIEW credit_reports AS
            SELECT credit_report.case_id, credit_report.company_name, credit_report.incorporation_date, credit_report.business_activity,
credit_report.application_date, credit_report.address, credit_report.application_type, sum(credit_report.new_financing_amount) AS new_financing_amount,
credit_report.business_industry,
credit_report.a, credit_report.b, credit_report.c, credit_report.d, credit_report.e, credit_report.f, credit_report.g, credit_report.h,
credit_report.i
FROM (
	SELECT cl.id AS case_id, cl.company_name AS company_name, cl.incorporation_date AS incorporation_date,
   cl.business_activity AS business_activity, cl.applicaion_date AS application_date, cl.address AS address,
   ats.name AS application_type, cfi.total_proposed_limit AS new_financing_amount, it.name AS business_industry,
   cf.ebitda AS a, cf.profit_bfr_tax AS b, cf.profit_aft_tax AS c, bs.total_avg_credit AS d, bs.total_avg_month_end_balance AS e,
   cf.tnw AS f, cf.share_capital AS g, cf.other_asset AS h, cf.other_liabilities AS i
   FROM case_financials cf
   LEFT JOIN case_lists cl ON cf.case_id = cl.id
   LEFT JOIN bank_statements bs ON cl.id = bs.case_id
   LEFT JOIN case_financing_instruments cfi ON cfi.case_id = cl.id
   LEFT JOIN application_type_case_list atcl ON atcl.case_list_id = cl.id
   LEFT JOIN application_types ats ON ats.id = atcl.application_type_id
   LEFT JOIN industry_types it ON it.id = cl.industry_type_id

	WHERE cf.group_id = 1
	AND ISNULL(cf.deleted_at)
	AND ISNULL(cl.deleted_at)
	AND ISNULL(bs.deleted_at)
	AND ISNULL(cfi.deleted_at)
	AND ISNULL(ats.deleted_at)
	AND ISNULL(it.deleted_at)

	GROUP BY cl.id, ats.id

   union

   SELECT cl.id AS case_id, cl.company_name AS company_name, cl.incorporation_date AS incorporation_date,
   cl.business_activity AS business_activity, cl.applicaion_date AS application_date, cl.address AS address,
   ats.name AS application_type, 0 AS new_financing_amount, it.name AS business_industry,
   cf.ebitda AS a, cf.profit_bfr_tax AS b, cf.profit_aft_tax AS c, bs.total_avg_credit AS d, bs.total_avg_month_end_balance AS e,
   cf.tnw AS f, cf.share_capital AS g, cf.other_asset AS h, cf.other_liabilities AS i
   FROM case_financials cf
   LEFT JOIN case_lists cl ON cf.case_id = cl.id
   LEFT JOIN bank_statements bs ON cl.id = bs.case_id
   LEFT JOIN application_type_case_list atcl ON atcl.case_list_id = cl.id
   LEFT JOIN application_types ats ON ats.id = atcl.application_type_id
   LEFT JOIN industry_types it ON it.id = cl.industry_type_id

	WHERE cf.group_id = 1
	AND ISNULL(cf.deleted_at)
	AND ISNULL(cl.deleted_at)
	AND ISNULL(bs.deleted_at)
	AND ISNULL(ats.deleted_at)
	AND ISNULL(it.deleted_at)

   GROUP BY cl.id, ats.id
) AS credit_report
GROUP BY credit_report.case_id
        ');
    }

    public function down()
    {
        Schema::dropIfExists('credit_reports');
    }
}

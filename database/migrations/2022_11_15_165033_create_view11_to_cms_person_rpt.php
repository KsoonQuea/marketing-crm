<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateView11ToCmsPersonRpt extends Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("
                CREATE OR REPLACE VIEW commission_person_reports as
                SELECT cmsd_report.*,  SUM(cmsd_report.cms) AS 'total_cms' ,
                if(cmsd_report.or_date > CONCAT(cmsd_report.or_year_ori, '-', cmsd_report.or_month_ori, '-25'),
                if(cmsd_report.or_month_ori+1 = 13, cmsd_report.or_year_ori + 1, cmsd_report.or_year_ori), cmsd_report.or_year_ori) AS 'or_year',
                if(cmsd_report.or_date > CONCAT(cmsd_report.or_year_ori, '-', cmsd_report.or_month_ori, '-25'),
                if(cmsd_report.or_month_ori+1 = 13, 1, cmsd_report.or_month_ori+1), cmsd_report.or_month_ori) AS 'or_month'
                FROM(
                    SELECT YEAR(payments_join.MaxDateTime) AS 'or_year_ori', MONTH(payments_join.MaxDateTime) AS 'or_month_ori',
                    payments_join.MaxDateTime AS 'or_date',users.id AS 'user_id', users.name, roles.name AS 'roles', mhr.role_id,
                    if(SUM(overridings.commission) IS NULL, 0 ,
                    SUM(overridings.commission)) AS 'cms',payments_join.case_id AS 'case_id'
                    FROM users
                    left JOIN case_overridings AS overridings ON users.id = overridings.user_id
                    left JOIN case_disburse_details AS details ON details.id = overridings.case_disburse_detail_id
                    JOIN (
                        SELECT *, MAX(date) AS MaxDateTime
                        FROM payments
                        GROUP BY case_id
                    ) payments_join ON details.id = payments_join.case_disburse_detail_id
                    LEFT JOIN model_has_roles AS mhr ON mhr.model_id = users.id
                    LEFT JOIN roles ON roles.id = mhr.role_id

                    WHERE overridings.deleted_at IS NULL AND details.deleted_at IS NULL AND payments_join.deleted_at IS NULL
                    AND details.account_stage >= 4

                    GROUP BY payments_join.id, users.id

                    UNION

                    SELECT YEAR(payments_join.MaxDateTime) AS 'or_year_ori', MONTH(payments_join.MaxDateTime) AS 'or_month_ori',
                    payments_join.MaxDateTime AS 'or_date',
                    users.id AS 'user_id', users.name, roles.name AS 'roles', mhr.role_id,
                    if(SUM(details.bfe_commission) IS NULL, 0 , SUM(details.bfe_commission)) AS 'cms',
                    payments_join.case_id AS 'case_id'

                    FROM users
                    left JOIN case_lists AS cases ON cases.salesman_id = users.id
                    left JOIN case_disburses AS disburses ON disburses.case_list_id = cases.id
                    left JOIN case_disburse_details AS details ON disburses.id = details.case_disburse_id
                    JOIN (
                        SELECT *, MAX(date) AS MaxDateTime
                        FROM payments
                        GROUP BY case_id
                    ) payments_join ON details.id = payments_join.case_disburse_detail_id
                    LEFT JOIN model_has_roles AS mhr ON mhr.model_id = users.id
                    LEFT JOIN roles ON roles.id = mhr.role_id

                    WHERE cases.deleted_at IS NULL AND disburses.deleted_at IS NULL AND details.deleted_at IS NULL AND payments_join.deleted_at IS NULL
                    AND details.account_stage >= 4

                    GROUP BY payments_join.id, users.id
                ) AS cmsd_report

                WHERE cmsd_report.or_year_ori IS NOT NULL AND cmsd_report.or_month_ori IS NOT NULL

                GROUP BY cmsd_report.or_year_ori, cmsd_report.or_month_ori, cmsd_report.user_id
            ");
    }

    public function down()
    {
        Schema::dropIfExists('view11_to_cms_person_rpt');
    }
}

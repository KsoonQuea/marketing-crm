<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'name' => 'user_management_access',
                'guard_name' => 'admin',
                'permission_group_id' => 5,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'permission_create',
                'guard_name' => 'admin',
                'permission_group_id' => 2,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'permission_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 2,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'permission_show',
                'guard_name' => 'admin',
                'permission_group_id' => 2,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'permission_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 2,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'permission_access',
                'guard_name' => 'admin',
                'permission_group_id' => 2,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'role_create',
                'guard_name' => 'admin',
                'permission_group_id' => 3,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'role_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 3,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'role_show',
                'guard_name' => 'admin',
                'permission_group_id' => 3,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'role_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 3,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'role_access',
                'guard_name' => 'admin',
                'permission_group_id' => 3,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'user_create',
                'guard_name' => 'admin',
                'permission_group_id' => 5,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'user_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 5,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'user_show',
                'guard_name' => 'admin',
                'permission_group_id' => 5,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'user_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 5,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'user_remove',
                'guard_name' => 'admin',
                'permission_group_id' => 4,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'user_access',
                'guard_name' => 'admin',
                'permission_group_id' => 5,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'audit_log_show',
                'guard_name' => 'admin',
                'permission_group_id' => 4,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'audit_log_access',
                'guard_name' => 'admin',
                'permission_group_id' => 4,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_management_access',
                'guard_name' => 'admin',
                'permission_group_id' => 6,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'draft_case_access',
                'guard_name' => 'admin',
                'permission_group_id' => 6,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'submitted_case_access',
                'guard_name' => 'admin',
                'permission_group_id' => 6,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'rework_case_access',
                'guard_name' => 'admin',
                'permission_group_id' => 6,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'credit_case_access',
                'guard_name' => 'admin',
                'permission_group_id' => 6,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'pending_result_case_access',
                'guard_name' => 'admin',
                'permission_group_id' => 6,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'pending_disbursement_case_access',
                'guard_name' => 'admin',
                'permission_group_id' => 6,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
//
//            [
//                'name' => 'credit_case_access',
//                'guard_name' => 'admin',
//                'permission_group_id' => 6,
//            ],
//            [
//                'name' => 'credit_case_access',
//                'guard_name' => 'admin',
//                'permission_group_id' => 6,
//            ],


            [
                'name' => 'country_create',
                'guard_name' => 'admin',
                'permission_group_id' => 7,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'country_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 7,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'country_show',
                'guard_name' => 'admin',
                'permission_group_id' => 7,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'country_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 7,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'country_access',
                'guard_name' => 'admin',
                'permission_group_id' => 7,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'state_create',
                'guard_name' => 'admin',
                'permission_group_id' => 8,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'state_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 8,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'state_show',
                'guard_name' => 'admin',
                'permission_group_id' => 8,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'state_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 8,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'state_access',
                'guard_name' => 'admin',
                'permission_group_id' => 8,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'setting_access',
                'guard_name' => 'admin',
                'permission_group_id' => 1,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_list_create',
                'guard_name' => 'admin',
                'permission_group_id' => 9,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_list_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 9,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_list_show',
                'guard_name' => 'admin',
                'permission_group_id' => 9,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_list_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 9,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_list_access',
                'guard_name' => 'admin',
                'permission_group_id' => 9,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_list_remove',
                'guard_name' => 'admin',
                'permission_group_id' => 9,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'industry_type_create',
                'guard_name' => 'admin',
                'permission_group_id' => 10,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'industry_type_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 10,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'industry_type_show',
                'guard_name' => 'admin',
                'permission_group_id' => 10,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'industry_type_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 10,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'industry_type_access',
                'guard_name' => 'admin',
                'permission_group_id' => 10,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'city_create',
                'guard_name' => 'admin',
                'permission_group_id' => 11,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'city_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 11,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'city_show',
                'guard_name' => 'admin',
                'permission_group_id' => 11,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'city_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 11,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'city_access',
                'guard_name' => 'admin',
                'permission_group_id' => 11,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'bank_create',
                'guard_name' => 'admin',
                'permission_group_id' => 12,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'bank_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 12,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'bank_show',
                'guard_name' => 'admin',
                'permission_group_id' => 12,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'bank_remove',
                'guard_name' => 'admin',
                'permission_group_id' => 12,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'bank_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 12,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'bank_access',
                'guard_name' => 'admin',
                'permission_group_id' => 12,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'bank_statement_create',
                'guard_name' => 'admin',
                'permission_group_id' => 13,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'bank_statement_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 13,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'bank_statement_show',
                'guard_name' => 'admin',
                'permission_group_id' => 13,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'bank_statement_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 13,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'bank_statement_access',
                'guard_name' => 'admin',
                'permission_group_id' => 13,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_request_create',
                'guard_name' => 'admin',
                'permission_group_id' => 14,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_request_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 14,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_request_show',
                'guard_name' => 'admin',
                'permission_group_id' => 14,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_request_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 14,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_request_access',
                'guard_name' => 'admin',
                'permission_group_id' => 14,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'request_type_create',
                'guard_name' => 'admin',
                'permission_group_id' => 15,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'request_type_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 15,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'request_type_show',
                'guard_name' => 'admin',
                'permission_group_id' => 15,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'request_type_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 15,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'request_type_access',
                'guard_name' => 'admin',
                'permission_group_id' => 15,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_management_team_create',
                'guard_name' => 'admin',
                'permission_group_id' => 16,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_management_team_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 16,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_management_team_show',
                'guard_name' => 'admin',
                'permission_group_id' => 16,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_management_team_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 16,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_management_team_access',
                'guard_name' => 'admin',
                'permission_group_id' => 16,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_document_create',
                'guard_name' => 'admin',
                'permission_group_id' => 17,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_document_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 17,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_document_show',
                'guard_name' => 'admin',
                'permission_group_id' => 17,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_document_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 17,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_document_access',
                'guard_name' => 'admin',
                'permission_group_id' => 17,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_credit_check_create',
                'guard_name' => 'admin',
                'permission_group_id' => 18,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_credit_check_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 18,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_credit_check_show',
                'guard_name' => 'admin',
                'permission_group_id' => 18,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_credit_check_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 18,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_credit_check_access',
                'guard_name' => 'admin',
                'permission_group_id' => 18,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'kyc_access',
                'guard_name' => 'admin',
                'permission_group_id' => 19,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'director_create',
                'guard_name' => 'admin',
                'permission_group_id' => 20,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'director_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 20,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'director_show',
                'guard_name' => 'admin',
                'permission_group_id' => 20,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'director_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 20,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'director_access',
                'guard_name' => 'admin',
                'permission_group_id' => 20,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_financial_create',
                'guard_name' => 'admin',
                'permission_group_id' => 21,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_financial_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 21,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_financial_show',
                'guard_name' => 'admin',
                'permission_group_id' => 21,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_financial_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 21,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_financial_access',
                'guard_name' => 'admin',
                'permission_group_id' => 21,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'financial_access',
                'guard_name' => 'admin',
                'permission_group_id' => 22,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_commitment_create',
                'guard_name' => 'admin',
                'permission_group_id' => 23,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_commitment_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 23,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_commitment_show',
                'guard_name' => 'admin',
                'permission_group_id' => 23,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_commitment_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 23,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_commitment_access',
                'guard_name' => 'admin',
                'permission_group_id' => 23,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_director_commitment_create',
                'guard_name' => 'admin',
                'permission_group_id' => 24,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_director_commitment_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 24,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_director_commitment_show',
                'guard_name' => 'admin',
                'permission_group_id' => 24,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_director_commitment_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 24,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_director_commitment_access',
                'guard_name' => 'admin',
                'permission_group_id' => 24,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_gearing_create',
                'guard_name' => 'admin',
                'permission_group_id' => 25,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_gearing_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 25,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_gearing_show',
                'guard_name' => 'admin',
                'permission_group_id' => 25,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_gearing_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 25,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_gearing_access',
                'guard_name' => 'admin',
                'permission_group_id' => 25,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'criterion_create',
                'guard_name' => 'admin',
                'permission_group_id' => 26,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'criterion_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 26,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'criterion_show',
                'guard_name' => 'admin',
                'permission_group_id' => 26,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'criterion_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 26,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'criterion_access',
                'guard_name' => 'admin',
                'permission_group_id' => 26,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_criterion_create',
                'guard_name' => 'admin',
                'permission_group_id' => 27,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_criterion_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 27,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_criterion_show',
                'guard_name' => 'admin',
                'permission_group_id' => 27,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_criterion_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 27,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_criterion_access',
                'guard_name' => 'admin',
                'permission_group_id' => 27,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_check_report_access',
                'guard_name' => 'admin',
                'permission_group_id' => 28,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_report_recommendation_create',
                'guard_name' => 'admin',
                'permission_group_id' => 29,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_report_recommendation_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 29,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_report_recommendation_show',
                'guard_name' => 'admin',
                'permission_group_id' => 29,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_report_recommendation_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 29,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_report_recommendation_access',
                'guard_name' => 'admin',
                'permission_group_id' => 29,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'application_type_create',
                'guard_name' => 'admin',
                'permission_group_id' => 30,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'application_type_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 30,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'application_type_show',
                'guard_name' => 'admin',
                'permission_group_id' => 30,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'application_type_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 30,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'application_type_access',
                'guard_name' => 'admin',
                'permission_group_id' => 30,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'team_create',
                'guard_name' => 'admin',
                'permission_group_id' => 31,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'team_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 31,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'team_show',
                'guard_name' => 'admin',
                'permission_group_id' => 31,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'team_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 31,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'team_access',
                'guard_name' => 'admin',
                'permission_group_id' => 31,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_credit_check_type_create',
                'guard_name' => 'admin',
                'permission_group_id' => 32,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_credit_check_type_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 32,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_credit_check_type_show',
                'guard_name' => 'admin',
                'permission_group_id' => 32,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_credit_check_type_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 32,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_credit_check_type_access',
                'guard_name' => 'admin',
                'permission_group_id' => 32,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_dsr_create',
                'guard_name' => 'admin',
                'permission_group_id' => 33,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_dsr_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 33,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_dsr_show',
                'guard_name' => 'admin',
                'permission_group_id' => 33,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_dsr_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 33,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_dsr_access',
                'guard_name' => 'admin',
                'permission_group_id' => 33,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_cashflow_mon_commit_create',
                'guard_name' => 'admin',
                'permission_group_id' => 34,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_cashflow_mon_commit_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 34,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_cashflow_mon_commit_show',
                'guard_name' => 'admin',
                'permission_group_id' => 34,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_cashflow_mon_commit_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 34,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_cashflow_mon_commit_access',
                'guard_name' => 'admin',
                'permission_group_id' => 34,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'financing_instrument_create',
                'guard_name' => 'admin',
                'permission_group_id' => 35,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'financing_instrument_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 35,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'financing_instrument_show',
                'guard_name' => 'admin',
                'permission_group_id' => 35,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'financing_instrument_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 35,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'financing_instrument_access',
                'guard_name' => 'admin',
                'permission_group_id' => 35,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_financing_instrument_create',
                'guard_name' => 'admin',
                'permission_group_id' => 36,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_financing_instrument_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 36,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_financing_instrument_show',
                'guard_name' => 'admin',
                'permission_group_id' => 36,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_financing_instrument_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 36,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_financing_instrument_access',
                'guard_name' => 'admin',
                'permission_group_id' => 36,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_call_log_create',
                'guard_name' => 'admin',
                'permission_group_id' => 37,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_call_log_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 37,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_call_log_show',
                'guard_name' => 'admin',
                'permission_group_id' => 37,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_call_log_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 37,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'case_call_log_access',
                'guard_name' => 'admin',
                'permission_group_id' => 37,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'user_case_log_create',
                'guard_name' => 'admin',
                'permission_group_id' => 38,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'user_case_log_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 38,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'user_case_log_show',
                'guard_name' => 'admin',
                'permission_group_id' => 38,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'user_case_log_delete',
                'guard_name' => 'admin',
                'permission_group_id' => 38,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'user_case_log_access',
                'guard_name' => 'admin',
                'permission_group_id' => 38,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'profile_password_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 39,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'user_password_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 5,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'call_logs_access',
                'guard_name' => 'admin',
                'permission_group_id' => 40,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'master_call_list_access',
                'guard_name' => 'admin',
                'permission_group_id' => 40,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'pending_call_access',
                'guard_name' => 'admin',
                'permission_group_id' => 40,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'all_call_access',
                'guard_name' => 'admin',
                'permission_group_id' => 40,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'kyc_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 9,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'financial_fye_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 9,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'financial_ccris_commitment_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 9,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'financial_dsr_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 9,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'financial_cash_flow_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 9,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'financial_gearing_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 9,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],
            [
                'name' => 'financial_new_financing_instrument_edit',
                'guard_name' => 'admin',
                'permission_group_id' => 9,

                'show_name'     => null,
                'type'          => 0,
                'parent_id'     => 0,
            ],

//            -------------------------------------  new permission -----------------------------------------

            [
                //id : 191
                'name'                  => 'case_all_index_2',
                'show_name'             => 'Access Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 41,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 191
                'name'                  => 'case_personal_index_2',
                'show_name'             => 'Access Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 41,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 192
                'name'                  => 'case_create_2',
                'show_name'             => 'Create Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 41,
                'type'                  => 7,
                'parent_id'             => 0,
            ],[
                //id : 192
                'name'                  => 'add_other_bfe_access',
                'show_name'             => 'Assign Case Other BFE',
                'guard_name'            => 'admin',
                'permission_group_id'   => 41,
                'type'                  => 7,
                'parent_id'             => 0,
            ],[
                //id : 193
                'name'                  => 'case_view_2',
                'show_name'             => 'View Case Details',
                'guard_name'            => 'admin',
                'permission_group_id'   => 41,
                'type'                  => 7,
                'parent_id'             => 0,
            ],[
                //id : 194
                'name'                  => 'case_delete_2',
                'show_name'             => 'Remove Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 41,
                'type'                  => 7,
                'parent_id'             => 0,
            ],

            [
                //id : 196
                'name'                  => 'credit_2',
                'show_name'             => 'Credit',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 3,
                'parent_id'             => 0,
            ],[
                //id : 197
                'name'                  => 'case_memo_edit_2',
                'show_name'             => 'Create Memo',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 196,
            ],[
                //id : 198
                'name'                  => 'case_summary_edit_2',
                'show_name'             => 'Edit Case Summary Status',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 196,
            ],[
                //id : 199
                'name'                  => 'case_pcr_edit_2',
                'show_name'             => 'Edit Pulse Check Report',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 196,
            ],[
                //id : 200
                'name'                  => 'case_pcr_download_2',
                'show_name'             => 'Download Pulse Check Report',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 196,
            ],

            [
                //id : 201
                'name'                  => 'case_information_2',
                'show_name'             => 'Case Information',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 3,
                'parent_id'             => 0,
            ],[
                //id : 202
                'name'                  => 'case_kyc_edit_2',
                'show_name'             => 'Edit KYC',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 201,
            ],[
                //id : 203
                'name'                  => 'case_financial_edit_2',
                'show_name'             => 'Edit Financial',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 201,
            ],[
                //id : 203 - B
                'name'                  => 'case_financial_credit_edit_2',
                'show_name'             => 'Edit Financial (Credit)',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 201,
            ],[
                //id : 204
                'name'                  => 'case_bankStt_edit_2',
                'show_name'             => 'Edit Bank Statement',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 201,
            ],[
                //id : 205
                'name'                  => 'case_dirCmmt_edit_2',
                'show_name'             => 'Edit Director Commitment',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 201,
            ],

            [
                //id : 206
                'name'                  => 'attachment_2',
                'show_name'             => 'Attachment',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 3,
                'parent_id'             => 0,
            ],[
                //id : 207
                'name'                  => 'case_folder_create_2',
                'show_name'             => 'Create Folder',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 206,
            ],[
                //id : 208
                'name'                  => 'case_file_create_2',
                'show_name'             => 'Upload File',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 206,
            ],[
                //id : 209
                'name'                  => 'case_folder_delete_2',
                'show_name'             => 'Remove Folder',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 206,
            ],[
                //id : 210
                'name'                  => 'case_file_delete_2',
                'show_name'             => 'Remove File',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 206,
            ],[
                //id : 211
                'name'                  => 'case_file_zip_2',
                'show_name'             => 'Download & Zip File',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 206,
            ],

            [
                //id : 212
                'name'                  => 'agreement_n_billing_2',
                'show_name'             => 'Agreement & Billing',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 3,
                'parent_id'             => 0,
            ],[
                //id : 213
                'name'                  => 'case_agmt_edit_2',
                'show_name'             => 'Edit Agreement',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 212,
            ],

            [
                //id : 214
                'name'                  => 'draft_index_2',
                'show_name'             => 'Access Draft Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 43,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 215
                'name'                  => 'draft_edit_2',
                'show_name'             => 'Edit Draft',
                'guard_name'            => 'admin',
                'permission_group_id'   => 43,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 216
                'name'                  => 'draft_delete_2',
                'show_name'             => 'Remove Draft',
                'guard_name'            => 'admin',
                'permission_group_id'   => 43,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 217
                'name'                  => 'case_all_submitted_index_2',
                'show_name'             => 'Access Assessment Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 44,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 217
                'name'                  => 'case_personal_submitted_index_2',
                'show_name'             => 'Access Assessment Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 44,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 218
                'name'                  => 'case_check_2',
                'show_name'             => 'Check Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 44,
                'type'                  => 7,
                'parent_id'             => 0,
            ],[
                //id : 219
                'name'                  => 'case_rework_2',
                'show_name'             => 'Return Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 44,
                'type'                  => 7,
                'parent_id'             => 0,
            ],[
                //id : 220
                'name'                  => 'case_drop_2',
                'show_name'             => 'Drop Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 44,
                'type'                  => 7,
                'parent_id'             => 0,
            ],

            [
                //id : 221
                'name'                  => 'case_all_rework_index_2',
                'show_name'             => 'Access Rework Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 45,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 221
                'name'                  => 'case_personal_rework_index_2',
                'show_name'             => 'Access Rework Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 45,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 222
                'name'                  => 'case_resubmit_2',
                'show_name'             => 'Resubmit Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 45,
                'type'                  => 7,
                'parent_id'             => 0,
            ],

            [
                //id : 223
                'name'                  => 'case_credit_index_2',
                'show_name'             => 'Access Cases Status',
                'guard_name'            => 'admin',
                'permission_group_id'   => 46,
                'type'                  => 2,
                'parent_id'             => 0,
            ],
            [
                //id : 224
                'name'                  => 'case_pending_result_index_2',
                'show_name'             => 'Access Pending Result',
                'guard_name'            => 'admin',
                'permission_group_id'   => 47,
                'type'                  => 2,
                'parent_id'             => 0,
            ],
            [
                //id : 225
                'name'                  => 'case_pending_disbursement_index_2',
                'show_name'             => 'Access Pending Disbursement',
                'guard_name'            => 'admin',
                'permission_group_id'   => 48,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 226
                'name'                  => 'call_master_index_2',
                'show_name'             => 'Access Master Call List',
                'guard_name'            => 'admin',
                'permission_group_id'   => 49,
                'type'                  => 2,
                'parent_id'             => 0,
            ], [
                //id : 227
                'name'                  => 'call_master_excel_create_2',
                'show_name'             => 'Add Master Call LIst',
                'guard_name'            => 'admin',
                'permission_group_id'   => 49,
                'type'                  => 2,
                'parent_id'             => 0,
            ], [
                //id : 228
                'name'                  => 'call_master_separate_2',
                'show_name'             => 'Separate Call List',
                'guard_name'            => 'admin',
                'permission_group_id'   => 49,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 228
                'name'                  => 'call_master_delete_2',
                'show_name'             => 'Remove Call List',
                'guard_name'            => 'admin',
                'permission_group_id'   => 49,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 229
                'name'                  => 'call_remark_history_index_2',
                'show_name'             => 'Access Call Remark History',
                'guard_name'            => 'admin',
                'permission_group_id'   => 50,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 230
                'name'                  => 'call_all_pending_index_2',
                'show_name'             => 'Access Pending Call',
                'guard_name'            => 'admin',
                'permission_group_id'   => 51,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 230
                'name'                  => 'call_personal_pending_index_2',
                'show_name'             => 'Access Pending Call',
                'guard_name'            => 'admin',
                'permission_group_id'   => 51,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 231
                'name'                  => 'call_remark_2',
                'show_name'             => 'Remark Call',
                'guard_name'            => 'admin',
                'permission_group_id'   => 51,
                'type'                  => 7,
                'parent_id'             => 0,
            ],

            [
                //id : 232
                'name'                  => 'call_all_all_index_2',
                'show_name'             => 'Access All Call',
                'guard_name'            => 'admin',
                'permission_group_id'   => 52,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 232
                'name'                  => 'call_personal_all_index_2',
                'show_name'             => 'Access All Call',
                'guard_name'            => 'admin',
                'permission_group_id'   => 52,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 233
                'name'                  => 'call_convert_case_2',
                'show_name'             => 'Convert Call to Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 52,
                'type'                  => 7,
                'parent_id'             => 0,
            ],

            [
                //id : 234
                'name'                  => 'finRoadmap_all_index_2',
                'show_name'             => 'Access All Financial Roadmap',
                'guard_name'            => 'admin',
                'permission_group_id'   => 53,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 235
                'name'                  => 'finRoadmap_generate_2',
                'show_name'             => 'Generate Financial Roadmap',
                'guard_name'            => 'admin',
                'permission_group_id'   => 53,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 236
                'name'                  => 'finRoadmap_edit_2',
                'show_name'             => 'Edit Financial Roadmap',
                'guard_name'            => 'admin',
                'permission_group_id'   => 53,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 237
                'name'                  => 'finRoadmap_pending_index_2',
                'show_name'             => 'Access Pending Financial Roadmap',
                'guard_name'            => 'admin',
                'permission_group_id'   => 54,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 237
                'name'                  => 'finRoadmap_pending_confirm_2',
                'show_name'             => 'Confirm Pending Financial Roadmap',
                'guard_name'            => 'admin',
                'permission_group_id'   => 54,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 238
                'name'                  => 'finRoadmap_confirm_index_2',
                'show_name'             => 'Access Confirm Financial Roadmap',
                'guard_name'            => 'admin',
                'permission_group_id'   => 55,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 239
                'name'                  => 'finRoadmap_confirm_convert_2',
                'show_name'             => 'Convert Financial Roadmap to Case',
                'guard_name'            => 'admin',
                'permission_group_id'   => 55,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 240
                'name'                  => 'user_index_2',
                'show_name'             => 'Access User Management',
                'guard_name'            => 'admin',
                'permission_group_id'   => 56,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 241
                'name'                  => 'user_create_2',
                'show_name'             => 'Create User',
                'guard_name'            => 'admin',
                'permission_group_id'   => 56,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 242
                'name'                  => 'user_edit_2',
                'show_name'             => 'Edit User',
                'guard_name'            => 'admin',
                'permission_group_id'   => 56,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 243
                'name'                  => 'user_active_2',
                'show_name'             => 'Active User',
                'guard_name'            => 'admin',
                'permission_group_id'   => 56,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 244
                'name'                  => 'user_inactive_2',
                'show_name'             => 'Inactive User',
                'guard_name'            => 'admin',
                'permission_group_id'   => 56,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 245
                'name'                  => 'user_delete_2',
                'show_name'             => 'Remove User',
                'guard_name'            => 'admin',
                'permission_group_id'   => 56,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 246
                'name'                  => 'user_view_2',
                'show_name'             => 'View User Details',
                'guard_name'            => 'admin',
                'permission_group_id'   => 56,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 247
                'name'                  => 'team_index_2',
                'show_name'             => 'Access Team Management',
                'guard_name'            => 'admin',
                'permission_group_id'   => 57,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 248
                'name'                  => 'team_create_2',
                'show_name'             => 'Create Team',
                'guard_name'            => 'admin',
                'permission_group_id'   => 57,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 249
                'name'                  => 'team_edit_2',
                'show_name'             => 'Edit Team',
                'guard_name'            => 'admin',
                'permission_group_id'   => 57,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 250
                'name'                  => 'team_delete_2',
                'show_name'             => 'Remove Team',
                'guard_name'            => 'admin',
                'permission_group_id'   => 57,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 251
                'name'                  => 'director_index_2',
                'show_name'             => 'Access Director Management',
                'guard_name'            => 'admin',
                'permission_group_id'   => 58,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 252
                'name'                  => 'director_create_2',
                'show_name'             => 'Create Director',
                'guard_name'            => 'admin',
                'permission_group_id'   => 58,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 253
                'name'                  => 'director_edit_2',
                'show_name'             => 'Edit Director',
                'guard_name'            => 'admin',
                'permission_group_id'   => 58,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 254
                'name'                  => 'director_view_2',
                'show_name'             => 'View Director Details',
                'guard_name'            => 'admin',
                'permission_group_id'   => 58,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 255
                'name'                  => 'director_delete_2',
                'show_name'             => 'Remove Director',
                'guard_name'            => 'admin',
                'permission_group_id'   => 58,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 256
                'name'                  => 'role_index_2',
                'show_name'             => 'Access Role & Permission',
                'guard_name'            => 'admin',
                'permission_group_id'   => 59,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 257
                'name'                  => 'role_create_2',
                'show_name'             => 'Create Role',
                'guard_name'            => 'admin',
                'permission_group_id'   => 59,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 258
                'name'                  => 'role_edit_2',
                'show_name'             => 'Edit Role',
                'guard_name'            => 'admin',
                'permission_group_id'   => 59,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 259
                'name'                  => 'role_view_2',
                'show_name'             => 'View Role & Permission Details',
                'guard_name'            => 'admin',
                'permission_group_id'   => 59,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 260
                'name'                  => 'role_delete_2',
                'show_name'             => 'Remove Role',
                'guard_name'            => 'admin',
                'permission_group_id'   => 59,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 261
                'name'                  => 'industry_type_index_2',
                'show_name'             => 'Access Industry Type Management',
                'guard_name'            => 'admin',
                'permission_group_id'   => 60,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 262
                'name'                  => 'industry_type_create_2',
                'show_name'             => 'Create Industry Type',
                'guard_name'            => 'admin',
                'permission_group_id'   => 60,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 263
                'name'                  => 'industry_type_edit_2',
                'show_name'             => 'Edit Industry Type',
                'guard_name'            => 'admin',
                'permission_group_id'   => 60,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 264
                'name'                  => 'industry_type_delete_2',
                'show_name'             => 'Remove Industry Type',
                'guard_name'            => 'admin',
                'permission_group_id'   => 60,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 265
                'name'                  => 'application_type_index_2',
                'show_name'             => 'Access Application Type Management',
                'guard_name'            => 'admin',
                'permission_group_id'   => 61,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 266
                'name'                  => 'application_type_create_2',
                'show_name'             => 'Create Application Type',
                'guard_name'            => 'admin',
                'permission_group_id'   => 61,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 267
                'name'                  => 'application_type_edit_2',
                'show_name'             => 'Edit Application Type',
                'guard_name'            => 'admin',
                'permission_group_id'   => 61,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 268
                'name'                  => 'application_type_delete_2',
                'show_name'             => 'Remove Application Type',
                'guard_name'            => 'admin',
                'permission_group_id'   => 61,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 269
                'name'                  => 'request_type_index_2',
                'show_name'             => 'Access Request Type Management',
                'guard_name'            => 'admin',
                'permission_group_id'   => 62,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 270
                'name'                  => 'request_type_create_2',
                'show_name'             => 'Create Request Type',
                'guard_name'            => 'admin',
                'permission_group_id'   => 62,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 271
                'name'                  => 'request_type_edit_2',
                'show_name'             => 'Edit Request Type',
                'guard_name'            => 'admin',
                'permission_group_id'   => 62,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 272
                'name'                  => 'request_type_delete_2',
                'show_name'             => 'Remove Request Type',
                'guard_name'            => 'admin',
                'permission_group_id'   => 62,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 273
                'name'                  => 'credit_check_type_index_2',
                'show_name'             => 'Access Credit Check Type Management',
                'guard_name'            => 'admin',
                'permission_group_id'   => 63,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 274
                'name'                  => 'credit_check_type_create_2',
                'show_name'             => 'Create Credit Check Type',
                'guard_name'            => 'admin',
                'permission_group_id'   => 63,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 275
                'name'                  => 'credit_check_type_edit_2',
                'show_name'             => 'Edit Credit Check Type',
                'guard_name'            => 'admin',
                'permission_group_id'   => 63,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 276
                'name'                  => 'credit_check_type_delete_2',
                'show_name'             => 'Remove Credit Check Type',
                'guard_name'            => 'admin',
                'permission_group_id'   => 63,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 277
                'name'                  => 'platform_index_2',
                'show_name'             => 'Access Platform Management',
                'guard_name'            => 'admin',
                'permission_group_id'   => 64,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 278
                'name'                  => 'platform_create_2',
                'show_name'             => 'Create Platform',
                'guard_name'            => 'admin',
                'permission_group_id'   => 64,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 279
                'name'                  => 'platform_edit_2',
                'show_name'             => 'Edit Platform',
                'guard_name'            => 'admin',
                'permission_group_id'   => 64,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 280
                'name'                  => 'platform_active_2',
                'show_name'             => 'Active Platform',
                'guard_name'            => 'admin',
                'permission_group_id'   => 64,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 280
                'name'                  => 'platform_inactive_2',
                'show_name'             => 'Inactive Platform',
                'guard_name'            => 'admin',
                'permission_group_id'   => 64,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 281
                'name'                  => 'dashboard_all_latest_case_index_2',
                'show_name'             => 'Show Latest Cases',
                'guard_name'            => 'admin',
                'permission_group_id'   => 65,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 282
                'name'                  => 'dashboard_personal_latest_case_index_2',
                'show_name'             => 'Show Latest Cases',
                'guard_name'            => 'admin',
                'permission_group_id'   => 65,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 283
                'name'                  => 'dashboard_all_latest_case_view_2',
                'show_name'             => 'View More of Latest Cases',
                'guard_name'            => 'admin',
                'permission_group_id'   => 65,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 284
                'name'                  => 'dashboard_personal_latest_case_view_2',
                'show_name'             => 'View More of Latest Cases',
                'guard_name'            => 'admin',
                'permission_group_id'   => 65,
                'type'                  => 5,
                'parent_id'             => 0,
            ],

            [
                //id : 285
                'name'                  => 'dashboard_year_group_kpi_2',
                'show_name'             => 'Year Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 6,
                'parent_id'             => 0,
            ],[
                //id : 286
                'name'                  => 'dashboard_all_year_kpi_index_2',
                'show_name'             => 'Show Year Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 287
                'name'                  => 'dashboard_personal_year_kpi_index_2',
                'show_name'             => 'Show Year Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 288
                'name'                  => 'dashboard_all_year_kpi_view_2',
                'show_name'             => 'View More of Year Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 289
                'name'                  => 'dashboard_personal_year_kpi_view_2',
                'show_name'             => 'View More of Year Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 5,
                'parent_id'             => 0,
            ],

            [
                //id : 290
                'name'                  => 'dashboard_monthly_group_kpi_2',
                'show_name'             => 'Monthly Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 6,
                'parent_id'             => 0,
            ],[
                //id : 291
                'name'                  => 'dashboard_all_monthly_kpi_index_2',
                'show_name'             => 'Show Monthly Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 292
                'name'                  => 'dashboard_personal_monthly_kpi_index_2',
                'show_name'             => 'Show Monthly Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 293
                'name'                  => 'dashboard_all_monthly_kpi_view_2',
                'show_name'             => 'View More of Monthly Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 294
                'name'                  => 'dashboard_personal_monthly_kpi_view_2',
                'show_name'             => 'View More of Monthly Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 5,
                'parent_id'             => 0,
            ],

            [
                //id : 295
                'name'                  => 'dashboard_quarterly_group_kpi_2',
                'show_name'             => 'Quarterly Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 6,
                'parent_id'             => 0,
            ],[
                //id : 296
                'name'                  => 'dashboard_all_quarterly_kpi_index_2',
                'show_name'             => 'Show Quarterly Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 297
                'name'                  => 'dashboard_personal_quarterly_kpi_index_2',
                'show_name'             => 'Show Quarterly Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 298
                'name'                  => 'dashboard_all_quarterly_kpi_view_2',
                'show_name'             => 'View More of Quarterly Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 299
                'name'                  => 'dashboard_personal_quarterly_kpi_view_2',
                'show_name'             => 'View More of Quarterly Group KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 5,
                'parent_id'             => 0,
            ],

            [
                //id : 300
                'name'                  => 'dashboard_all_ytd_chart_one_2',
                'show_name'             => 'YTD Service Fee Charged vs. YTD KPI',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 6,
                'parent_id'             => 0,
            ],[
                //id : 301
                'name'                  => 'dashboard_all_ytd_chart_one_index_2',
                'show_name'             => 'Show All YTD Service Fee Charged vs. YTD KPI Chart',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 302
                'name'                  => 'dashboard_personal_ytd_chart_one_index_2',
                'show_name'             => 'Show Personal YTD Service Fee Charged vs. YTD KPI Chart',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 303
                'name'                  => 'dashboard_all_ytd_chart_one_view_2',
                'show_name'             => 'View More of All YTD Service Fee Charged vs. YTD KPI Chart',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 304
                'name'                  => 'dashboard_personal_ytd_chart_one_view_2',
                'show_name'             => 'View More of Personal YTD Service Fee Charged vs. YTD KPI Chart',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 5,
                'parent_id'             => 0,
            ],

            [
                //id : 305
                'name'                  => 'dashboard_all_ytd_chart_two_2',
                'show_name'             => 'YTD Service Fee Charged vs. YTD Collected Service Fee',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 6,
                'parent_id'             => 0,
            ],[
                //id : 306
                'name'                  => 'dashboard_all_ytd_chart_two_index_2',
                'show_name'             => 'Show All YTD Service Fee Charged vs. YTD Collected Service Fee Chart',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 307
                'name'                  => 'dashboard_personal_ytd_chart_two_index_2',
                'show_name'             => 'Show Personal YTD Service Fee Charged vs. YTD Collected Service Fee Chart',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 308
                'name'                  => 'dashboard_all_ytd_chart_two_view_2',
                'show_name'             => 'View More of All YTD Service Fee Charged vs. YTD Collected Service Fee Chart',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 309
                'name'                  => 'dashboard_personal_ytd_chart_two_view_2',
                'show_name'             => 'View More of Personal YTD Service Fee Charged vs. YTD Collected Service Fee Chart',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 5,
                'parent_id'             => 0,
            ],

            [
                //id : 400
                'name'                  => 'dashboard_all_ytd_total_customer_2',
                'show_name'             => 'YTD Total Customer Onboarded',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 6,
                'parent_id'             => 0,
            ],[
                //id : 401
                'name'                  => 'dashboard_all_ytd_total_customer_index_2',
                'show_name'             => 'Show All YTD Total Customer Onboarded',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 402
                'name'                  => 'dashboard_personal_ytd_total_customer_index_2',
                'show_name'             => 'Show Personal YTD Total Customer Onboarded',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 403
                'name'                  => 'dashboard_all_ytd_total_customer_view_2',
                'show_name'             => 'View More of All YTD Total Customer Onboarded',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 404
                'name'                  => 'dashboard_personal_ytd_total_customer_view_2',
                'show_name'             => 'View More of Personal YTD Total Customer Onboarded',
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 5,
                'parent_id'             => 0,
            ],

            [
                //id : 405
                'name'                  => 'dashboard_team_2',
                'show_name'             => "Team's Dashboard Details",
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 6,
                'parent_id'             => 0,
            ],[
                //id : 406
                'name'                  => 'dashboard_team_index_2',
                'show_name'             => "Access team's dashboard",
                'guard_name'            => 'admin',
                'permission_group_id'   => 66,
                'type'                  => 7,
                'parent_id'             => 0,
            ],

            [
                //id : 407
                'name'                  => 'dashboard_all_mtd_case_index_2',
                'show_name'             => 'Show MTD Case Submission',
                'guard_name'            => 'admin',
                'permission_group_id'   => 67,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 408
                'name'                  => 'dashboard_personal_mtd_case_index_2',
                'show_name'             => 'Show All MTD Case Submission',
                'guard_name'            => 'admin',
                'permission_group_id'   => 67,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 409
                'name'                  => 'dashboard_all_pending_approval_index_2',
                'show_name'             => 'Show Pending Approval Cases',
                'guard_name'            => 'admin',
                'permission_group_id'   => 67,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 410
                'name'                  => 'dashboard_personal_pending_approval_index_2',
                'show_name'             => 'Show Pending Approval Cases',
                'guard_name'            => 'admin',
                'permission_group_id'   => 67,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 411
                'name'                  => 'dashboard_all_pending_disbursement_index_2',
                'show_name'             => 'Show Pending Disbursement Cases',
                'guard_name'            => 'admin',
                'permission_group_id'   => 67,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 412
                'name'                  => 'dashboard_personal_pending_disbursement_index_2',
                'show_name'             => 'Show Pending Disbursement Cases',
                'guard_name'            => 'admin',
                'permission_group_id'   => 67,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 413
                'name'                  => 'dashboard_all_rework_case_index_2',
                'show_name'             => 'Show Rework Cases',
                'guard_name'            => 'admin',
                'permission_group_id'   => 67,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 414
                'name'                  => 'dashboard_personal_rework_case_index_2',
                'show_name'             => 'Show Rework Cases',
                'guard_name'            => 'admin',
                'permission_group_id'   => 67,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 415
                'name'                  => 'dashboard_all_pending_assessment_index_2',
                'show_name'             => 'Show Pending Assessment Cases',
                'guard_name'            => 'admin',
                'permission_group_id'   => 67,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 416
                'name'                  => 'dashboard_personal_pending_assessment_index_2',
                'show_name'             => 'Show Pending Assessment Cases',
                'guard_name'            => 'admin',
                'permission_group_id'   => 67,
                'type'                  => 5,
                'parent_id'             => 0,
            ],[
                //id : 417
                'name'                  => 'dashboard_all_pending_offer_index_2',
                'show_name'             => 'Show Pending Offer Cases',
                'guard_name'            => 'admin',
                'permission_group_id'   => 67,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 418
                'name'                  => 'dashboard_personal_pending_offer_index_2',
                'show_name'             => 'Show Pending Offer Cases',
                'guard_name'            => 'admin',
                'permission_group_id'   => 67,
                'type'                  => 5,
                'parent_id'             => 0,
            ],

            [
                //id : 419
                'name'                  => 'dashboard_all_call_log_index_2',
                'show_name'             => 'Show Lead Centre',
                'guard_name'            => 'admin',
                'permission_group_id'   => 68,
                'type'                  => 4,
                'parent_id'             => 0,
            ],[
                //id : 420
                'name'                  => 'dashboard_personal_call_log_index_2',
                'show_name'             => 'Show Lead Centre',
                'guard_name'            => 'admin',
                'permission_group_id'   => 68,
                'type'                  => 5,
                'parent_id'             => 0,
            ],

            [
                //id : 421
                'name'                  => 'case_agmt_pi_print_2',
                'show_name'             => 'Print Proforma & Invoice',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 212,
            ],[
                //id : 421
                'name'                  => 'case_agmt_generate_inv_code_2',
                'show_name'             => 'Generate/Reuse Inv Code',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 212,
            ],[
                //id : 421
                'name'                  => 'case_agmt_upload_payment_2',
                'show_name'             => 'Upload Payment',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 212,
            ],[
                //id : 421
                'name'                  => 'case_agmt_check_payment_2',
                'show_name'             => 'Edit & Verify Payment',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 212,
            ],

            [
                //id : 247
                'name'                  => 'management_index_2',
                'show_name'             => 'Access Management',
                'guard_name'            => 'admin',
                'permission_group_id'   => 74,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 248
                'name'                  => 'management_create_2',
                'show_name'             => 'Create Management',
                'guard_name'            => 'admin',
                'permission_group_id'   => 74,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 249
                'name'                  => 'management_edit_2',
                'show_name'             => 'Edit Management',
                'guard_name'            => 'admin',
                'permission_group_id'   => 74,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 250
                'name'                  => 'management_delete_2',
                'show_name'             => 'Remove Management',
                'guard_name'            => 'admin',
                'permission_group_id'   => 74,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 247
                'name'                  => 'reimbursement_index_2',
                'show_name'             => 'Access Reimbursement',
                'guard_name'            => 'admin',
                'permission_group_id'   => 69,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 248
                'name'                  => 'reimbursement_create_2',
                'show_name'             => 'Create Reimbursement',
                'guard_name'            => 'admin',
                'permission_group_id'   => 69,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 249
                'name'                  => 'reimbursement_edit_2',
                'show_name'             => 'Edit Reimbursement',
                'guard_name'            => 'admin',
                'permission_group_id'   => 69,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 250
                'name'                  => 'reimbursement_print_2',
                'show_name'             => 'Print Reimbursement',
                'guard_name'            => 'admin',
                'permission_group_id'   => 69,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 247
                'name'                  => 'sales_report_index_2',
                'show_name'             => 'Access Sales Report',
                'guard_name'            => 'admin',
                'permission_group_id'   => 70,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 248
                'name'                  => 'sales_report_pdf_2',
                'show_name'             => 'Generate PDF',
                'guard_name'            => 'admin',
                'permission_group_id'   => 70,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 249
                'name'                  => 'sales_report_excel_2',
                'show_name'             => 'Generate Excel',
                'guard_name'            => 'admin',
                'permission_group_id'   => 70,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 249
                'name'                  => 'sales_report_edit_2',
                'show_name'             => 'Edit Pay Out Date',
                'guard_name'            => 'admin',
                'permission_group_id'   => 70,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 247
                'name'                  => 'collection_report_index_2',
                'show_name'             => 'Access Collection Report',
                'guard_name'            => 'admin',
                'permission_group_id'   => 71,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 248
                'name'                  => 'collection_report_pdf_2',
                'show_name'             => 'Generate PDF',
                'guard_name'            => 'admin',
                'permission_group_id'   => 71,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 249
                'name'                  => 'collection_report_excel_2',
                'show_name'             => 'Generate Excel',
                'guard_name'            => 'admin',
                'permission_group_id'   => 71,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 247
                'name'                  => 'outstanding_report_index_2',
                'show_name'             => 'Access Outstanding Report',
                'guard_name'            => 'admin',
                'permission_group_id'   => 72,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 248
                'name'                  => 'outstanding_report_pdf_2',
                'show_name'             => 'Generate PDF',
                'guard_name'            => 'admin',
                'permission_group_id'   => 72,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 249
                'name'                  => 'outstanding_report_excel_2',
                'show_name'             => 'Generate Excel',
                'guard_name'            => 'admin',
                'permission_group_id'   => 72,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 247
                'name'                  => 'commission_list_index_2',
                'show_name'             => 'Access Commission List',
                'guard_name'            => 'admin',
                'permission_group_id'   => 73,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 248
                'name'                  => 'commission_list_pdf_2',
                'show_name'             => 'Generate PDF',
                'guard_name'            => 'admin',
                'permission_group_id'   => 73,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 249
                'name'                  => 'commission_list_excel_2',
                'show_name'             => 'Generate Excel',
                'guard_name'            => 'admin',
                'permission_group_id'   => 73,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 250
                'name'                  => 'case_agmt_remove_payment_2',
                'show_name'             => 'Remove Payment',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 212,
            ],

            [
                //id : 366
                'name'                  => 'bank_approval_industry_chart',
                'show_name'             => 'Bank Approval Industry Chart',
                'guard_name'            => 'admin',
                'permission_group_id'   => 75,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

            [
                //id : 367
                'name'                  => 'bank_officer_index_2',
                'show_name'             => 'Access Bank Officer List',
                'guard_name'            => 'admin',
                'permission_group_id'   => 76,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 368
                'name'                  => 'bank_officer_create_2',
                'show_name'             => 'Create Bank Officer',
                'guard_name'            => 'admin',
                'permission_group_id'   => 76,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 369
                'name'                  => 'bank_officer_edit_2',
                'show_name'             => 'Edit Bank Officer',
                'guard_name'            => 'admin',
                'permission_group_id'   => 76,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 370
                'name'                  => 'bank_officer_show_2',
                'show_name'             => 'Show Bank Officer',
                'guard_name'            => 'admin',
                'permission_group_id'   => 76,
                'type'                  => 2,
                'parent_id'             => 0,
            ],[
                //id : 421
                'name'                  => 'case_agmt_edit_aprv_amount',
                'show_name'             => 'Edit Approved Amount',
                'guard_name'            => 'admin',
                'permission_group_id'   => 42,
                'type'                  => 2,
                'parent_id'             => 212,
            ],
            [
                //id : 372
                'name'                  => 'bank_officer_delete_2',
                'show_name'             => 'Delete Bank Officer',
                'guard_name'            => 'admin',
                'permission_group_id'   => 76,
                'type'                  => 2,
                'parent_id'             => 0,
            ],

        ];

        Permission::insert($permissions);
    }
}

<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
{
    public function run(): void
    {
//        $permissionGroups = [
//            [
//                'name'      => 'Case',
//                'title_id'  => '2',
//                'status'    => '1',
//            ],
//            [
//                'name'      => 'Case Details',
//                'title_id'  => '2',
//                'status'    => '1',
//            ],
//            [
//                'name'      => 'Draft Case',
//                'title_id'  => '2',
//                'status'    => '1',
//            ],
//            [
//                'name'      => 'Submitted Case',
//                'title_id'  => '2',
//                'status'    => '1',
//            ],
//            [
//                'name'      => 'Rework Case',
//                'title_id'  => '2',
//                'status'    => '1',
//            ],
//            [
//                'name'      => 'Credit',
//                'title_id'  => '2',
//                'status'    => '1',
//            ],
//            [
//                'name'      => 'Pending Result',
//                'title_id'  => '2',
//                'status'    => '1',
//            ],
//            [
//                'name'      => 'Pending Disbursement',
//                'title_id'  => '2',
//                'status'    => '1',
//            ],
//        ];

        $permissionGroups = [
            [
                'name' => 'Setting',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Permission',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Role',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Audit Log',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'User Management',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Management',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Country',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'State',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case List',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Industry Type',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'City',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Bank',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Bank Statement',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Request',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Request Type',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Management Team',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Document',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Credit Check',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'KYC',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Director',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Financial',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Financial',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Commitment',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Director Commitment',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Gearing',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Criterion',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Criterion',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Check Report',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Report Recommendation',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Application Type',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Team',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Credit Check Type',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case DSR',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Cashflow Mon Commit',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Financing Instrument',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Financing Instrument',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Case Call Log',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'User Case Log',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Profile Password',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name' => 'Lead Centre',
                'title_id'  => null,
                'status'    => 0,
            ],
            [
                'name'      => 'Case',
                'title_id'  => '2',
                'status'    => '1',
            ],
            [
                'name'      => 'Case Details',
                'title_id'  => '2',
                'status'    => '1',
            ],
            [
                'name'      => 'Draft Case',
                'title_id'  => '2',
                'status'    => '1',
            ],
            [
                'name'      => 'Assessment Case',
                'title_id'  => '2',
                'status'    => '1',
            ],
            [
                'name'      => 'Rework Case',
                'title_id'  => '2',
                'status'    => '1',
            ],
            [
                'name'      => 'Cases Status',
                'title_id'  => '2',
                'status'    => '1',
            ],
            [
                'name'      => 'Pending Result',
                'title_id'  => '2',
                'status'    => '1',
            ],
            [
                'name'      => 'Pending Disbursement',
                'title_id'  => '2',
                'status'    => '1',
            ],
            [
                //id : 49
                'name'      => 'Master Call List',
                'title_id'  => '3',
                'status'    => '1',
            ],
            [
                //id : 50
                'name'      => 'Call Remark History',
                'title_id'  => '3',
                'status'    => '1',
            ],
            [
                //id : 51
                'name'      => 'Pending Call',
                'title_id'  => '3',
                'status'    => '1',
            ],
            [
                //id : 52
                'name'      => 'All Call',
                'title_id'  => '3',
                'status'    => '1',
            ],
            [
                //id : 53
                'name'      => 'All List',
                'title_id'  => '6',
                'status'    => '1',
            ],
            [
                //id : 54
                'name'      => 'Pending List',
                'title_id'  => '6',
                'status'    => '1',
            ],
            [
                //id : 55
                'name'      => 'Confirm List',
                'title_id'  => '6',
                'status'    => '1',
            ],
            [
                //id : 56
                'name'      => 'User',
                'title_id'  => '7',
                'status'    => '1',
            ],
            [
                //id : 57
                'name'      => 'Team',
                'title_id'  => '7',
                'status'    => '1',
            ],
            [
                //id : 58
                'name'      => 'Director',
                'title_id'  => '8',
                'status'    => '0',
            ],
            [
                //id : 59
                'name'      => 'Role & Permission',
                'title_id'  => '9',
                'status'    => '1',
            ],
            [
                //id : 61
                'name'      => 'Industry Type Management',
                'title_id'  => '9',
                'status'    => '1',
            ],
            [
                //id : 62
                'name'      => 'Application Type Management',
                'title_id'  => '9',
                'status'    => '1',
            ],
            [
                //id : 63
                'name'      => 'Request Type Management',
                'title_id'  => '9',
                'status'    => '1',
            ],
            [
                //id : 64
                'name'      => 'Credit Check Type Management',
                'title_id'  => '9',
                'status'    => '1',
            ],
            [
                //id : 60
                'name'      => 'Platform Management',
                'title_id'  => '9',
                'status'    => '1',
            ],

            [
                //id : 65
                'name'      => 'Latest Cases',
                'title_id'  => '1',
                'status'    => '1',
            ],
            [
                //id : 66
                'name'      => 'Achievements',
                'title_id'  => '1',
                'status'    => '1',
            ],
            [
                //id : 67
                'name'      => 'To Do Lists',
                'title_id'  => '1',
                'status'    => '1',
            ],
            [
                //id : 68
                'name'      => 'Lead Centre Lists',
                'title_id'  => '1',
                'status'    => '1',
            ],
            [
                //id : 69
                'name'      => 'Reimbursement Invoice',
                'title_id'  => '4',
                'status'    => '1',
            ],
            [
                //id : 70
                'name'      => 'Sales Report',
                'title_id'  => '5',
                'status'    => '1',
            ],[
                //id : 71
                'name'      => 'Collection Report',
                'title_id'  => '5',
                'status'    => '1',
            ],[
                //id : 72
                'name'      => 'Outstanding Report',
                'title_id'  => '5',
                'status'    => '1',
            ],[
                //id : 73
                'name'      => 'Commission List',
                'title_id'  => '5',
                'status'    => '1',
            ],
            [
                //id : 74
                'name'      => 'Management',
                'title_id'  => '7',
                'status'    => '1',
            ],
            [
                //id : 75
                'name'      => 'Bank Approval',
                'title_id'  => '1',
                'status'    => '1',
            ],
            [
                //id : 76
                'name'      => 'Bank Officer Management',
                'title_id'  => '9',
                'status'    => '1',
            ],
        ];

        PermissionGroup::insert($permissionGroups);
    }
}

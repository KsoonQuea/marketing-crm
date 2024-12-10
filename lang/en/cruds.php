<?php

return [
    'userManagement' => [
        'title' => 'User Mgmt.',
        'title_singular' => 'User Mgmt.',
    ],
    'permission' => [
        'title' => 'Permissions',
        'title_singular' => 'Permission',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'title' => 'Title',
            'title_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role' => [
        'title' => 'Roles',
        'title_singular' => 'Role',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'title' => 'Title',
            'title_helper' => ' ',
            'permissions' => 'Permissions',
            'permissions_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role_permission' => [
        'title' => 'Roles & Permissions',
        'title_singular' => 'Role & Permission',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'title' => 'Title',
            'title_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'user' => [
        'title' => 'Users',
        'title_singular' => 'User',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'name' => 'Name',
            'name_helper' => ' ',
            'email' => 'Email',
            'email_helper' => ' ',
            'email_verified_at' => 'Email verified at',
            'email_verified_at_helper' => ' ',
            'password' => 'Password',
            'password_helper' => ' ',
            'roles' => 'Roles',
            'roles_helper' => ' ',
            'remember_token' => 'Remember Token',
            'remember_token_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
            'username' => 'Username',
            'username_helper' => ' ',
            'ic' => 'IC',
            'ic_helper' => ' ',
            'phone' => 'Phone',
            'phone_helper' => ' ',
            'gender' => 'Gender',
            'gender_helper' => ' ',
            'address_1' => 'Address 1',
            'address_1_helper' => ' ',
            'address_2' => 'Address 2',
            'address_2_helper' => ' ',
            'postcode' => 'Postcode',
            'postcode_helper' => ' ',
            'city' => 'City',
            'city_helper' => ' ',
            'state' => 'State',
            'state_helper' => ' ',
            'country' => 'Country',
            'country_helper' => ' ',
            'bank_owner' => 'Bank Owner',
            'bank_owner_helper' => ' ',
            'bank_account' => 'Bank Account',
            'bank_account_helper' => ' ',
            'bank' => 'Bank Name',
            'bank_helper' => '',
            'avatar' => 'Avatar',
            'avatar_helper' => '',
        ],
    ],
    'auditLog' => [
        'title' => 'Audit Logs',
        'title_singular' => 'Audit Log',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'description' => 'Description',
            'description_helper' => ' ',
            'subject_id' => 'Subject ID',
            'subject_id_helper' => ' ',
            'subject_type' => 'Subject Type',
            'subject_type_helper' => ' ',
            'user_id' => 'User ID',
            'user_id_helper' => ' ',
            'properties' => 'Properties',
            'properties_helper' => ' ',
            'host' => 'Host',
            'host_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
        ],
    ],
    'caseManagement' => [
        'title' => 'Case Mgmt.',
        'title_singular' => 'Case Mgmt.',
    ],
    'country' => [
        'title' => 'Countries',
        'title_singular' => 'Country',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'name' => 'Name',
            'name_helper' => ' ',
            'short_code' => 'Short Code',
            'short_code_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'state' => [
        'title' => 'State',
        'title_singular' => 'State',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'name' => 'Name',
            'name_helper' => ' ',
            'postcode_format' => 'Postcode Format',
            'postcode_format_helper' => ' ',
            'other_postcode' => 'Other Postcode',
            'other_postcode_helper' => ' ',
            'status' => 'Status',
            'status_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
            'country' => 'Country',
            'country_helper' => ' ',
        ],
    ],
    'setting' => [
        'title' => 'Settings',
        'title_singular' => 'Setting',
    ],
    'caseList' => [
        'title' => 'Cases',
        'title_singular' => 'Case',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'case_code' => 'Case Code',
            'case_code_helper' => ' ',
            'company_name' => 'Company Name',
            'company_name_helper' => ' ',
            'incorporation_date' => 'Incorporation Date',
            'incorporation_date_helper' => ' ',
            'country' => 'Country',
            'country_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
            'industry_type' => 'Industry Type',
            'industry_type_helper' => ' ',
            'bfe' => 'BFE',
            'bfe_helper' => ' ',
            'applicaion_date' => 'Applicaion Date',
            'applicaion_date_helper' => ' ',
            'business_bg' => 'Business Background',
            'business_bg_helper' => ' ',
            'remark' => 'Remark',
            'remark_helper' => ' ',
            'address_1' => 'Address 1',
            'address_1_helper' => ' ',
            'address_2' => 'Address 2',
            'address_2_helper' => ' ',
            'state' => 'State',
            'state_helper' => ' ',
            'city' => 'City',
            'city_helper' => ' ',
            'salesman' => 'Salesman',
            'salesman_helper' => ' ',
            'status' => 'Status',
            'status_helper' => ' ',
            'director' => 'Director',
            'director_helper' => ' ',
            'postcode' => 'Postcode',
            'postcode_helper' => ' ',
            'application_type' => 'Application Type',
            'application_type_helper' => ' ',
        ],
    ],
    'industryType' => [
        'title' => 'Industry Type',
        'title_singular' => 'Industry Type',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'name' => 'Name',
            'name_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
            'status' => 'Status',
            'status_helper' => '',
        ],
    ],
    'city' => [
        'title' => 'City',
        'title_singular' => 'City',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'name' => 'Name',
            'name_helper' => ' ',
            'status' => 'Status',
            'status_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
            'state' => 'State',
            'state_helper' => ' ',
        ],
    ],
    'bank' => [
        'title' => 'Bank',
        'title_singular' => 'Bank',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'name' => 'Name',
            'name_helper' => ' ',
            'swift_code' => 'Swift Code',
            'swift_code_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'bankStatement' => [
        'title' => 'Bank STMT',
        'title_singular' => 'Bank STMT',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'bank' => 'Bank',
            'bank_helper' => ' ',
            'case' => 'Case',
            'case_helper' => ' ',
            'currency' => 'Currency',
            'currency_helper' => ' ',
            'bank_owner' => 'Bank Owner',
            'bank_owner_helper' => ' ',
            'bank_account' => 'Bank Account',
            'bank_account_helper' => ' ',
            'credit' => 'Credit',
            'credit_helper' => ' ',
            'debit' => 'Debit',
            'debit_helper' => ' ',
            'month_end_balance' => 'Month End Balance',
            'month_end_balance_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'caseRequest' => [
        'title' => 'Case REQ',
        'title_singular' => 'Case REQ',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'case' => 'Case',
            'case_helper' => ' ',
            'request' => 'Request',
            'request_helper' => ' ',
            'facility_type' => 'Facility Type',
            'facility_type_helper' => ' ',
            'amount' => 'Amount',
            'amount_helper' => ' ',
            'specific_concern' => 'Specific Concern',
            'specific_concern_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
            'request_type' => 'Request Type',
            'request_type_helper' => ' ',
        ],
    ],
    'requestType' => [
        'title' => 'Request Type',
        'title_singular' => 'Request Type',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'name' => 'Name',
            'name_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
            'status' => 'Status',
            'status_helper' => '',
        ],
    ],
    'caseManagementTeam' => [
        'title' => 'Case Mgmt. Team',
        'title_singular' => 'Case Mgmt. Team',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'case' => 'Case',
            'case_helper' => ' ',
            'name' => 'Name',
            'name_helper' => ' ',
            'age' => 'Age',
            'age_helper' => ' ',
            'phone' => 'Phone',
            'phone_helper' => ' ',
            'email' => 'Email',
            'email_helper' => ' ',
            'designation' => 'Designation',
            'designation_helper' => ' ',
            'shareholding' => 'Shareholding',
            'shareholding_helper' => ' ',
            'responsible_area' => 'Responsible Area',
            'responsible_area_helper' => ' ',
            'experience_year' => 'Experience Year',
            'experience_year_helper' => ' ',
            'case_year' => 'Case Year',
            'case_year_helper' => ' ',
            'director_relationship' => 'Director Relationship',
            'director_relationship_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'caseDocument' => [
        'title' => 'Case Document',
        'title_singular' => 'Case Document',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'case' => 'Case',
            'case_helper' => ' ',
            'title' => 'Title',
            'title_helper' => ' ',
            'description' => 'Description',
            'description_helper' => ' ',
            'file' => 'Document/Photo',
            'file_helper' => ' ',
            'type' => 'Type',
            'type_helper' => ' ',
            'remark' => 'Remark',
            'remark_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'caseCreditCheck' => [
        'title' => 'Case CR CHK',
        'title_singular' => 'Case CR CHK',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'case' => 'Case',
            'case_helper' => ' ',
            'credit_check' => 'Credit Check',
            'credit_check_helper' => ' ',
            'finding' => 'Finding',
            'finding_helper' => ' ',
            'migration' => 'Migration',
            'migration_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'kyc' => [
        'title' => 'KYC',
        'title_singular' => 'KYC',
    ],
    'director' => [
        'title' => 'Director',
        'title_singular' => 'Director',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'name' => 'Name',
            'name_helper' => ' ',
            'ic' => 'IC',
            'ic_helper' => ' ',
            'email' => 'Email',
            'email_helper' => ' ',
            'phone' => 'Phone',
            'phone_helper' => ' ',
            'gender' => 'Gender',
            'gender_helper' => ' ',
            'marital_status' => 'Marital Status',
            'marital_status_helper' => ' ',
            'address_1' => 'Address 1',
            'address_1_helper' => ' ',
            'address_2' => 'Address 2',
            'address_2_helper' => ' ',
            'postcode' => 'Postcode',
            'postcode_helper' => ' ',
            'city' => 'City',
            'city_helper' => ' ',
            'state' => 'State',
            'state_helper' => ' ',
            'country' => 'Country',
            'country_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'caseFinancial' => [
        'title' => 'Case Fin.',
        'title_singular' => 'Case Fin.',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'current_asset' => 'Current Asset',
            'current_asset_helper' => ' ',
            'non_current_asset' => 'Non Current Asset',
            'non_current_asset_helper' => ' ',
            'director_asset' => 'Director Asset',
            'director_asset_helper' => ' ',
            'related_customer_asset' => 'Related Customer Asset',
            'related_customer_asset_helper' => ' ',
            'customer_asset' => 'Customer Asset',
            'customer_asset_helper' => ' ',
            'current_liabilities' => 'Current Liabilities',
            'current_liabilities_helper' => ' ',
            'non_current_liabilities' => 'Non Current Liabilities',
            'non_current_liabilities_helper' => ' ',
            'director_liabilities' => 'Director Liabilities',
            'director_liabilities_helper' => ' ',
            'related_customer_liabilities' => 'Related Customer Liabilities',
            'related_customer_liabilities_helper' => ' ',
            'customer_liabilities' => 'Customer Liability',
            'customer_liabilities_helper' => ' ',
            'loan_n_hp' => 'Current maturity LTD (Term Loan & HP)',
            'loan_n_hp_helper' => ' ',
            'share_capital' => 'Paid Up  Capital (Share Capital)',
            'share_capital_helper' => ' ',
            'revenue' => 'Revenue',
            'revenue_helper' => ' ',
            'sales_cost' => 'Cost of Sales / Cost of Goods Sold',
            'sales_cost_helper' => ' ',
            'finance_cost' => 'Finance Cost',
            'finance_cost_helper' => ' ',
            'depreciation' => 'Depreciation',
            'depreciation_helper' => ' ',
            'profit' => 'Profit Before Tax',
            'profit_helper' => ' ',
            'tax' => 'Tax',
            'tax_helper' => ' ',
            'financial_date' => 'Date',
            'financial_date_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'financial' => [
        'title' => 'Fin.',
        'title_singular' => 'Fin.',
    ],
    'caseCommitment' => [
        'title' => 'Case Commit.',
        'title_singular' => 'Case Commit.',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'case' => 'Case',
            'case_helper' => ' ',
            'house_loan' => 'HL',
            'house_loan_helper' => ' ',
            'term_loan' => 'TL',
            'term_loan_helper' => ' ',
            'hire_purchase' => 'HP',
            'hire_purchase_helper' => ' ',
            'credit_card_limit' => 'CC Limit',
            'credit_card_limit_helper' => ' ',
            'trade_line_limit' => 'OD & Trade Line Limit',
            'trade_line_limit_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'caseDirectorCommitment' => [
        'title' => 'Case Dir Commit.',
        'title_singular' => 'Case Dir Commit.',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'case' => 'Case',
            'case_helper' => ' ',
            'director_name' => 'Director Name',
            'director_name_helper' => ' ',
            'house_loan' => 'HL',
            'house_loan_helper' => ' ',
            'personal_loan' => 'PL',
            'personal_loan_helper' => ' ',
            'hire_purchase' => 'HP',
            'hire_purchase_helper' => ' ',
            'credit_card_limit' => 'CC Limit',
            'credit_card_limit_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'caseGearing' => [
        'title' => 'Case Gearing',
        'title_singular' => 'Case Gearing',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'borrow_item' => 'Borrow Item',
            'borrow_item_helper' => ' ',
            'borrow_price' => 'Borrow Price',
            'borrow_price_helper' => ' ',
            'financing_amount' => 'Financing Amount',
            'financing_amount_helper' => ' ',
            'bank_redemtion' => 'Bank Redemtion',
            'bank_redemtion_helper' => ' ',
            'date' => 'Date',
            'date_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'criterion' => [
        'title' => 'Criteria',
        'title_singular' => 'Criterion',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'name' => 'Name',
            'name_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
            'status' => 'Status',
            'status_helper' => ' ',
        ],
    ],
    'caseCriterion' => [
        'title' => 'Case Criteria',
        'title_singular' => 'Case Criterion',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'case' => 'Case',
            'case_helper' => ' ',
            'criteria' => 'Criteria',
            'criteria_helper' => ' ',
            'answer' => 'Answer',
            'answer_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'caseCheckReport' => [
        'title' => 'Case CHK RPT',
        'title_singular' => 'Case CHK RPT',
    ],
    'caseReportRecommendation' => [
        'title' => 'Case RPT Rcmd.',
        'title_singular' => 'Case RPT Rcmd.',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'case' => 'Case',
            'case_helper' => ' ',
            'recommendation' => 'Recommendation',
            'recommendation_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'applicationType' => [
        'title' => 'Application Type',
        'title_singular' => 'Application Type',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'name' => 'Name',
            'name_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
            'status' => 'Status',
            'status_helper' => '',
        ],
    ],
    'userTeam' => [
        'title' => 'Team',
        'title_singular' => 'Team',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'name' => 'Team Name',
            'name_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
            'team_lead' => 'Team Lead',
            'team_lead_helper' => ' ',
            'team_member' => 'Team Member',
            'team_member_helper' => ' ',
        ],
    ],
    'caseCreditCheckType' => [
        'title' => 'Credit Check Type',
        'title_singular' => 'Credit Check Type',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'name' => 'Name',
            'name_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
            'status' => 'Status',
            'status_helper' => '',
        ],
    ],
    'caseDsr' => [
        'title' => 'DSR',
        'title_singular' => 'DSR',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'case' => 'Case',
            'case_helper' => ' ',
            'ebitda' => 'EBITDA',
            'ebitda_helper' => ' ',
            'ccris_commitment' => 'CCCRIS Commitment',
            'ccris_commitment_helper' => ' ',
            'bank_statement_commitment' => 'Bank Statement Commitment',
            'bank_statement_commitment_helper' => ' ',
            'new_financing_commitment' => 'New Financing Commitment',
            'new_financing_commitment_helper' => ' ',
            'dsr' => 'DSR',
            'dsr_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'caseCashflowMonCommit' => [
        'title' => 'Case CF Mon Commit.',
        'title_singular' => 'Case CF Mon Commit.',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'case' => 'Case',
            'case_helper' => ' ',
            'avg_mon_end_bank_balances' => 'Average Monthly End Bank Balances',
            'avg_mon_end_bank_balances_helper' => ' ',
            'avg_mon_credit_transactions' => 'Average Monthly Credit Transactions',
            'avg_mon_credit_transactions_helper' => ' ',
            'mon_commitment' => 'Monthly Commitment',
            'mon_commitment_helper' => ' ',
            'tot_mon_commitment_for_directors' => 'Total Monthly Commitment For Directors',
            'tot_mon_commitment_for_directors_helper' => ' ',
            'tot_mon_commitment_of_directors_and_company' => 'Total Monthly Commitment Of Directors And Company',
            'tot_mon_commitment_of_directors_and_company_helper' => ' ',
            'annualized_revenue' => 'Annualized Revenue',
            'annualized_revenue_helper' => ' ',
            'income_factor' => 'Income Factor',
            'income_factor_helper' => ' ',
            'dsr' => 'DSR',
            'dsr_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'financingInstrument' => [
        'title' => 'Fin. Instr',
        'title_singular' => 'Fin. Instr',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'loan_product' => 'Loan Product',
            'loan_product_helper' => ' ',
            'interest_rate' => 'Interest Rate',
            'interest_rate_helper' => ' ',
            'tenor' => 'Tenor',
            'tenor_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'caseFinancingInstrument' => [
        'title' => 'Case Fin. Instr',
        'title_singular' => 'Case Fin. Instr',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'case' => 'Case',
            'case_helper' => ' ',
            'financing_instrument' => 'Financing Instrument',
            'financing_instrument_helper' => ' ',
            'commitment' => 'Commitment',
            'commitment_helper' => ' ',
            'proposed_limit' => 'Proposed Limit',
            'proposed_limit_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'caseCallLog' => [
        'title' => 'Lead Centre',
        'title_singular' => 'Lead Centre',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'user' => 'User',
            'user_helper' => ' ',
            'case' => 'Case',
            'case_helper' => ' ',
            'details' => 'Details',
            'details_helper' => ' ',
            'datetime' => 'When',
            'datetime_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'userCaseLog' => [
        'title' => 'User Case Log',
        'title_singular' => 'User Case Log',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'user' => 'User',
            'user_helper' => ' ',
            'case' => 'Case',
            'case_helper' => ' ',
            'case_stage' => 'Case Stage',
            'case_stage_helper' => ' ',
            'action_status' => 'Action Status',
            'action_status_helper' => ' ',
            'action_remark' => 'Action Remark',
            'action_remark_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'profile' =>[
        'profile' => 'Profile',
        'old' => 'Old Password',
        'new' => 'New Password',
        'two' => 'Confirm Password',
        'password_helper' => ' ',
    ],
    'team' => [
        'title' => 'Teams',
        'title_singular' => 'Team',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'name' => 'Name',
            'name_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => ' ',
            'leadername' => 'Leader Name',
            'leadername_helper' => ' ',
            'member' => 'Team Member',
            'member_helper' => ' ',
        ],
    ],
    'commissionSettings' => [
        'title' => 'Commission Settings',
        'title_singular' => 'Commission Setting',
        'fields' => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'leadername'        => 'Leader Name',
            'leadername_helper' => ' ',
            'member'            => 'Team Member',
            'member_helper'     => ' ',
        ],
    ],
    'bankOfficer' => [
        'title' => 'Bank Officer',
        'title_singular' => 'Bank Officer',
        'fields' => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
];
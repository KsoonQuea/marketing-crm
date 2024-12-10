<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\ApplicationTypeController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\BankOfficerListController;
use App\Http\Controllers\Admin\BankStatementController;
use App\Http\Controllers\Admin\CaseCallLogController;
use App\Http\Controllers\Admin\CaseCashflowMonCommitController;
use App\Http\Controllers\Admin\CaseCommitmentController;
use App\Http\Controllers\Admin\CaseCreditCheckController;
use App\Http\Controllers\Admin\CaseCreditCheckTypeController;
use App\Http\Controllers\Admin\CaseCriteriaController;
use App\Http\Controllers\Admin\CaseDirectorCommitmentController;
use App\Http\Controllers\Admin\CaseDocumentController;
use App\Http\Controllers\Admin\CaseDsrController;
use App\Http\Controllers\Admin\CaseFinancialController;
use App\Http\Controllers\Admin\CaseFinancingInstrumentController;
use App\Http\Controllers\Admin\CaseGearingController;
use App\Http\Controllers\Admin\CaseListsController;
use App\Http\Controllers\Admin\CaseManagementTeamController;
use App\Http\Controllers\Admin\CaseReportRecommendationController;
use App\Http\Controllers\Admin\CaseRequestController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\CriteriaController;
use App\Http\Controllers\Admin\DirectorController;
use App\Http\Controllers\Admin\FinancingInstrumentController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\IndustryTypeController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RequestTypeController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\UserCaseLogController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\UserTeamController;
use App\Http\Controllers\Auth\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\FinancialRoadmapController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccountController;
use App\Models\FinancialRoadmap;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth/admin.php';

Route::middleware('auth:admin')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::post('/dashboard-achievement', [HomeController::class, 'ajax_dashboard_kpi'])->name('dashboard-achievement');
    Route::post('/view-more-details', [HomeController::class, 'view_more_details'])->name('dashboard-view-more');

    //Bank Officer
//    Route::get('bank-officer/index', [BankOfficerListController::class, 'index'])->name('bank-officer.index');
//    Route::get('bank-officer/create', [BankOfficerListController::class, 'create'])->name('bank-officer.create');
//    Route::post('bank-officer/store', [BankOfficerListController::class, 'store'])->name('bank-officer.store');
//    Route::get('bank-officer/edit/{bank_officer_id}', [BankOfficerListController::class, 'edit'])->name('bank-officer.edit');
//    Route::get('bank-officer/show/{bank_officer_id}', [BankOfficerListController::class, 'show'])->name('bank-officer.show');
    Route::resource('bank-officers', Admin\BankOfficerListController::class);
    //account
    //    Route::get('account/index', [AccountController::class, 'reimbursement_index'])->name('account.reimbursement_index');
    //    Route::get('account/create', [AccountController::class, 'create'])->name('account.create');
    //    Route::get('account/edit', [AccountController::class, 'edit'])->name('account.edit');
    //    Route::get('account/reimbursement', [AccountController::class, 'reimbursement_index'])->name('account.reimbursement_index');
    Route::resource('accounts', AccountController::class);
    Route::post('accounts/generate-pdf', [App\Http\Controllers\Pdf\AccountController::class, 'generatePDF'])->name('accounts.generate-pdf');
    Route::get('accounts/export-pdf/{invoice_id}', [AccountController::class, 'exportPdfFromIndex'])->name('accounts.export-pdf');

    //report
    Route::get('reports/sales-index',               [ReportController::class, 'sales_index'])->name('report.sales_index');
    Route::get('reports/collection-index',          [ReportController::class, 'collection_index'])->name('report.collection_index');
    Route::get('reports/outstanding-index',         [ReportController::class, 'outstanding_index'])->name('report.outstanding_index');
    Route::get('reports/commission-index',          [ReportController::class, 'commission_index'])->name('report.commission_index');
    Route::post('reports/sales-modal',              [ReportController::class, 'sales_modal'])->name('report.sales_modal');
    Route::post('reports/outstanding-modal',        [ReportController::class, 'outstanding_modal'])->name('report.outstanding_modal');
    Route::put('reports/sales-modal/update',        [ReportController::class, 'sales_modal_update'])->name('report.sales_modal.update');
    Route::put('reports/outstanding-modal/update',  [ReportController::class, 'outstanding_modal_update'])->name('report.outstanding_modal.update');
    Route::post('reports/generate-pdf',             [ReportController::class, 'generate_report_pdf'])->name('report.generate_pdf');
    Route::post('reports/generate-excel',           [ReportController::class, 'generate_report_excel'])->name('report.generate_excel');
    Route::post('reports/layout-pdf',               [ReportController::class, 'layout_pdf'])->name('report.layout_pdf');
    Route::post('reports/layout-excel',             [ReportController::class, 'layout_excel'])->name('report.layout_excel');

    //financial roadmap
    Route::get('financial-roadmaps/index',  [FinancialRoadmapController::class, 'index'])->name('financial_roadmap.index');
    Route::get('financial-roadmaps/pending_index',  [FinancialRoadmapController::class, 'pending_index'])->name('financial_roadmap.pending_index');
    Route::get('financial-roadmaps/confirm_index',  [FinancialRoadmapController::class, 'confirm_index'])->name('financial_roadmap.confirm_index');
    Route::put('financial-roadmaps/update/{FinancialRoadmap}',  [FinancialRoadmapController::class, 'update'])->name('financial_roadmap.update');
    Route::get('financial-roadmaps/show/{FinancialRoadmap}', [FinancialRoadmapController::class, 'show'])->name('financial-roadmaps.show');
    Route::put('financial-roadmaps/updateStatus', [FinancialRoadmapController::class, 'updateStatus'])->name('financial-roadmaps.update_status');

    //refersh notification
    Route::post('notification/refreshNotification', [NotificationController::class, 'refreshNotification'])->name('notification.refreshNotification');
    Route::get('notification/index',  [NotificationController::class, 'index'])->name('notification.index');

    // Permissions
    Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', Admin\PermissionsController::class);

    // Roles
    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::post('roles/editAjax/{role}', [RolesController::class, 'editAjax'])->name('roles.editAjax');
    Route::post('roles/updateAjax/{role}', [RolesController::class, 'updateAjax'])->name('roles.updateAjax');
    Route::resource('roles', Admin\RolesController::class);

    // Users
    // Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::post('users/parse-csv-import', [UsersController::class, 'parseCsvImport'])->name('users.parseCsvImport');
    Route::post('users/process-csv-import', [UsersController::class, 'processCsvImport'])->name('users.processCsvImport');
    Route::put('users/{user}/remove', [Admin\UsersController::class, 'remove'])->name('users.remove');
    Route::put('users/{user}/restore', [Admin\UsersController::class, 'restore'])->name('users.restore');
//    Route::resource('users', Admin\UsersController::class)->except('destroy');
    Route::resource('users', Admin\UsersController::class);

    // Team
    Route::post('teams/checkmember', [Admin\TeamController::class, 'check'])->name('teams.checkmember');
    Route::resource('teams', Admin\TeamController::class);

    // Audit Logs
    Route::resource('audit-logs', Admin\AuditLogsController::class)->except('create', 'store', 'edit', 'update', 'destroy');

    // Countries
    Route::delete('countries/destroy', [CountriesController::class, 'massDestroy'])->name('countries.massDestroy');
    Route::post('countries/parse-csv-import', [CountriesController::class, 'parseCsvImport'])->name('countries.parseCsvImport');
    Route::post('countries/process-csv-import', [CountriesController::class, 'processCsvImport'])->name('countries.processCsvImport');
    Route::resource('countries', Admin\CountriesController::class);

    // State
    Route::delete('states/destroy', [StateController::class, 'massDestroy'])->name('states.massDestroy');
    Route::resource('states', Admin\StateController::class);

    // Case Lists
    Route::delete('case-lists/destroy', [CaseListsController::class, 'massDestroy'])->name('case-lists.massDestroy');
    Route::post('case-lists/parse-csv-import', [CaseListsController::class, 'parseCsvImport'])->name('case-lists.parseCsvImport');
    Route::post('case-lists/process-csv-import', [CaseListsController::class, 'processCsvImport'])->name('case-lists.processCsvImport');
    Route::post('case-lists/media',  [CaseListsController::class, 'storeMediaWithName'])->name('case-lists.storeMedia');

    // case table
    Route::get('case-lists/submitted',  [CaseListsController::class, 'submittedIndex'])->name('case-lists.submitted');
    Route::get('case-lists/rework',  [CaseListsController::class, 'reworkIndex'])->name('case-lists.rework');
    Route::get('case-lists/draft',  [CaseListsController::class, 'draftIndex'])->name('case-lists.draft');
    Route::get('case-lists/credit',  [CaseListsController::class, 'creditIndex'])->name('case-lists.credit');
    Route::get('case-lists/pending-result',  [CaseListsController::class, 'pendingResultIndex'])->name('case-lists.pending-result');
    Route::get('case-lists/pending-disbursement',  [CaseListsController::class, 'pendingDisbursementIndex'])->name('case-lists.pending-disbursement');
    // end of case table

    // print
    Route::get('case-lists/print/generate-pcr/{case_id}', [App\Http\Controllers\Pdf\PdfController::class, 'generatePDF'])->name('case-lists.print.generate-pcr');
    Route::post('financial-roadmaps/print/generate-roadmap-chart/{financialRoadmap}', [FinancialRoadmapController::class, 'generateChartImg'])->name('financial-roadmaps.print.generate-roadmaps-chart');
    Route::get('financial-roadmaps/print/generate-roadmap-pdf/{financialRoadmap}/{chartImg}', [FinancialRoadmapController::class, 'generatePDF'])->name('financial-roadmaps.print.generate-roadmaps-pdf');
    Route::post('master-call-lists/remark-history', [App\Http\Controllers\Pdf\CallRemarkHistoryPdfController::class, 'generatePDF'])->name('master-call-lists.remark-history.generate-pdf');
    Route::post('print/generate-invoice', [App\Http\Controllers\Pdf\BillingController::class, 'generateInvoice'])->name('print.generate-invoice');

    // Documents
    Route::post('case-lists/new-folders/{caseList}/{type}',  [\App\Http\Controllers\DocumentController::class, 'newFolders'])->name('case-lists.newFolders');
    Route::put('case-lists/{caseList}/remove', [\App\Http\Controllers\DocumentController::class, 'remove'])->name('case-lists.remove');
    Route::put('case-lists/{caseList}/restore', [\App\Http\Controllers\DocumentController::class, 'restore'])->name('case-lists.restore');
    Route::post('case-lists/store-documents/{caseList}/{type}',  [\App\Http\Controllers\DocumentController::class, 'storeDocuments'])->name('case-lists.storeDocuments');
    Route::post('case-lists/remove-folder/{caseList}/{type}',  [\App\Http\Controllers\DocumentController::class, 'removeFolder'])->name('case-lists.removeFolder');
    Route::get('case-lists/delete/{caseList}',  [\App\Http\Controllers\DocumentController::class, 'delete'])->name('case-lists.delete');
    Route::get('case-lists/zip/{caseList}',  [\App\Http\Controllers\DocumentController::class, 'zip'])->name('case-lists.zip');

    // other
    Route::post('case-lists/case-director-commitment',  [CaseListsController::class, 'directorCommitment'])->name('case-lists.directorCommitment');

    // Case View - Credit
    Route::get('case-lists/show-credit/{caseList}', [Admin\CaseViewController::class, 'showCredit'])->name('case-lists.show-credit');
    Route::post('case-lists/case-status-update', [Admin\CaseViewController::class, 'caseStatusUpdate'])->name('case-lists.caseStatusUpdate');
    Route::post('case-lists/store-memo', [Admin\CaseViewController::class, 'storeMemo'])->name('case-lists.storeMemo');
    Route::post('case-lists/find-bank-officers', [Admin\CaseViewController::class, 'findBankOfficers'])->name('case-lists.findBankOfficers');
    Route::post('case-lists/pcr-update', [Admin\CaseViewController::class, 'pcrUpdate'])->name('case-lists.pcrUpdate');

    // Case View - Case Information
    Route::get('case-lists/show-caseInfo/{caseList}', [Admin\CaseViewController::class, 'showCaseInfo'])->name('case-lists.show-caseInfo');
    Route::put('case-lists/kyc-edit/{caseList}',  [Admin\CaseViewController::class, 'kycEdit'])->name('case-lists.kyc-edit');
    Route::put('case-lists/financial-edit1/{caseList}',  [Admin\CaseViewController::class, 'finEdit1'])->name('case-lists.fin-edit-part1');
    Route::put('case-lists/financial-edit2/{caseList}',  [Admin\CaseViewController::class, 'finEdit2'])->name('case-lists.fin-edit-part2');
    Route::put('case-lists/bank-stt-edit/{caseList}',  [Admin\CaseViewController::class, 'bankSttEdit'])->name('case-lists.bankStt-edit');
    Route::put('case-lists/director-commitment-edit/{caseList}',  [Admin\CaseViewController::class, 'directorCommitmentEdit'])->name('case-lists.dicCmmt-edit');
    Route::post('case-lists/update-director-commitment', [CaseListsController::class, 'updateDirectorCommitment'])->name('case-lists.updateDirectorCommitment');

    // Case View - Attachment
    Route::get('case-lists/show-attachment/{caseList}', [Admin\CaseViewController::class, 'showAttachment'])->name('case-lists.show-attachment');

    // Case View - Agreement & Billing
    Route::get('case-lists/show-agreement/{caseList}', [Admin\CaseViewController::class, 'showAgreement'])->name('case-lists.show-agreement');
    Route::post('case-lists/show-agreement-billing-ajax', [Admin\CaseViewController::class, 'showAgreementBillingAjax'])->name('case-lists.show-agreement.billing-ajax');
    Route::post('case-lists/sign-action', [Admin\CaseViewController::class, 'signAction'])->name('case-lists.signAction');

    // Case View - Upload Payslip
    Route::post('payments/upload-payslip', [\App\Http\Controllers\PaymentsController::class, 'uploadPayslip'])->name('payments.upload-payslip');
    Route::post('payments/media', [\App\Http\Controllers\PaymentsController::class, 'storeMedia'])->name('payments.storeMedia');
    Route::post('payments/update-status', [\App\Http\Controllers\PaymentsController::class, 'updateStatus'])->name('payments.update-status');
    Route::post('payments/update-payslip', [\App\Http\Controllers\PaymentsController::class, 'updatePayslip'])->name('payments.update-payslip');
    Route::post('payments/create-payslip', [\App\Http\Controllers\PaymentsController::class, 'createPayslip'])->name('payments.create-payslip');
    Route::post('payments/fetch-data', [\App\Http\Controllers\PaymentsController::class, 'fetchData'])->name('payments.fetch-data');
    Route::post('payments/remove-payment', [\App\Http\Controllers\PaymentsController::class, 'removePayment'])->name('payments.remove-payment');



    Route::resource('case-lists', Admin\CaseListsController::class, ['except' => ['create']]);
    Route::post('case-lists/case-generate', [Admin\CaseListsController::class, 'caseGenerate'])->name('case-lists.case-generate');
    Route::get('case-lists/create/{caseList}', [Admin\CaseListsController::class, 'create'])->name('case-lists.create');
    Route::get('case-lists/kyc_view',  [CaseListsController::class, 'kycView'])->name('case-lists.kycView');

    // Industry Type
    Route::delete('industry-types/destroy', [IndustryTypeController::class, 'massDestroy'])->name('industry-types.massDestroy');
    Route::post('industry-types/parse-csv-import', [IndustryTypeController::class, 'parseCsvImport'])->name('industry-types.parseCsvImport');
    Route::post('industry-types/process-csv-import', [IndustryTypeController::class, 'processCsvImport'])->name('industry-types.processCsvImport');
    Route::resource('industry-types', Admin\IndustryTypeController::class);

    // City
    Route::delete('cities/destroy', [CityController::class, 'massDestroy'])->name('cities.massDestroy');
    Route::resource('cities', Admin\CityController::class);

    // Bank
    Route::delete('banks/destroy', [BankController::class, 'massDestroy'])->name('banks.massDestroy');
    Route::post('banks/parse-csv-import', [BankController::class, 'parseCsvImport'])->name('banks.parseCsvImport');
    Route::post('banks/process-csv-import', [BankController::class, 'processCsvImport'])->name('banks.processCsvImport');
    Route::put('banks/{bank}/remove', [Admin\BankController::class, 'remove'])->name('banks.remove');
    Route::put('banks/{bank}/restore', [Admin\BankController::class, 'restore'])->name('banks.restore');
    Route::resource('banks', Admin\BankController::class)->except('destroy');

    // Bank Statement
    Route::delete('bank-statements/destroy', [BankStatementController::class, 'massDestroy'])->name('bank-statements.massDestroy');
    Route::post('bank-statements/parse-csv-import', [BankStatementController::class, 'parseCsvImport'])->name('bank-statements.parseCsvImport');
    Route::post('bank-statements/process-csv-import', [BankStatementController::class, 'processCsvImport'])->name('bank-statements.processCsvImport');
    Route::resource('bank-statements', Admin\BankStatementController::class);

    // Case Request
    Route::delete('case-requests/destroy', [CaseRequestController::class, 'massDestroy'])->name('case-requests.massDestroy');
    Route::post('case-requests/parse-csv-import', [CaseRequestController::class, 'parseCsvImport'])->name('case-requests.parseCsvImport');
    Route::post('case-requests/process-csv-import', [CaseRequestController::class, 'processCsvImport'])->name('case-requests.processCsvImport');
    Route::resource('case-requests', Admin\CaseRequestController::class);

    // Request Type
    Route::delete('request-types/destroy', [RequestTypeController::class, 'massDestroy'])->name('request-types.massDestroy');
    Route::post('request-types/parse-csv-import', [RequestTypeController::class, 'parseCsvImport'])->name('request-types.parseCsvImport');
    Route::post('request-types/process-csv-import', [RequestTypeController::class, 'processCsvImport'])->name('request-types.processCsvImport');
    Route::resource('request-types', Admin\RequestTypeController::class);

    // Case Management Team
    Route::delete('case-management-teams/destroy', [CaseManagementTeamController::class, 'massDestroy'])->name('case-management-teams.massDestroy');
    Route::post('case-management-teams/parse-csv-import', [CaseManagementTeamController::class, 'parseCsvImport'])->name('case-management-teams.parseCsvImport');
    Route::post('case-management-teams/process-csv-import', [CaseManagementTeamController::class, 'processCsvImport'])->name('case-management-teams.processCsvImport');
    Route::resource('case-management-teams', Admin\CaseManagementTeamController::class);

    // Case Document
    Route::delete('case-documents/destroy', [CaseDocumentController::class, 'massDestroy'])->name('case-documents.massDestroy');
    Route::post('case-documents/media', [CaseDocumentController::class, 'storeMedia'])->name('case-documents.storeMedia');
    Route::post('case-documents/ckmedia', [CaseDocumentController::class, 'storeCKEditorImages'])->name('case-documents.storeCKEditorImages');
    Route::post('case-documents/parse-csv-import', [CaseDocumentController::class, 'parseCsvImport'])->name('case-documents.parseCsvImport');
    Route::post('case-documents/process-csv-import', [CaseDocumentController::class, 'processCsvImport'])->name('case-documents.processCsvImport');
    Route::resource('case-documents', Admin\CaseDocumentController::class);

    // Case Credit Check
    Route::delete('case-credit-checks/destroy', [CaseCreditCheckController::class, 'massDestroy'])->name('case-credit-checks.massDestroy');
    Route::post('case-credit-checks/parse-csv-import', [CaseCreditCheckController::class, 'parseCsvImport'])->name('case-credit-checks.parseCsvImport');
    Route::post('case-credit-checks/process-csv-import', [CaseCreditCheckController::class, 'processCsvImport'])->name('case-credit-checks.processCsvImport');
    Route::resource('case-credit-checks', Admin\CaseCreditCheckController::class);

    // Director
    Route::delete('directors/destroy', [DirectorController::class, 'massDestroy'])->name('directors.massDestroy');
    Route::post('directors/parse-csv-import', [DirectorController::class, 'parseCsvImport'])->name('directors.parseCsvImport');
    Route::post('directors/process-csv-import', [DirectorController::class, 'processCsvImport'])->name('directors.processCsvImport');
    Route::resource('directors', Admin\DirectorController::class);

    // Case Financial
    Route::delete('case-financials/destroy', [CaseFinancialController::class, 'massDestroy'])->name('case-financials.massDestroy');
    Route::post('case-financials/parse-csv-import', [CaseFinancialController::class, 'parseCsvImport'])->name('case-financials.parseCsvImport');
    Route::post('case-financials/process-csv-import', [CaseFinancialController::class, 'processCsvImport'])->name('case-financials.processCsvImport');
    Route::resource('case-financials', Admin\CaseFinancialController::class);

    // Case Commitment
    Route::delete('case-commitments/destroy', [CaseCommitmentController::class, 'massDestroy'])->name('case-commitments.massDestroy');
    Route::post('case-commitments/parse-csv-import', [CaseCommitmentController::class, 'parseCsvImport'])->name('case-commitments.parseCsvImport');
    Route::post('case-commitments/process-csv-import', [CaseCommitmentController::class, 'processCsvImport'])->name('case-commitments.processCsvImport');
    Route::resource('case-commitments', Admin\CaseCommitmentController::class);

    // Case Director Commitment
    Route::delete('case-director-commitments/destroy', [CaseDirectorCommitmentController::class, 'massDestroy'])->name('case-director-commitments.massDestroy');
    Route::post('case-director-commitments/parse-csv-import', [CaseDirectorCommitmentController::class, 'parseCsvImport'])->name('case-director-commitments.parseCsvImport');
    Route::post('case-director-commitments/process-csv-import', [CaseDirectorCommitmentController::class, 'processCsvImport'])->name('case-director-commitments.processCsvImport');
    Route::resource('case-director-commitments', Admin\CaseDirectorCommitmentController::class);

    // Case Gearing
    Route::delete('case-gearings/destroy', [CaseGearingController::class, 'massDestroy'])->name('case-gearings.massDestroy');
    Route::post('case-gearings/parse-csv-import', [CaseGearingController::class, 'parseCsvImport'])->name('case-gearings.parseCsvImport');
    Route::post('case-gearings/process-csv-import', [CaseGearingController::class, 'processCsvImport'])->name('case-gearings.processCsvImport');
    Route::resource('case-gearings', Admin\CaseGearingController::class);

    // Criteria
    Route::delete('criteria/destroy', [CriteriaController::class, 'massDestroy'])->name('criteria.massDestroy');
    Route::post('criteria/parse-csv-import', [CriteriaController::class, 'parseCsvImport'])->name('criteria.parseCsvImport');
    Route::post('criteria/process-csv-import', [CriteriaController::class, 'processCsvImport'])->name('criteria.processCsvImport');
    Route::resource('criteria', Admin\CriteriaController::class);

    // Case Criteria
    Route::delete('case-criteria/destroy', [CaseCriteriaController::class, 'massDestroy'])->name('case-criteria.massDestroy');
    Route::post('case-criteria/parse-csv-import', [CaseCriteriaController::class, 'parseCsvImport'])->name('case-criteria.parseCsvImport');
    Route::post('case-criteria/process-csv-import', [CaseCriteriaController::class, 'processCsvImport'])->name('case-criteria.processCsvImport');
    Route::resource('case-criteria', Admin\CaseCriteriaController::class);

    // Case Report Recommendation
    Route::delete('case-report-recommendations/destroy', [CaseReportRecommendationController::class, 'massDestroy'])->name('case-report-recommendations.massDestroy');
    Route::resource('case-report-recommendations', Admin\CaseReportRecommendationController::class);

    // Application Type
    Route::delete('application-types/destroy', [ApplicationTypeController::class, 'massDestroy'])->name('application-types.massDestroy');
    Route::post('application-types/parse-csv-import', [ApplicationTypeController::class, 'parseCsvImport'])->name('application-types.parseCsvImport');
    Route::post('application-types/process-csv-import', [ApplicationTypeController::class, 'processCsvImport'])->name('application-types.processCsvImport');
    Route::resource('application-types', Admin\ApplicationTypeController::class);

    // User Team
    Route::delete('user-teams/destroy', [UserTeamController::class, 'massDestroy'])->name('user-teams.massDestroy');
    Route::post('user-teams/parse-csv-import', [UserTeamController::class, 'parseCsvImport'])->name('user-teams.parseCsvImport');
    Route::post('user-teams/process-csv-import', [UserTeamController::class, 'processCsvImport'])->name('user-teams.processCsvImport');
    Route::resource('user-teams', Admin\UserTeamController::class);

    // Case Credit Check Type
    Route::delete('case-credit-check-types/destroy', [CaseCreditCheckTypeController::class, 'massDestroy'])->name('case-credit-check-types.massDestroy');
    Route::post('case-credit-check-types/parse-csv-import', [CaseCreditCheckTypeController::class, 'parseCsvImport'])->name('case-credit-check-types.parseCsvImport');
    Route::post('case-credit-check-types/process-csv-import', [CaseCreditCheckTypeController::class, 'processCsvImport'])->name('case-credit-check-types.processCsvImport');
    Route::resource('case-credit-check-types', Admin\CaseCreditCheckTypeController::class);

    // Case Dsr
    Route::delete('case-dsrs/destroy', [CaseDsrController::class, 'massDestroy'])->name('case-dsrs.massDestroy');
    Route::post('case-dsrs/parse-csv-import', [CaseDsrController::class, 'parseCsvImport'])->name('case-dsrs.parseCsvImport');
    Route::post('case-dsrs/process-csv-import', [CaseDsrController::class, 'processCsvImport'])->name('case-dsrs.processCsvImport');
    Route::resource('case-dsrs', Admin\CaseDsrController::class);

    // Case Cashflow Mon Commit
    Route::delete('case-cashflow-mon-commits/destroy', [CaseCashflowMonCommitController::class, 'massDestroy'])->name('case-cashflow-mon-commits.massDestroy');
    Route::post('case-cashflow-mon-commits/parse-csv-import', [CaseCashflowMonCommitController::class, 'parseCsvImport'])->name('case-cashflow-mon-commits.parseCsvImport');
    Route::post('case-cashflow-mon-commits/process-csv-import', [CaseCashflowMonCommitController::class, 'processCsvImport'])->name('case-cashflow-mon-commits.processCsvImport');
    Route::resource('case-cashflow-mon-commits', Admin\CaseCashflowMonCommitController::class);

    // Financing Instrument
    Route::delete('financing-instruments/destroy', [FinancingInstrumentController::class, 'massDestroy'])->name('financing-instruments.massDestroy');
    Route::post('financing-instruments/parse-csv-import', [FinancingInstrumentController::class, 'parseCsvImport'])->name('financing-instruments.parseCsvImport');
    Route::post('financing-instruments/process-csv-import', [FinancingInstrumentController::class, 'processCsvImport'])->name('financing-instruments.processCsvImport');
    Route::resource('financing-instruments', Admin\FinancingInstrumentController::class);

    // Case Financing Instrument
    Route::delete('case-financing-instruments/destroy', [CaseFinancingInstrumentController::class, 'massDestroy'])->name('case-financing-instruments.massDestroy');
    Route::post('case-financing-instruments/parse-csv-import', [CaseFinancingInstrumentController::class, 'parseCsvImport'])->name('case-financing-instruments.parseCsvImport');
    Route::post('case-financing-instruments/process-csv-import', [CaseFinancingInstrumentController::class, 'processCsvImport'])->name('case-financing-instruments.processCsvImport');
    Route::resource('case-financing-instruments', Admin\CaseFinancingInstrumentController::class);

    // Case Call Log
    Route::delete('case-call-logs/destroy', [CaseCallLogController::class, 'massDestroy'])->name('case-call-logs.massDestroy');
    Route::resource('case-call-logs', Admin\CaseCallLogController::class);

    // User Case Log
    Route::delete('user-case-logs/destroy', [UserCaseLogController::class, 'massDestroy'])->name('user-case-logs.massDestroy');
    Route::post('user-case-logs/parse-csv-import', [UserCaseLogController::class, 'parseCsvImport'])->name('user-case-logs.parseCsvImport');
    Route::post('user-case-logs/process-csv-import', [UserCaseLogController::class, 'processCsvImport'])->name('user-case-logs.processCsvImport');
    Route::post('user-case-logs/ckmedia', [UserCaseLogController::class, 'storeCKEditorImages'])->name('user-case-logs.storeCKEditorImages');
    Route::resource('user-case-logs', Admin\UserCaseLogController::class);

    //Profile
    Route::post('profile/media',  [Admin\ProfileController::class, 'storeMedia'])->name('profile.storeMedia');
    Route::resource('profile', Admin\ProfileController::class);

    // Master Call List
    //Route::post('master-call-lists/export-remark-history', [Admin\MasterCallListsController::class, 'exportCallRemarkHistory'])->name('master-call-lists.export-remark-history');
    Route::get('master-call-lists/remark-history', [Admin\MasterCallListsController::class, 'remarkHistory'])->name('master-call-lists.remark-history');
    Route::resource('master-call-lists', Admin\MasterCallListsController::class);
    Route::post('master-call-lists/seperate-phone', [Admin\MasterCallListsController::class, 'seperatePhone'])->name('master-call-lists.seperate-phone');

    Route::resource('salesman-calls', Admin\MasterCallUserTasksController::class);
    Route::post('salesman-calls/case-log-history',[Admin\MasterCallUserTasksController::class, 'caseLogHistory'])->name('salesman-calls.case-log-history');
    Route::get('salesman-calls/all-call/index', [Admin\MasterCallUserTasksController::class, 'allCall'])->name('salesman-calls.all-call.index');
    Route::post('salesman-calls/called-phone', [Admin\MasterCallUserTasksController::class, 'calledPhone'])->name('salesman-calls.called-phone');
    Route::post('salesman-calls/add-case', [Admin\MasterCallUserTasksController::class, 'addCase'])->name('salesman-calls.add-case');

    // Commission settings
    Route::resource('commission_settings', \App\Http\Controllers\CommissionSettingsController::class)->except('destroy');

    // proforma
    Route::post('agreement-billing/proforma/update',[Admin\CaseViewController::class, 'proformaUpdate'])->name('agreement-billing.proforma.update');

    // invoice
    Route::post('agreement-billing/invoice/update',[Admin\CaseViewController::class, 'invoiceUpdate'])->name('agreement-billing.invoice.update');
    Route::post('agreement-billing/invoice/generate-no',[Admin\CaseViewController::class, 'invoiceGenerateNo'])->name('agreement-billing.invoice.generate-no');

    // management
    Route::resource('management', \App\Http\Controllers\ManagementsController::class);

});
Route::prefix('profile')->name('profile.')->middleware('auth:admin')->group(function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', [ChangePasswordController::class, 'edit'])->name('password.edit');
        Route::post('password', [ChangePasswordController::class, 'update'])->name('password.update');
        Route::post('profile', [ChangePasswordController::class, 'updateProfile'])->name('password.updateProfile');
        Route::post('profile/destroy', [ChangePasswordController::class, 'destroy'])->name('password.destroyProfile');
    }
});

<?php
use App\Http\Controllers\Api;
use App\Http\Controllers\Api\V1\Admin\ApplicationTypeApiController;
use App\Http\Controllers\Api\V1\Admin\BankApiController;
use App\Http\Controllers\Api\V1\Admin\BankStatementApiController;
use App\Http\Controllers\Api\V1\Admin\CaseCashflowMonCommitApiController;
use App\Http\Controllers\Api\V1\Admin\CaseCommitmentApiController;
use App\Http\Controllers\Api\V1\Admin\CaseCreditCheckApiController;
use App\Http\Controllers\Api\V1\Admin\CaseCreditCheckTypeApiController;
use App\Http\Controllers\Api\V1\Admin\CaseCriteriaApiController;
use App\Http\Controllers\Api\V1\Admin\CaseDirectorCommitmentApiController;
use App\Http\Controllers\Api\V1\Admin\CaseDocumentApiController;
use App\Http\Controllers\Api\V1\Admin\CaseDsrApiController;
use App\Http\Controllers\Api\V1\Admin\CaseFinancialApiController;
use App\Http\Controllers\Api\V1\Admin\CaseFinancingInstrumentApiController;
use App\Http\Controllers\Api\V1\Admin\CaseGearingApiController;
use App\Http\Controllers\Api\V1\Admin\CaseListsApiController;
use App\Http\Controllers\Api\V1\Admin\CaseManagementTeamApiController;
use App\Http\Controllers\Api\V1\Admin\CaseReportRecommendationApiController;
use App\Http\Controllers\Api\V1\Admin\CaseRequestApiController;
use App\Http\Controllers\Api\V1\Admin\CountriesApiController;
use App\Http\Controllers\Api\V1\Admin\CriteriaApiController;
use App\Http\Controllers\Api\V1\Admin\DirectorApiController;
use App\Http\Controllers\Api\V1\Admin\FinancingInstrumentApiController;
use App\Http\Controllers\Api\V1\Admin\IndustryTypeApiController;
use App\Http\Controllers\Api\V1\Admin\RequestTypeApiController;
use App\Http\Controllers\Api\V1\Admin\UserCaseLogApiController;
use App\Http\Controllers\Api\V1\Admin\UsersApiController;
use App\Http\Controllers\Api\V1\Admin\UserTeamApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.')->middleware('auth:sanctum')->group(function () {
    // Users
    Route::apiResource('users', UsersApiController::class);

    // Countries
    Route::apiResource('countries', CountriesApiController::class);

    // Case Lists
    Route::apiResource('case-lists', CaseListsApiController::class);

    // Industry Type
    Route::apiResource('industry-types', IndustryTypeApiController::class);

    // Bank
    Route::apiResource('banks', BankApiController::class);

    // Bank Statement
    Route::apiResource('bank-statements', BankStatementApiController::class);

    // Case Request
    Route::apiResource('case-requests', CaseRequestApiController::class);

    // Request Type
    Route::apiResource('request-types', RequestTypeApiController::class);

    // Case Management Team
    Route::apiResource('case-management-teams', CaseManagementTeamApiController::class);

    // Case Document
    Route::post('case-documents/media', [CaseDocumentApiController::class, 'storeMedia'])->name('case-documents.storeMedia');
    Route::apiResource('case-documents', CaseDocumentApiController::class);

    // Case Credit Check
    Route::apiResource('case-credit-checks', CaseCreditCheckApiController::class);

    // Director
    Route::apiResource('directors', DirectorApiController::class);

    // Case Financial
    Route::apiResource('case-financials', CaseFinancialApiController::class);

    // Case Commitment
    Route::apiResource('case-commitments', CaseCommitmentApiController::class);

    // Case Director Commitment
    Route::apiResource('case-director-commitments', CaseDirectorCommitmentApiController::class);

    // Case Gearing
    Route::apiResource('case-gearings', CaseGearingApiController::class);

    // Criteria
    Route::apiResource('criteria', CriteriaApiController::class);

    // Case Criteria
    Route::apiResource('case-criteria', CaseCriteriaApiController::class);

    // Case Report Recommendation
    Route::apiResource('case-report-recommendations', CaseReportRecommendationApiController::class);

    // Application Type
    Route::apiResource('application-types', ApplicationTypeApiController::class);

    // User Team
    Route::apiResource('user-teams', UserTeamApiController::class);

    // Case Credit Check Type
    Route::apiResource('case-credit-check-types', CaseCreditCheckTypeApiController::class);

    // Case Dsr
    Route::apiResource('case-dsrs', CaseDsrApiController::class);

    // Case Cashflow Mon Commit
    Route::apiResource('case-cashflow-mon-commits', CaseCashflowMonCommitApiController::class);

    // Financing Instrument
    Route::apiResource('financing-instruments', FinancingInstrumentApiController::class);

    // Case Financing Instrument
    Route::apiResource('case-financing-instruments', CaseFinancingInstrumentApiController::class);

    // User Case Log
    Route::apiResource('user-case-logs', UserCaseLogApiController::class);
});

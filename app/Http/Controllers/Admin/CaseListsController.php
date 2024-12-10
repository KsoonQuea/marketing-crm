<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CaseListDataTable;
use App\Enum\Status;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Views\CaseController;
use App\Http\Requests\MassDestroyCaseListRequest;
use App\Http\Requests\StoreCaseListRequest;
use App\Http\Requests\UpdateCaseListRequest;
use App\Models\ApplicationType;
use App\Models\Bank;
use App\Models\BankOfficer;
use App\Models\BankStatement;
use App\Models\BankStatus;
use App\Models\CaseBank;
use App\Models\CaseBankStatus;
use App\Models\CaseCallLog;
use App\Models\CaseCommitment;
use App\Models\CaseCreditCheck;
use App\Models\CaseCreditCheckType;
use App\Models\CaseCriterion;
use App\Models\CaseDirectorCommitment;
use App\Models\CaseDisburse;
use App\Models\CaseFinancial;
use App\Models\CaseFinancingInstrument;
use App\Models\CaseGearingView;
use App\Models\CaseList;
use App\Models\CaseManagementTeam;
use App\Models\CaseReportRecommendation;
use App\Models\CaseRequest;
use App\Models\City;
use App\Models\Claim;
use App\Models\Country;
use App\Models\creditReport;
use App\Models\Director;
use App\Models\dsrView;
use App\Models\CashFlowView;
use App\Models\CaseNewFinancingInstrumentView;
use App\Models\FinancingInstrument;
use App\Models\IndustryType;
use App\Models\Memo;
use App\Models\RequestType;
use App\Models\State;
use App\Models\User;
use App\Notifications\CaseCreateNotification;
use App\Notifications\PendingApproveNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\Team;
use App\Models\UserCaseLog;
use App\Models\UserTeam;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use File;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use stdClass;
use Session;
use App\Http\Requests\Traits\StoreMediaMediaUploadingTraitRequest;

class CaseListsController extends Controller
{
    protected $base_path;

    use CsvImportTrait;
    use MediaUploadingTrait;

    private function reformatToNumeric($input)
    {
        $nagtive = 0;
        if (strpos($input, '(') !== false) {
            $nagtive = 1;
        }
        $new_input = floatval(preg_replace('/[^\d.]/', '', $input));
        $new_value = number_format($new_input, 2, '.', '');
        if ($nagtive == 1) {
            $return = -$new_value;
        } else {
            $return = $new_value;
        }
        return $return;
    }

    private function reformatToNumericThree($input)
    {
        $nagtive = 0;
        if (strpos($input, '(') !== false) {
            $nagtive = 1;
        }
        $new_input = floatval(preg_replace('/[^\d.]/', '', $input));
        $new_value = number_format($new_input, 3, '.', '');
        if ($nagtive == 1) {
            $return = -$new_value;
        } else {
            $return = $new_value;
        }
        return $return;
    }

    // table start
    public function index(Request $request)
    {
        //        abort_if(Gate::denies('case_list_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        abort_if(!(Gate::denies('case_all_index_2') ^ Gate::denies('case_personal_index_2')), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $isSalesMan = !Gate::denies('case_personal_index_2');

            $query = CaseList::when($isSalesMan, function ($query2) {
                return $query2->whereHas('salesman.teams', function ($query) {
                    $query->where('team_lead_id', Auth::user()->id);
                })->orWhere('salesman_id', Auth::user()->id);
            });
            $query->where('draft_status', '!=', 0); // ignore draft

            //get the salesman name
            $query->with(['salesman']);

            // search inputs
            if (isset($request->search_status) && $request->search_status != 'all') {
                $query->where('case_status', $request->search_status);
            }
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->where('created_at', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('case_code', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('company_name', 'LIKE', '%' . $search_input . '%');
                $query->orWhereHas('salesman', function ($querySalesman) use ($search_input) {
                    $querySalesman->where('name', 'LIKE', '%' . $search_input . '%');
                });
            }
            if ($request->date_from !== null && $request->date_to !== null) {
                $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
            } else {
                if ($request->date_from !== null) {
                    $query->where('created_at', '>=', $request->date_from);
                }
                if ($request->date_to !== null) {
                    $query->where('created_at', '<=', $request->date_to);
                }
            }
            $query->select(sprintf('%s.*', (new CaseList())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name = 'case_list';
                $permission_name = 'case';
                $except = ['edit', 'destroy'];
                $active = $row->case_status !== 4;
                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row',
                    'active'
                ));
            });
            $table->editColumn('case_code', function ($row) {
                $url = route('admin.case-lists.show', $row->id);
                $link = '<a href="' . $url . '">' . ($row->case_code ?? '-') . '</a>';
                return $link;
            });
            $table->editColumn('case_status', function ($row) {
                $status_name = CaseList::STATUS_SELECT[$row->case_status ?? 0];
                $status_class =  CaseList::STATUS_CLASSES[$row->case_status ?? 0];
                return '<b class="text-' . $status_class . '">' . $status_name . '</b>';
            });
            $table->editColumn('salesman.name', function ($row) {
                return $row->salesman ? $row->salesman->name : "";
            });
            $table->editColumn('case_branch', function ($row) {
                return '<b>' . CaseList::BRANCH_LIST[0] . '</b>';;
            });
            $table->rawColumns(['actions', 'placeholder', 'case_code', 'case_status', 'case_branch', 'salesman.name']);
            return $table->make(true);
        }

        return view('admin.caseLists.index');
    }

    public function draftIndex(Request $request)
    {
        abort_if(Gate::denies('draft_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = CaseList::where('draft_status', 0)->where(function ($query) {
                $query->where('salesman_id', Auth::user()->id)->orWhere('created_by', Auth::user()->id);
            });
            // search inputs
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->where('created_at', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('case_code', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('company_name', 'LIKE', '%' . $search_input . '%');
                $query->orWhereHas('salesman', function ($querySalesman) use ($search_input) {
                    $querySalesman->where('name', 'LIKE', '%' . $search_input . '%');
                });
            }
            if ($request->date_from !== null && $request->date_to !== null) {
                $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
            } else {
                if ($request->date_from !== null) {
                    $query->where('created_at', '>=', $request->date_from);
                }
                if ($request->date_to !== null) {
                    $query->where('created_at', '<=', $request->date_to);
                }
            }
            $query->select(sprintf('%s.*', (new CaseList())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name = 'case_list';
                $permission_name = 'draft';
                $except = [''];
                $active = $row->case_status !== 4;
                return view('admin.caseLists.partials.draftDatatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row',
                    'active'
                ));
            });
            $table->editColumn('case_code', function ($row) {
                $url = route('admin.case-lists.create', $row->id);
                $link = '<a href="' . $url . '">' . ($row->case_code ?? '-') . '</a>';
                return $link;
            });
            $table->editColumn('salesman.name', function ($row) {
                return $row->salesman ? $row->salesman->name : "";
            });
            $table->editColumn('case_branch', function ($row) {
                return CaseList::BRANCH_LIST[($row->case_branch ?? 0)];
            });
            $table->editColumn('draft_status', function ($row) {
                return '<b class="text-muted">Draft</b>';
            });
            $table->rawColumns(['actions', 'placeholder', 'case_code', 'salesman.name', 'case_branch', 'draft_status']);
            return $table->make(true);
        }
        return view('admin.caseLists.draft');
    }

    public function submittedIndex(Request $request)
    {
        abort_if(!(Gate::denies('case_all_submitted_index_2') ^ Gate::denies('case_personal_submitted_index_2')), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $isSalesMan = !Gate::denies('case_personal_submitted_index_2');

            $query = CaseList::when($isSalesMan, function ($query2) {
                return $query2->whereHas('salesman.teams', function ($query) {
                    $query->where('team_lead_id', Auth::user()->id);
                })->orWhere('salesman_id', Auth::user()->id);
            });

            $query->where('draft_status', '!=', 0)->where('case_status', 0); // ignore draft & only pending status

            //            dd($query->count());

            // search inputs
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->where('created_at', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('case_code', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('company_name', 'LIKE', '%' . $search_input . '%');
                $query->orWhereHas('salesman', function ($querySalesman) use ($search_input) {
                    $querySalesman->where('name', 'LIKE', '%' . $search_input . '%');
                });
            }
            if ($request->date_from !== null && $request->date_to !== null) {
                $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
            } else {
                if ($request->date_from !== null) {
                    $query->where('created_at', '>=', $request->date_from);
                }
                if ($request->date_to !== null) {
                    $query->where('created_at', '<=', $request->date_to);
                }
            }
            $query->select(sprintf('%s.*', (new CaseList())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name = 'case_list';
                $permission_name = 'case';
                $except = ['edit', 'destroy'];
                $active = $row->case_status !== 4;
                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row',
                    'active'
                ));
            });
            $table->editColumn('case_code', function ($row) {
                $url = route('admin.case-lists.show', $row->id);
                $link = '<a href="' . $url . '">' . ($row->case_code ?? '-') . '</a>';
                return $link;
            });
            $table->editColumn('salesman.name', function ($row) {
                return $row->salesman ? $row->salesman->name : "";
            });
            $table->editColumn('case_branch', function ($row) {
                return CaseList::BRANCH_LIST[($row->case_branch ?? 0)];
            });
            $table->editColumn('case_status', function ($row) {
                $status_name = CaseList::STATUS_SELECT[$row->case_status ?? 0];
                $status_class =  CaseList::STATUS_CLASSES[$row->case_status ?? 0];
                return '<b class="text-' . $status_class . '">' . $status_name . '</b>';
            });
            $table->rawColumns(['actions', 'placeholder', 'case_code', 'salesman.name', 'case_branch', 'case_status']);
            return $table->make(true);
        }
        return view('admin.caseLists.submitted');
    }

    public function reworkIndex(Request $request)
    {
        abort_if(!(Gate::denies('case_all_rework_index_2') ^ Gate::denies('case_personal_rework_index_2')), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $isSalesMan = !Gate::denies('case_personal_rework_index_2');

            $query = CaseList::when($isSalesMan, function ($query2) {
                return $query2->where('case_status', 3)->where('salesman_id', Auth::user()->id);
            })->where('case_status', 3);

            // search inputs
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->where('created_at', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('case_code', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('company_name', 'LIKE', '%' . $search_input . '%');
                $query->orWhereHas('salesman', function ($querySalesman) use ($search_input) {
                    $querySalesman->where('name', 'LIKE', '%' . $search_input . '%');
                });
            }
            if ($request->date_from !== null && $request->date_to !== null) {
                $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
            } else {
                if ($request->date_from !== null) {
                    $query->where('created_at', '>=', $request->date_from);
                }
                if ($request->date_to !== null) {
                    $query->where('created_at', '<=', $request->date_to);
                }
            }
            $query->select(sprintf('%s.*', (new CaseList())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name = 'case_list';
                $permission_name = 'case';
                $except = ['edit', 'destroy'];
                $active = $row->case_status !== 4;
                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row',
                    'active'
                ));
            });
            $table->editColumn('case_code', function ($row) {
                $url = route('admin.case-lists.show', $row->id);
                $link = '<a href="' . $url . '">' . ($row->case_code ?? '-') . '</a>';
                return $link;
            });
            $table->editColumn('salesman.name', function ($row) {
                return $row->salesman ? $row->salesman->name : "";
            });
            $table->editColumn('case_branch', function ($row) {
                return CaseList::BRANCH_LIST[($row->case_branch ?? 0)];
            });
            $table->editColumn('case_status', function ($row) {
                $status_name = CaseList::STATUS_SELECT[$row->case_status ?? 0];
                $status_class =  CaseList::STATUS_CLASSES[$row->case_status ?? 0];
                return '<b class="text-' . $status_class . '">' . $status_name . '</b>';
            });
            $table->rawColumns(['actions', 'placeholder', 'case_code', 'salesman.name', 'case_branch', 'case_status']);
            return $table->make(true);
        }
        return view('admin.caseLists.rework');
    }

    public function creditIndex(Request $request)
    {
        abort_if(Gate::denies('case_credit_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $platform_status = $request->sort;

        if ($request->ajax()) {
            $query = CaseBank::with(['bank', 'case.salesman']);
            // search inputs
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->whereHas('case', function ($queryCase) use ($search_input) {
                    $queryCase->where('case_code', 'LIKE', '%' . $search_input . '%');
                    $queryCase->orWhere('company_name', 'LIKE', '%' . $search_input . '%');
                    $queryCase->orWhere('created_at', 'LIKE', '%' . $search_input . '%');
                    $queryCase->orWhereHas('salesman', function ($querySalesman) use ($search_input) {
                        $querySalesman->where('name', 'LIKE', '%' . $search_input . '%');
                    });
                })->orWhereHas('bank', function ($queryBank) use ($search_input) {
                    $queryBank->where('name', 'LIKE', '%' . $search_input . '%');
                });
            }
            if (isset($request->search_bank_status_id) && $request->search_bank_status_id != 'all') {
                $status = $request->search_bank_status_id;
                $previous_status = $status - 1;
                $query->where('current_status', $previous_status);
            }
            $query->select(sprintf('%s.*', (new CaseBank())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('bank.name', function ($row) {
                return $row->bank->name ?? '-';
            });
            $table->editColumn('case.case_code', function ($row) {
                $url = route('admin.case-lists.show', $row->case->id);
                $case_code = $row->case->case_code ?? '-';
                return '<a href="' . $url . '">' . $case_code . '</a>';
            });
            $table->editColumn('case.company_name', function ($row) {
                return $row->case ? $row->case->company_name : "";
            });
            $table->editColumn('current_status', function ($row) {
                $current_status = '';
                $newStatus = $row->current_status + 1;
                $BankStatus = BankStatus::find($newStatus);
                if ($BankStatus) {
                    $current_status = 'Pending ' . $BankStatus->name;
                } else if ($newStatus == 8) {
                    $current_status = 'Disbursed';
                }
                return $current_status;
            });
            $table->editColumn('case.salesman.name', function ($row) {
                return $row->case->salesman ? $row->case->salesman->name : "";
            });
            $table->editColumn('case.case_branch', function ($row) {
                return CaseList::BRANCH_LIST[($row->case->case_branch ?? 0)];
            });
            $table->editColumn('case.created_at', function ($row) {
                return date("Y-m-d", strtotime($row->case->created_at));
            });
            $table->rawColumns(['actions', 'placeholder', 'case.case_code', 'current_status', 'case.case_branch', 'case.salesman.name']);
            return $table->make(true);
        }
        $bankStatus = BankStatus::all();
        $totalAgreement = $this->counterAgreement();
        $totalSiteVisit = $this->counterSiteVisit();
        $totalCaseSubmission = $this->counterCaseSubmission();
        $totalApproval = $this->counterApproval();
        $totalAcceptance = $this->counterAcceptance();
        $totalDisbursement = $this->counterDisbursement();
        return view('admin.caseLists.credit', compact('bankStatus', 'platform_status', 'totalAgreement', 'totalSiteVisit','totalCaseSubmission','totalApproval','totalAcceptance','totalDisbursement'));
    }

    private function counterAgreement()
    {
        $query = CaseBank::with(['bank', 'case.salesman']);
        $status = 1 ;
        $query->where('current_status', $status);
        $query->select(sprintf('%s.*', (new CaseBank())->table));
        return $query->count();
    }

    private function counterSiteVisit()
    {
        $query = CaseBank::with(['bank', 'case.salesman']);
        $status = 2;
        $query->where('current_status', $status);
        $query->select(sprintf('%s.*', (new CaseBank())->table));
        return $query->count();
    }

    private function counterCaseSubmission()
    {
        $query = CaseBank::with(['bank', 'case.salesman']);
        $status = 3;
        $query->where('current_status', $status);
        $query->select(sprintf('%s.*', (new CaseBank())->table));
        return $query->count();
    }

    private function counterApproval()
    {
        $query = CaseBank::with(['bank', 'case.salesman']);
        $status = 4;
        $query->where('current_status', $status);
        $query->select(sprintf('%s.*', (new CaseBank())->table));
        return $query->count();
    }

    private function counterAcceptance()
    {
        $query = CaseBank::with(['bank', 'case.salesman']);
        $status = 5;
        $query->where('current_status', $status);
        $query->select(sprintf('%s.*', (new CaseBank())->table));
        return $query->count();
    }

    private function counterDisbursement()
    {
        $query = CaseBank::with(['bank', 'case.salesman']);
        $status = 6;
        $query->where('current_status', $status);
        $query->select(sprintf('%s.*', (new CaseBank())->table));
        return $query->count();
    }

    public function pendingResultIndex(Request $request)
    {
        abort_if(Gate::denies('case_pending_result_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = CaseBank::with(['bank', 'case.salesman'])->where('current_status', '<', 5)->where('current_status', '>', 0);
            // search inputs
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->whereHas('case', function ($queryCase) use ($search_input) {
                    $queryCase->where('case_code', 'LIKE', '%' . $search_input . '%');
                    $queryCase->orWhere('company_name', 'LIKE', '%' . $search_input . '%');
                    $queryCase->orWhere('created_at', 'LIKE', '%' . $search_input . '%');
                    $queryCase->orWhereHas('salesman', function ($querySalesman) use ($search_input) {
                        $querySalesman->where('name', 'LIKE', '%' . $search_input . '%');
                    });
                })->orWhereHas('bank', function ($queryBank) use ($search_input) {
                    $queryBank->where('name', 'LIKE', '%' . $search_input . '%');
                });
            }
            if (isset($request->search_bank_status_id) && $request->search_bank_status_id != 'all') {
                $status = $request->search_bank_status_id;
                $previous_status = $status - 1;
                $query->where('current_status', $previous_status);
            }
            $query->select(sprintf('%s.*', (new CaseBank())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('bank.name', function ($row) {
                return $row->bank->name ?? '-';
            });
            $table->editColumn('case.case_code', function ($row) {
                $url = route('admin.case-lists.show', $row->case->id);
                $case_code = $row->case->case_code ?? '-';
                return '<a href="' . $url . '">' . $case_code . '</a>';
            });
            $table->editColumn('case.company_name', function ($row) {
                return $row->case ? $row->case->company_name : "";
            });
            $table->editColumn('current_status', function ($row) {
                $current_status = '';
                $newStatus = $row->current_status + 1;
                $BankStatus = BankStatus::find($newStatus);
                if ($BankStatus) {
                    $current_status = 'Pending ' . $BankStatus->name;
                } else if ($newStatus == 8) {
                    $current_status = 'Disbursed';
                }
                return $current_status;
            });
            $table->editColumn('case.salesman.name', function ($row) {
                return $row->case->salesman ? $row->case->salesman->name : "";
            });
            $table->editColumn('case.case_branch', function ($row) {
                return CaseList::BRANCH_LIST[($row->case->case_branch ?? 0)];
            });
            $table->editColumn('case.created_at', function ($row) {
                return date("Y-m-d", strtotime($row->case->created_at));
            });
            $table->rawColumns(['actions', 'placeholder', 'case.case_code', 'current_status', 'case.case_branch', 'case.salesman.name']);
            return $table->make(true);
        }
        $bankStatus = BankStatus::all();
        return view('admin.caseLists.pendingResult', compact('bankStatus'));
    }

    public function pendingDisbursementIndex(Request $request)
    {
        abort_if(Gate::denies('case_pending_disbursement_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = CaseBank::with(['bank', 'case.salesman'])->where('current_status', '<', 7)->where('current_status', '>=', 5);
            // search inputs
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->whereHas('case', function ($queryCase) use ($search_input) {
                    $queryCase->where('case_code', 'LIKE', '%' . $search_input . '%');
                    $queryCase->orWhere('company_name', 'LIKE', '%' . $search_input . '%');
                    $queryCase->orWhere('created_at', 'LIKE', '%' . $search_input . '%');
                    $queryCase->orWhereHas('salesman', function ($querySalesman) use ($search_input) {
                        $querySalesman->where('name', 'LIKE', '%' . $search_input . '%');
                    });
                })->orWhereHas('bank', function ($queryBank) use ($search_input) {
                    $queryBank->where('name', 'LIKE', '%' . $search_input . '%');
                });
            }
            if (isset($request->search_bank_status_id) && $request->search_bank_status_id != 'all') {
                $status = $request->search_bank_status_id;
                $previous_status = $status - 1;
                $query->where('current_status', $previous_status);
            }
            $query->select(sprintf('%s.*', (new CaseBank())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('bank.name', function ($row) {
                return $row->bank->name ?? '-';
            });
            $table->editColumn('case.case_code', function ($row) {
                $url = route('admin.case-lists.show', $row->case->id);
                $case_code = $row->case->case_code ?? '-';
                return '<a href="' . $url . '">' . $case_code . '</a>';
            });
            $table->editColumn('case.company_name', function ($row) {
                return $row->case ? $row->case->company_name : "";
            });
            $table->editColumn('current_status', function ($row) {
                $current_status = '';
                $newStatus = $row->current_status + 1;
                $BankStatus = BankStatus::find($newStatus);
                if ($BankStatus) {
                    $current_status = 'Pending ' . $BankStatus->name;
                } else if ($newStatus == 8) {
                    $current_status = 'Disbursed';
                }
                return $current_status;
            });
            $table->editColumn('case.salesman.name', function ($row) {
                return $row->case->salesman ? $row->case->salesman->name : "";
            });
            $table->editColumn('case.case_branch', function ($row) {
                return CaseList::BRANCH_LIST[($row->case->case_branch ?? 0)];
            });
            $table->editColumn('case.created_at', function ($row) {
                return date("Y-m-d", strtotime($row->case->created_at));
            });
            $table->rawColumns(['actions', 'placeholder', 'case.case_code', 'current_status', 'case.case_branch', 'case.salesman.name']);
            return $table->make(true);
        }
        $bankStatus = BankStatus::all();
        return view('admin.caseLists.pendingDisbursement', compact('bankStatus'));
    }
    // end of table

    public function caseGenerate()
    {
        abort_if(Gate::denies('case_create_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //Create New case
        $case_latest_num = CaseList::select('id')->count() + 1;

        $case_code = 'C' . sprintf('%05d', $case_latest_num);

        $caseList = CaseList::create([
            'case_code'     => $case_code,
            'salesman_id'   => Auth::user()->id,
        ]);

        return redirect()->route('admin.case-lists.create', $caseList);
    }

    public function create(CaseList $caseList)
    {
        abort_if(Gate::denies('case_create_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //Pass Value
        $salesmen       = User::with('roles')->whereHas('roles', function ($query){
            /*
            * 1 : Super Admin
            * 2 : Admin
            * 3 : BFE
            * 4 : Sales Manager
            * 5 : Credit
            * 6 : Account
            * */
            $query->where('role_id', 3);
        })->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $role_id        = Auth::user()?->roles?->first()?->id;
        $salesmen_name  = Auth::user()->name;
        $salesmen_id    = Auth::user()->id;

        //catch salesman id,name
        $users = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_id')
            ->where('role_id', '=', '2')
            ->where('model_type', '=', 'App\Models\User')
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        //get case financial
        $fye_1 = CaseFinancial::all()->where('case_id', '=', $caseList->id)->where('group_id', '=', '1')->sortBy(['id', 'desc'])->first();
        $fye_2 = CaseFinancial::all()->where('case_id', '=', $caseList->id)->where('group_id', '=', '2')->sortBy(['id', 'desc'])->first();
        $fye_3 = CaseFinancial::all()->where('case_id', '=', $caseList->id)->where('group_id', '=', '3')->sortBy(['id', 'desc'])->first();

        //get case commitment
        $caseCommitment                 = CaseCommitment::all()->where('case_id', '=', $caseList->id);

        $directors                      = Director::get(['id', 'name', 'ic']);

        $industry_types                 = IndustryType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $application_types              = ApplicationType::pluck('name', 'id');

        $request_types                  = RequestType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '0');

        $case_credit_check_types        = CaseCreditCheckType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities                         = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '0');

        $states                         = State::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '0');

        $countries                      = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '0');

        $banks                          = Bank::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '0');

        $financingInstruments           = FinancingInstrument::get(['loan_product', 'id', 'interest_rate', 'tenor', 'tenor_number', 'tenor_month', 'able_edit_type']);

        $financingInstruments_loan      = FinancingInstrument::where('type', '=', '0')->get(['loan_product', 'id', 'interest_rate', 'tenor', 'tenor_number', 'tenor_month']);

        $financingInstruments_capboost  = FinancingInstrument::where('type', '=', '1')->get(['loan_product', 'id', 'interest_rate', 'tenor', 'tenor_number', 'tenor_month']);

        $docController = new DocumentController();
        $documentsView = $docController->getDocumentsDirectory($caseList);

        //get case request
        $caseRequest        = CaseRequest::all()->where('case_id', '=', $caseList->id);

        //get case mgmt team
        $caseMgmtTeam       = CaseManagementTeam::all()->where('case_id', '=', $caseList->id);

        //get case credit check
        $caseCreditCheck    = CaseCreditCheck::all()->where('case_id', '=', $caseList->id);

        //get the case commitments
        $case_commitment_loop   = CaseCommitment::select(['house_loan', 'term_loan', 'hire_purchase', 'credit_card_limit', 'trade_line_limit'])->where('case_id', '=', $caseList->id)->get();
        $case_commitment_count  = CaseCommitment::all()->count();
        $case_commitment        = CaseCommitment::all()->except(['house_loan', 'term_loan', 'hire_purchase', 'credit_card_limit', 'trade_line_limit'])->where('case_id', '=', $caseList->id)->first();

        // BankStatement (new)
        $bank_statements_date_array     = array();
        $bank_statements_credit_array   = array();
        $bank_statements_debit_array    = array();
        $bank_statements_month_array    = array();
        $bank_statements = BankStatement::where('case_id', $caseList->id)->groupBy('group_id')->orderBy('group_id', 'asc')->get();
        foreach ($bank_statements as $rowBS) {
            $bank_id = $rowBS->bank_id;
            $group_id = $rowBS->group_id;
            $bank_statements_details_date_array     = array();
            $bank_statements_details_credit_array   = array();
            $bank_statements_details_debit_array    = array();
            $bank_statements_details_month_array    = array();
            $bank_statements_details  = BankStatement::select(['credit', 'debit', 'month_end_balance', 'month'])
                ->where('case_id', '=', $caseList->id)
                ->where('bank_id', '=', $bank_id)
                ->where('group_id', '=', $group_id)
                ->get();

            foreach ($bank_statements_details as $bank_statements_detail_key => $bank_statements_detail_item) {
                array_push($bank_statements_details_date_array, $bank_statements_detail_item->month);
                array_push($bank_statements_details_credit_array, $bank_statements_detail_item->credit);
                array_push($bank_statements_details_debit_array, $bank_statements_detail_item->debit);
                array_push($bank_statements_details_month_array, $bank_statements_detail_item->month_end_balance);
            }

            array_push($bank_statements_date_array,     $bank_statements_details_date_array);
            array_push($bank_statements_credit_array,   $bank_statements_details_credit_array);
            array_push($bank_statements_debit_array,    $bank_statements_details_debit_array);
            array_push($bank_statements_month_array,    $bank_statements_details_month_array);
        }
        //        $bank_statements        = BankStatement::with('bank')->where('case_id', '=', $caseList->id)->groupBy('bank_id')->orderBy('bank_id')->get();
        //
        //        $bank_statements_date_array     = array();
        //        $bank_statements_credit_array   = array();
        //        $bank_statements_debit_array    = array();
        //        $bank_statements_month_array    = array();
        //
        //        foreach ($bank_statements as $bank_statements_credit_key => $bank_statement_item){
        //            $bank_statements_details_date_array     = array();
        //            $bank_statements_details_credit_array   = array();
        //            $bank_statements_details_debit_array    = array();
        //            $bank_statements_details_month_array    = array();
        //
        //            $bank_statements_details  = BankStatement::select(['credit', 'debit', 'month_end_balance', 'month'])->where('case_id', '=', $caseList->id)->where('bank_id', '=', $bank_statement_item->bank_id)->get();
        //
        //            foreach ($bank_statements_details as $bank_statements_detail_key => $bank_statements_detail_item){
        //                array_push($bank_statements_details_date_array, $bank_statements_detail_item->month);
        //                array_push($bank_statements_details_credit_array, $bank_statements_detail_item->credit);
        //                array_push($bank_statements_details_debit_array, $bank_statements_detail_item->debit);
        //                array_push($bank_statements_details_month_array, $bank_statements_detail_item->month_end_balance);
        //
        //            }
        //
        //            array_push($bank_statements_date_array,     $bank_statements_details_date_array);
        //            array_push($bank_statements_credit_array,   $bank_statements_details_credit_array);
        //            array_push($bank_statements_debit_array,    $bank_statements_details_debit_array);
        //            array_push($bank_statements_month_array,    $bank_statements_details_month_array);
        //        }

        $director_commitment_array          = array();
        $final_director_commitment_array    = array();

        $director_commitment = CaseDirectorCommitment::with('director')->where('case_id', '=', $caseList->id)->groupBy('director_id')->orderBy('director_id')->get();

        foreach ($director_commitment as $director_commitment_key => $director_commitment_item) {
            $director_commitment_hl_array       = array();
            $director_commitment_pl_array       = array();
            $director_commitment_hp_array       = array();
            $director_commitment_cc_array       = array();

            $director_commitment_details  = CaseDirectorCommitment::select(['house_loan', 'personal_loan', 'hire_purchase', 'credit_card_limit'])->where('case_id', '=', $caseList->id)->where('director_id', '=', $director_commitment_item->director_id)->get();

            //            dd($director_commitment_details);

            foreach ($director_commitment_details as $director_commitment_details_key => $director_commitment_details_item) {
                array_push($director_commitment_hl_array,    $director_commitment_details[$director_commitment_details_key]->house_loan);
                array_push($director_commitment_pl_array,    $director_commitment_details[$director_commitment_details_key]->personal_loan);
                array_push($director_commitment_hp_array,    $director_commitment_details[$director_commitment_details_key]->hire_purchase);
                array_push($director_commitment_cc_array,    $director_commitment_details[$director_commitment_details_key]->credit_card_limit);
            }

            $director_commitment_array['id']    = $director_commitment_item->director->id;
            $director_commitment_array['name']  = $director_commitment_item->director->name;
            $director_commitment_array['ic']    = $director_commitment_item->director->ic;

            $director_commitment_array['hl']    = $director_commitment_hl_array;
            $director_commitment_array['pl']    = $director_commitment_pl_array;
            $director_commitment_array['hp']    = $director_commitment_hp_array;
            $director_commitment_array['cc']    = $director_commitment_cc_array;

            $director_commitment_array['total_hl']    = $director_commitment_item->total_hl;
            $director_commitment_array['total_pl']    = $director_commitment_item->total_pl;
            $director_commitment_array['total_hp']    = $director_commitment_item->total_hp;
            $director_commitment_array['total_cc']    = $director_commitment_item->total_cc;

            $director_commitment_array['total_cc_charge']       = $director_commitment_item->total_cc_charge;
            $director_commitment_array['sub_total']             = $director_commitment_item->sub_total;
            $director_commitment_array['total']                 = $director_commitment_item->final_total;

            array_push($final_director_commitment_array, $director_commitment_array);
        }

        // CaseFinancingInstrument
        $case_financingInstruments_loan      = CaseFinancingInstrument::with('financing_instrument')->where('financing_instrument_id', '!=', '7')->where('case_id', '=', $caseList->id)->get();
        // CaseFinancingInstrument (capboost)
        $case_financingInstruments_capboost  = CaseFinancingInstrument::with('financing_instrument')->where('financing_instrument_id', '=', '7')->where('case_id', '=', $caseList->id)->get();

        $financingInstruments_loan = FinancingInstrument::where('type', '=', '0')->get(['loan_product', 'id', 'interest_rate', 'tenor', 'tenor_number', 'tenor_month', 'able_edit_type']);
        $financingInstruments_capboost  = FinancingInstrument::where('type', '=', '1')->get(['loan_product', 'id', 'interest_rate', 'tenor', 'tenor_number', 'tenor_month', 'able_edit_type']);

        return view('admin.caseLists.create', compact('application_types', 'users', 'cities', 'countries', 'directors', 'industry_types', 'salesmen', 'states', 'financingInstruments_loan', 'financingInstruments_capboost', 'banks', 'case_credit_check_types', 'request_types', 'financingInstruments', 'role_id', 'salesmen_id', 'salesmen_name', 'documentsView', 'caseList', 'case_commitment_loop', 'case_commitment', 'fye_1', 'fye_2', 'fye_3', 'case_commitment_count', 'bank_statements', 'bank_statements_credit_array', 'bank_statements_debit_array', 'bank_statements_month_array', 'bank_statements_date_array', 'final_director_commitment_array', 'caseRequest', 'caseMgmtTeam', 'caseCreditCheck', 'caseCommitment', 'case_financingInstruments_loan', 'case_financingInstruments_capboost', 'financingInstruments_loan', 'financingInstruments_capboost'));
    }

    public function remove(CaseList $caseList)
    {
        abort_if(Gate::denies('case_remove_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseList->update([
            'case_status' => Status::Inactive,
        ]);

        return redirect()->back();
    }

    public function show(Request $request, CaseList $caseList)
    {
        abort_if(Gate::denies('case_view_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return redirect()->route('admin.case-lists.show-credit',$caseList->id);
    }

    public function update(Request $request, CaseList $caseList)
    {
        $case_id    = $caseList->id;
        $case_code  = $caseList->case_code;

        try {
            $is_admin = 0;
            // check is admin added or not
            if (Gate::check('add_other_bfe_access')) {
                $is_admin = 1;
            }

            //KYC PArt
            // -- 1. Normal
            $incorporation_date = $request->get('incorporation_date');
            $applicaion_date    = date('Y-m-d');
            $kyc_details        = $request->only(
                'salesman_id',
                'company_name',
                'business_activity',
                'address',
                'industry_type_id',
                'business_bg',
                'remark',
            );

            $kyc_details['created_by'] = Auth::user()->id;

            //            return_access 0 : draft
            //            return_access 1 : document
            //            return_access 2 : create

            $return_access = 0;
            switch ($request->input('caseCreateSubmission')) {
                case 'draft':
                    $kyc_details['draft_status'] = 0;
                    $kyc_details['salesmen_status'] = 0;

                    //                    if ($is_admin == 1){
                    //                        $kyc_details['salesman_id'] = Auth::user()->id;
                    //                    }

                    break;
                case 'case_create':
                    $kyc_details['draft_status'] = 1;
                    $kyc_details['salesmen_status'] = 1;
                    $return_access = 2;
                    break;
                default: //document as draft
                    $kyc_details['draft_status'] = 0;
                    $kyc_details['salesmen_status'] = 0;

                    //                    if ($is_admin == 1){
                    //                        $kyc_details['salesman_id'] = Auth::user()->id;
                    //                    }

                    $return_access = 1;
            }

            $kyc_details['incorporation_date']  = $incorporation_date;
            $kyc_details['applicaion_date']     = $applicaion_date;
            $kyc_details['salesmen_status']     = 0;
            $kyc_details['case_status']         = 0;

            $caseList->update($kyc_details);
            $caseList->application_types()->attach($request->input('application_type', []));

            // --2. Request
            CaseRequest::where('case_id', $caseList->id)->delete();
            if ($request->get('request') != null) {
                foreach ($request->get('request') as $key => $request_id) {
                    $facility_type      = $request->get('facility_type')[$key];
                    $amount             = $request->get('amount')[$key];
                    $specific_concern   = $request->get('specific_concern')[$key];

                    if ($facility_type == null && ($amount == null || $amount = 0) && $specific_concern == null) {
                    } else {
                        CaseRequest::create([
                            'request'           => $request_id,
                            'facility_type'     => $facility_type,
                            'amount'            => $amount,
                            'specific_concern'  => $specific_concern,
                            'case_id'           => $case_id
                        ]);
                    }
                }
            }

            // --3. mgmt team
            CaseManagementTeam::where('case_id', $caseList->id)->delete();
            if ($request->get('mgmt_team_name') != null) {
                foreach ($request->get('mgmt_team_name') as $key => $mgmt_team_name) {
                    //                    $mgmt_team_age                  = $request->get('mgmt_team_age')[$key];
                    $mgmt_team_ic                  = $request->get('mgmt_team_ic')[$key];
                    $mgmt_team_phone                = $request->get('mgmt_team_phone')[$key];
                    $mgmt_team_email                = $request->get('mgmt_team_email')[$key];
                    $mgmt_team_designation          = $request->get('mgmt_team_designation')[$key];
                    $mgmt_team_shareholding         = $request->get('mgmt_team_shareholding')[$key];
                    $mgmt_team_responsibilityArea   = $request->get('mgmt_team_responsibilityArea')[$key];
                    $mgmt_team_expeienceYear        = $request->get('mgmt_team_expeienceYear')[$key];
                    $mgmt_team_companyYear          = $request->get('mgmt_team_companyYear')[$key];
                    $mgmt_team_relationship         = $request->get('mgmt_team_relationship')[$key];

                    CaseManagementTeam::create([
                        'name'                  => $mgmt_team_name,
                        //                        'age'                   => $mgmt_team_age,
                        'ic'                    => $mgmt_team_ic,
                        'phone'                 => $mgmt_team_phone,
                        'email'                 => $mgmt_team_email,
                        'designation'           => $mgmt_team_designation,
                        'shareholding'          => $mgmt_team_shareholding,
                        'responsible_area'      => $mgmt_team_responsibilityArea,
                        'experience_year'       => $mgmt_team_expeienceYear,
                        'case_year'             => $mgmt_team_companyYear,
                        'director_relationship' => $mgmt_team_relationship,
                        'case_id'               => $case_id,
                    ]);
                }
            } else {
                for ($i = 0; $i < sizeof($request->get('mgmt_team_name')); $i++) {
                    CaseManagementTeam::create([
                        'name'                  => null,
                        'age'                   => null,
                        'ic'                    => null,
                        'phone'                 => null,
                        'email'                 => null,
                        'designation'           => null,
                        'shareholding'          => null,
                        'responsible_area'      => null,
                        'experience_year'       => null,
                        'case_year'             => null,
                        'director_relationship' => null,
                        'case_id'               => $case_id,
                    ]);
                }
            }

            // --4. credit check
            CaseCreditCheck::where('case_id', $caseList->id)->delete();
            if ($request->get('credit_check_type') != null) {
                foreach ($request->get('credit_check_type') as $key => $credit_check_type) {
                    $director_n_company                  = $request->get('director_n_company')[$key];
                    $credit_check_finding                = $request->get('credit_check_finding')[$key];
                    $credit_check_mitigation             = $request->get('credit_check_mitigation')[$key];

                    if ($director_n_company == null && $credit_check_finding == null && $credit_check_mitigation == null) {
                    } else {
                        CaseCreditCheck::create([
                            'director_n_company'        => $director_n_company,
                            'finding'                   => $credit_check_finding,
                            'migration'                 => $credit_check_mitigation,
                            'credit_check_id'           => $credit_check_type,
                            'case_id'                   => $case_id,
                        ]);
                    }
                }
            }

            // Financial Part
            // --1. FYP
            CaseFinancial::where('case_id', $caseList->id)->delete();

            for ($i = 1; $i <= 3; $i++) {
//                $fye_date                   = db_date_format((string)$request->get('fye_date' . $i));
                $fye_date                   = $request->get('fye_date' . $i);
                $fye_auditor                = $request->get('fye_auditor' . $i);
                $fye_non_current_asset      = $this->reformatToNumeric($request->get('fye_non_current_asset' . $i) ?? 0);
                $fye_current_asset          = $this->reformatToNumeric($request->get('fye_current_asset' . $i)  ?? 0);
                $fye_other_asset            = $this->reformatToNumeric($request->get('fye_other_asset' . $i) ?? 0);
                $fye_non_current_liability  = $this->reformatToNumeric($request->get('fye_non_current_liability' . $i) ?? 0);
                $fye_current_liability      = $this->reformatToNumeric($request->get('fye_current_liability' . $i) ?? 0);
                $fye_other_liability        = $this->reformatToNumeric($request->get('fye_other_liability' . $i) ?? 0);
                $fye_current_maturity       = $this->reformatToNumeric($request->get('fye_current_maturity' . $i) ?? 0);
                $fye_equity                 = $this->reformatToNumeric($request->get('fye_equity' . $i) ?? 0);
                $share_capital              = $this->reformatToNumeric($request->get('share_capital' . $i) ?? 0);
                $fye_retained_earning       = $this->reformatToNumeric($request->get('fye_retained_earning' . $i) ?? 0);
                $fye_tnw                    = $this->reformatToNumeric($request->get('fye_tnw' . $i) ?? 0);
                $fye_revenue                = $this->reformatToNumeric($request->get('fye_revenue' . $i) ?? 0);
                $fye_cost                   = $this->reformatToNumeric($request->get('fye_cost' . $i) ?? 0);
                $fye_gross_profit           = $this->reformatToNumeric($request->get('fye_gross_profit' . $i) ?? 0);
                $fye_finance_cost           = $this->reformatToNumeric($request->get('fye_finance_cost' . $i) ?? 0);
                $fye_depreciation           = $this->reformatToNumeric($request->get('fye_depreciation' . $i) ?? 0);
                $fye_profit_bfr_tax         = $this->reformatToNumeric($request->get('fye_profit_bfr_tax' . $i) ?? 0);
                $fye_profit_aft_tax         = $this->reformatToNumeric($request->get('fye_profit_aft_tax' . $i) ?? 0);
                $fye_ebitda                 = $this->reformatToNumeric($request->get('fye_ebitda' . $i) ?? 0);

                CaseFinancial::create([
                    'group_id'                  => $i,
                    'financial_date'            => $fye_date,
                    'auditor'                   => $fye_auditor,
                    'non_current_asset'         => $fye_non_current_asset,
                    'current_asset'             => $fye_current_asset,
                    'other_asset'               => $fye_other_asset,
                    'non_current_liabilities'   => $fye_non_current_liability,
                    'current_liabilities'       => $fye_current_liability,
                    'other_liabilities'         => $fye_other_liability,
                    'current_maturity'          => $fye_current_maturity,
                    'equity'                    => $fye_equity,
                    'share_capital'             => $share_capital,
                    'retained_earnings'         => $fye_retained_earning,
                    'tnw'                       => $fye_tnw,
                    'revenue'                   => $fye_revenue,
                    'sales_cost'                => $fye_cost,
                    'gross_profit'              => $fye_gross_profit,
                    'finance_cost'              => $fye_finance_cost,
                    'depreciation'              => $fye_depreciation,
                    'profit_bfr_tax'            => $fye_profit_bfr_tax,
                    'profit_aft_tax'            => $fye_profit_aft_tax,
                    'ebitda'                    => $fye_ebitda,
                    'case_id'                   => $case_id,
                ]);
            }

            // --2. Commitment from CCRIS
            CaseCommitment::where('case_id', $caseList->id)->delete();

            if ($request->get('case_commitment_houseLoan') != null) {
                foreach ($request->get('case_commitment_houseLoan') as $key => $case_commitment_houseLoan) {
                    $case_commitment_houseLoan              = $this->reformatToNumeric($case_commitment_houseLoan ?? 0);
                    $case_commitment_termLoan               = $this->reformatToNumeric($request->get('case_commitment_termLoan')[$key] ?? 0);
                    $case_commitment_hirePurchase           = $this->reformatToNumeric($request->get('case_commitment_hirePurchase')[$key] ?? 0);
                    $case_commitment_cc                     = $this->reformatToNumeric($request->get('case_commitment_cc')[$key] ?? 0);
                    $case_commitment_trade_line             = $this->reformatToNumeric($request->get('case_commitment_trade_line')[$key] ?? 0);
                    $total_caseCommitment_hl                = $this->reformatToNumeric($request->get('total_caseCommitment_hl') ?? 0);
                    $total_caseCommitment_tl                = $this->reformatToNumeric($request->get('total_caseCommitment_tl') ?? 0);
                    $total_caseCommitment_hp                = $this->reformatToNumeric($request->get('total_caseCommitment_hp') ?? 0);
                    $total_caseCommitment_cc                = $this->reformatToNumeric($request->get('total_caseCommitment_cc') ?? 0);
                    $total_caseCommitment_trade_line        = $this->reformatToNumeric($request->get('total_caseCommitment_trade_line') ?? 0);
                    $total_caseCommitment_cc_charge         = $this->reformatToNumeric($request->get('total_caseCommitment_cc_charge') ?? 0);
                    $total_caseCommitment_trade_line_charge = $this->reformatToNumeric($request->get('total_caseCommitment_trade_line_charge') ?? 0);
                    $final_total_caseCommitment             = $this->reformatToNumeric($request->get('final_total_caseCommitment') ?? 0);
                    CaseCommitment::create([
                        'house_loan'        => $case_commitment_houseLoan,
                        'term_loan'         => $case_commitment_termLoan,
                        'hire_purchase'     => $case_commitment_hirePurchase,
                        'credit_card_limit' => $case_commitment_cc,
                        'trade_line_limit'  => $case_commitment_trade_line,
                        'total_hl'          => $total_caseCommitment_hl,
                        'total_tl'          => $total_caseCommitment_tl,
                        'total_hp'          => $total_caseCommitment_hp,
                        'total_cc'          => $total_caseCommitment_cc,
                        'total_trade_line'  => $total_caseCommitment_trade_line,
                        'cc_charge'         => $total_caseCommitment_cc_charge,
                        'tl_charge'         => $total_caseCommitment_trade_line_charge,
                        'final_total'       => $final_total_caseCommitment,
                        'case_id'           => $case_id
                    ]);
                }
            }

            // --3. Commitment from CCRIS Part 2
            //update normal
            $fin_part2 = $request->only(
                'dsr_bankStt_commitment',
                'cash_flow_factor',
                'gearing_date',
                'gearing_borrow',
                'gearing_redemtion',
            );

            $caseList->update([
                'dsr_bankStt_commitment'    => str_replace(',', '', $request->get('dsr_bankStt_commitment') ?? 0),
                'cash_flow_factor'          => str_replace(',', '', $request->get('cash_flow_factor') ?? 0),
                'gearing_date'              => $request->get('gearing_date'),
                'gearing_borrow'            => str_replace(',', '', $request->get('gearing_borrow') ?? 0),
                'gearing_redemtion'         => str_replace(',', '', $request->get('gearing_redemtion') ?? 0),
            ]);

            // update financing instrument
            CaseFinancingInstrument::where('case_id', $case_id)->delete();
            if($request->get('financingInstrument_id') !== NULL){
                foreach ($request->get('financingInstrument_id') as $key => $FI_id){
                    $tenor = str_replace(',', '', $request->get('financingInstrument_tenor_input')[$key]);
                    if($tenor == NULL){ $tenor = 0; } else if($tenor == 'On demand' ){ $tenor = 0.8; }
                    CaseFinancingInstrument::create([
                        'proposed_limit' => $this->reformatToNumeric($request->get('financingInstrument_propose_limit')[$key]) ?? 0,
                        'interest_rate' => $this->reformatToNumericThree($request->get('financingInstrument_interest_rate')[$key]) ?? 0,
                        'tenor' => $tenor,
                        'commitments'  => $this->reformatToNumeric($request->get('financingInstrument_commitment')[$key]) ?? 0,
                        'financing_instrument_id' => $FI_id ?? 0,
                        'case_id' => $case_id,
                        'total_proposed_limit' => $this->reformatToNumeric($request->get('financingInstrument_total_propose_loan')) ?? 0,
                        'total_commitments' => $this->reformatToNumeric($request->get('financingInstrument_total_commitment_loan')) ?? 0,
                    ]);
                }
            }
            // update financing instrument (cap-boost)
            if($request->get('financingInstrument_id_capboost') !== NULL){
                foreach ($request->get('financingInstrument_id_capboost') as $key => $FI_id_cb){
                    CaseFinancingInstrument::create([
                        'proposed_limit' => $this->reformatToNumeric($request->get('financingInstrument_propose_limit_capboost')[$key]) ?? 0,
                        'interest_rate' => $this->reformatToNumericThree($request->get('financingInstrument_interest_rate_capboost')[$key]) ?? 0,
                        'tenor' => NULL,
                        'commitments'  => $this->reformatToNumeric($request->get('financingInstrument_commitment_capboost')[$key]) ?? 0,
                        'financing_instrument_id' => $FI_id_cb ?? 0,
                        'case_id' => $case_id,
                        'total_proposed_limit' => $this->reformatToNumeric($request->get('financingInstrument_total_propose_capboost')) ?? 0,
                        'total_commitments' => $this->reformatToNumeric($request->get('financingInstrument_total_commitment_capboost')) ?? 0,
                    ]);
                }
            }

            //Bank Statement Part
            BankStatement::where('case_id', $caseList->id)->delete();
            if ($request->get('bankStt_bank_id') != null) {
                foreach ($request->get('bankStt_bank_id') as $key => $bankStt_bank_id) {

                    if ($request->get('bank_statement_date') != null) {
                        foreach ($request->get('bank_statement_date')[$key] as $new_key => $bankSttDate) {
                            BankStatement::create([
                                //one array
                                'case_id'                       => $case_id,
                                'bank_id'                       => $bankStt_bank_id,
                                'currency'                      => $request->get('bankStt_currency')[$key],
                                'month'                         => $bankSttDate,
                                'avg_credit'                    => reformatToNumeric($request->get('avg_credit_transaction')[$key] ?? 0),
                                'avg_debit'                     => reformatToNumeric($request->get('avg_debit_transaction')[$key] ?? 0),
                                'avg_month_end_balance'         => reformatToNumeric($request->get('avg_month_balance')[$key] ?? 0),

                                //two array
                                'credit'                        => reformatToNumeric($request->get('bank_statement_credit_transaction')[$key][$new_key] ?? 0),
                                'debit'                         => reformatToNumeric($request->get('bank_statement_debit_transaction')[$key][$new_key] ?? 0),
                                'month_end_balance'             => reformatToNumeric($request->get('bank_statement_month_end_balance')[$key][$new_key] ?? 0),

                                //none array
                                'total_avg_credit'              => reformatToNumeric($request->get('final_total_credit_transaction') ?? 0),
                                'total_avg_debit'               => reformatToNumeric($request->get('final_total_debit_transaction') ?? 0),
                                'total_avg_month_end_balance'   => reformatToNumeric($request->get('final_total_month_end_balance_transaction') ?? 0),
                                'group_id'                      => $key,

                            ]);
                        }
                    }
                }
            }

            //Director Commitment Part
            CaseDirectorCommitment::where('case_id', $caseList->id)->delete();

            if ($request->get('total_director_commitment_hl') != null) {
                foreach ($request->get('total_director_commitment_hl') as $key => $total_director_commitment_hl) {

                    $find_director = Director::where('name', $request->get('hidden_director_name')[$key])->where('ic', $request->get('hidden_director_ic')[$key])->first();

                    if (!$find_director) {
                        $new_director = Director::create([
                            'name'             => $request->get('hidden_director_name')[$key],
                            'ic'               => $request->get('hidden_director_ic')[$key],
                            'phone'            => $request->get('hidden_director_phone')[$key] ?? null,
                        ]);
                    }

                    foreach ($request->get('director_commitment_hl')[$key] as $new_key => $director_commitment_hl) {

                        CaseDirectorCommitment::create([
                            //one array
                            'case_id'                   => $case_id,
                            //                    'director_id'               => $request->get('hidden_director_id')[$key],
                            'director_id'               => $new_director->id ?? $find_director->id,
                            'director_name'             => $request->get('hidden_director_name')[$key],
                            'director_ic'               => $request->get('hidden_director_ic')[$key],
                            'phone'                     => $request->get('hidden_director_phone')[$key] ?? null,
                            'total_hl'                  => str_replace(',', '', $request->get('total_director_commitment_hl')[$key] ?? 0),
                            'total_pl'                  => str_replace(',', '', $request->get('total_director_commitment_pl')[$key] ?? 0),
                            'total_hp'                  => str_replace(',', '', $request->get('total_director_commitment_hp')[$key] ?? 0),
                            'total_cc'                  => str_replace(',', '', $request->get('total_director_commitment_cc')[$key] ?? 0),
                            'total_cc_charge'           => str_replace(',', '', $request->get('director_commitment_cc_charge')[$key] ?? 0),
                            'sub_total'                 => str_replace(',', '', $request->get('final_total_director_commitment')[$key] ?? 0),

                            //two array
                            'house_loan'                => str_replace(',', '', $request->get('director_commitment_hl')[$key][$new_key] ?? 0),
                            'personal_loan'             => str_replace(',', '', $request->get('director_commitment_pl')[$key][$new_key] ?? 0),
                            'hire_purchase'             => str_replace(',', '', $request->get('director_commitment_hp')[$key][$new_key] ?? 0),
                            'credit_card_limit'         => str_replace(',', '', $request->get('director_commitment_cc')[$key][$new_key] ?? 0),

                            //none array
                            'final_total'               => str_replace(',', '', $request->get('all_final_total_director_commitment') ?? 0),
                            'group_id'                  => $key,

                        ]);
                    }
                }
            }

            //send notification
            if ($request->input('caseCreateSubmission') == 'case_create') {

                /*
                 * 1 : Super Admin
                 * 2 : Admin
                 * 3 : BFE
                 * 4 : Sales Manager
                 * 5 : Credit
                 * 6 : Account
                 * */

                // Notify all Manager
                $managers = User::getUserViaRole(4);
                foreach ($managers as $manager) {
                    $manager->notify(new CaseCreateNotification($case_id, $case_code, 0));
                }

                // Notify all Credit
                $credits = User::getUserViaRole(5);
                foreach ($credits as $credit) {
                    $credit->notify(new CaseCreateNotification($case_id, $case_code, 0));
                }

                // Notify all Super Admin
                $credits = User::getUserViaRole(1);
                foreach ($credits as $credit) {
                    $credit->notify(new CaseCreateNotification($case_id, $case_code, 0));
                }

                // Notify all Admin
                $credits = User::getUserViaRole(2);
                foreach ($credits as $credit) {
                    $credit->notify(new CaseCreateNotification($case_id, $case_code, 0));
                }
            }

            //create PCR
//            if($request->input('caseCreateSubmission') == 'case_create') {
//                CaseReportRecommendation::create([
//                    'date'      => $request->get('fye_date1'),
//                    'case_id'   => $case_id,
//                ]);
//            }

            // find out redirect to
            if ($is_admin == 1) {
                DB::commit();
                $msg = '';
                //                if ($return_access == 0){ $msg = 'Draft Updated successfully.'; }
                //                elseif($return_access == 1) { $msg = 'File Uploaded succesfully.'; }
                //                elseif($return_access == 2) { $msg = 'Created Case succesfully.'; }

                if ($return_access == 0) {
                    $msg = 'Draft Updated successfully.';
                    return to_route('admin.case-lists.draft')->with('message', 'Draft Updated successfully.')->with('message', $msg);
                } elseif ($return_access == 1) {
                    $msg = 'File Uploaded successfully.';
                    return redirect()->route('admin.case-lists.create', [$caseList->id, '#documents'])->with('message', $msg);
                } else {
                    $msg = 'Created Case successfully.';
                    return to_route('admin.case-lists.index')->with('message', $msg);
                }
            } else {
                DB::commit();
                if ($return_access == 0) {
                    return to_route('admin.case-lists.draft')->with('message', 'Draft Updated successfully.');
                } elseif ($return_access == 1) {
                    return redirect()->route('admin.case-lists.create', [$caseList->id, '#documents']);
                } else {
                    return to_route('admin.case-lists.index');
                }
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect()->route('admin.case-lists.create', $caseList->id)->withErrors([$message]);
        }
    }

    public function destroy(CaseList $caseList)
    {
        abort_if(Gate::denies('draft_delete_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseList->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseListRequest $request)
    {
        CaseList::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }

    public function storeMediaWithName(StoreMediaMediaUploadingTraitRequest $request)
    {
        if (isset($request->company_name)) {
            return $this->storeMedia($request, $request->company_name);
        } else {
            return $this->storeMedia($request);
        }
    }
}

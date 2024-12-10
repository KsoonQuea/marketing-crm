<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCaseCommitmentRequest;
use App\Http\Requests\StoreCaseCommitmentRequest;
use App\Http\Requests\UpdateCaseCommitmentRequest;
use App\Models\CaseCommitment;
use App\Models\CaseList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CaseCommitmentController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('case_commitment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CaseCommitment::with(['case'])->select(sprintf('%s.*', (new CaseCommitment())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'case_commitment_show';
                $editGate = 'case_commitment_edit';
                $deleteGate = 'case_commitment_delete';
                $crudRoutePart = 'case-commitments';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->addColumn('case_case_code', function ($row) {
                return $row->case ? $row->case->case_code : '';
            });

            $table->editColumn('house_loan', function ($row) {
                return $row->house_loan ? $row->house_loan : '';
            });
            $table->editColumn('term_loan', function ($row) {
                return $row->term_loan ? $row->term_loan : '';
            });
            $table->editColumn('hire_purchase', function ($row) {
                return $row->hire_purchase ? $row->hire_purchase : '';
            });
            $table->editColumn('credit_card_limit', function ($row) {
                return $row->credit_card_limit ? $row->credit_card_limit : '';
            });
            $table->editColumn('trade_line_limit', function ($row) {
                return $row->trade_line_limit ? $row->trade_line_limit : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'case']);

            return $table->make(true);
        }

        return view('admin.caseCommitments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('case_commitment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.caseCommitments.create', compact('cases'));
    }

    public function store(StoreCaseCommitmentRequest $request)
    {
        $caseCommitment = CaseCommitment::create($request->all());

        return to_route('admin.case-commitments.index');
    }

    public function edit(CaseCommitment $caseCommitment)
    {
        abort_if(Gate::denies('case_commitment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseCommitment->load('case');

        return view('admin.caseCommitments.edit', compact('caseCommitment', 'cases'));
    }

    public function update(UpdateCaseCommitmentRequest $request, CaseCommitment $caseCommitment)
    {
        $caseCommitment->update($request->all());

        return to_route('admin.case-commitments.index');
    }

    public function show(CaseCommitment $caseCommitment)
    {
        abort_if(Gate::denies('case_commitment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCommitment->load('case');

        return view('admin.caseCommitments.show', compact('caseCommitment'));
    }

    public function destroy(CaseCommitment $caseCommitment)
    {
        abort_if(Gate::denies('case_commitment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCommitment->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseCommitmentRequest $request)
    {
        CaseCommitment::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}

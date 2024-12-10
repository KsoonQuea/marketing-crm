<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCaseDirectorCommitmentRequest;
use App\Http\Requests\StoreCaseDirectorCommitmentRequest;
use App\Http\Requests\UpdateCaseDirectorCommitmentRequest;
use App\Models\CaseDirectorCommitment;
use App\Models\CaseList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CaseDirectorCommitmentController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('case_director_commitment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CaseDirectorCommitment::with(['case'])->select(sprintf('%s.*', (new CaseDirectorCommitment())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'case_director_commitment_show';
                $editGate = 'case_director_commitment_edit';
                $deleteGate = 'case_director_commitment_delete';
                $crudRoutePart = 'case-director-commitments';

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

            $table->editColumn('director_name', function ($row) {
                return $row->director_name ? $row->director_name : '';
            });
            $table->editColumn('house_loan', function ($row) {
                return $row->house_loan ? $row->house_loan : '';
            });
            $table->editColumn('personal_loan', function ($row) {
                return $row->personal_loan ? $row->personal_loan : '';
            });
            $table->editColumn('hire_purchase', function ($row) {
                return $row->hire_purchase ? $row->hire_purchase : '';
            });
            $table->editColumn('credit_card_limit', function ($row) {
                return $row->credit_card_limit ? $row->credit_card_limit : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'case']);

            return $table->make(true);
        }

        return view('admin.caseDirectorCommitments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('case_director_commitment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.caseDirectorCommitments.create', compact('cases'));
    }

    public function store(StoreCaseDirectorCommitmentRequest $request)
    {
        $caseDirectorCommitment = CaseDirectorCommitment::create($request->all());

        return to_route('admin.case-director-commitments.index');
    }

    public function edit(CaseDirectorCommitment $caseDirectorCommitment)
    {
        abort_if(Gate::denies('case_director_commitment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseDirectorCommitment->load('case');

        return view('admin.caseDirectorCommitments.edit', compact('caseDirectorCommitment', 'cases'));
    }

    public function update(UpdateCaseDirectorCommitmentRequest $request, CaseDirectorCommitment $caseDirectorCommitment)
    {
        $caseDirectorCommitment->update($request->all());

        return to_route('admin.case-director-commitments.index');
    }

    public function show(CaseDirectorCommitment $caseDirectorCommitment)
    {
        abort_if(Gate::denies('case_director_commitment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseDirectorCommitment->load('case');

        return view('admin.caseDirectorCommitments.show', compact('caseDirectorCommitment'));
    }

    public function destroy(CaseDirectorCommitment $caseDirectorCommitment)
    {
        abort_if(Gate::denies('case_director_commitment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseDirectorCommitment->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseDirectorCommitmentRequest $request)
    {
        CaseDirectorCommitment::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}

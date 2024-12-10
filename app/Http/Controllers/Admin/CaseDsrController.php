<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCaseDsrRequest;
use App\Http\Requests\StoreCaseDsrRequest;
use App\Http\Requests\UpdateCaseDsrRequest;
use App\Models\CaseDsr;
use App\Models\CaseList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CaseDsrController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('case_dsr_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CaseDsr::with(['case'])->select(sprintf('%s.*', (new CaseDsr())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'case_dsr_show';
                $editGate = 'case_dsr_edit';
                $deleteGate = 'case_dsr_delete';
                $crudRoutePart = 'case-dsrs';

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

            $table->editColumn('ebitda', function ($row) {
                return $row->ebitda ? $row->ebitda : '';
            });
            $table->editColumn('ccris_commitment', function ($row) {
                return $row->ccris_commitment ? $row->ccris_commitment : '';
            });
            $table->editColumn('bank_statement_commitment', function ($row) {
                return $row->bank_statement_commitment ? $row->bank_statement_commitment : '';
            });
            $table->editColumn('new_financing_commitment', function ($row) {
                return $row->new_financing_commitment ? $row->new_financing_commitment : '';
            });
            $table->editColumn('dsr', function ($row) {
                return $row->dsr ? $row->dsr : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'case']);

            return $table->make(true);
        }

        return view('admin.caseDsrs.index');
    }

    public function create()
    {
        abort_if(Gate::denies('case_dsr_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.caseDsrs.create', compact('cases'));
    }

    public function store(StoreCaseDsrRequest $request)
    {
        $caseDsr = CaseDsr::create($request->all());

        return to_route('admin.case-dsrs.index');
    }

    public function edit(CaseDsr $caseDsr)
    {
        abort_if(Gate::denies('case_dsr_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseDsr->load('case');

        return view('admin.caseDsrs.edit', compact('caseDsr', 'cases'));
    }

    public function update(UpdateCaseDsrRequest $request, CaseDsr $caseDsr)
    {
        $caseDsr->update($request->all());

        return to_route('admin.case-dsrs.index');
    }

    public function show(CaseDsr $caseDsr)
    {
        abort_if(Gate::denies('case_dsr_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseDsr->load('case');

        return view('admin.caseDsrs.show', compact('caseDsr'));
    }

    public function destroy(CaseDsr $caseDsr)
    {
        abort_if(Gate::denies('case_dsr_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseDsr->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseDsrRequest $request)
    {
        CaseDsr::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}

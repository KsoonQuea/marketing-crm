<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCriterionRequest;
use App\Http\Requests\StoreCriterionRequest;
use App\Http\Requests\UpdateCriterionRequest;
use App\Models\Criterion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CriteriaController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('criterion_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Criterion::query()->select(sprintf('%s.*', (new Criterion())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'criterion_show';
                $editGate = 'criterion_edit';
                $deleteGate = 'criterion_delete';
                $crudRoutePart = 'criteria';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Criterion::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.criteria.index');
    }

    public function create()
    {
        abort_if(Gate::denies('criterion_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.criteria.create');
    }

    public function store(StoreCriterionRequest $request)
    {
        $criterion = Criterion::create($request->all());

        return to_route('admin.criteria.index');
    }

    public function edit(Criterion $criterion)
    {
        abort_if(Gate::denies('criterion_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.criteria.edit', compact('criterion'));
    }

    public function update(UpdateCriterionRequest $request, Criterion $criterion)
    {
        $criterion->update($request->all());

        return to_route('admin.criteria.index');
    }

    public function show(Criterion $criterion)
    {
        abort_if(Gate::denies('criterion_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.criteria.show', compact('criterion'));
    }

    public function destroy(Criterion $criterion)
    {
        abort_if(Gate::denies('criterion_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $criterion->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCriterionRequest $request)
    {
        Criterion::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}

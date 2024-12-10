<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\IndustryTypeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyIndustryTypeRequest;
use App\Http\Requests\StoreIndustryTypeRequest;
use App\Http\Requests\UpdateIndustryTypeRequest;
use App\Models\CaseList;
use App\Models\IndustryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class IndustryTypeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('industry_type_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = IndustryType::select();
            // search inputs
            if (isset($request->search_status) && $request->search_status != 'all') {
                $query->where('status', $request->search_status);
            }
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->where('name', 'LIKE', '%' . $search_input . '%');
            }
            $query->select(sprintf('%s.*', (new IndustryType())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name = 'industry_type';
                $permission_name = 'industry_type';
                $except = ['show'];
                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row'
                ));
            });
            $table->editColumn('status', function ($row) {
                $status = $row->status->getName();
                $class = ($status == 'Active') ? 'green' : 'muted';
                return '<b class="text-'.$class.'">'.$status.'</b>';
            });
            $table->rawColumns(['actions', 'placeholder', 'status']);
            return $table->make(true);
        }
        return view('admin.industryTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('industry_type_create_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.industryTypes.create');
    }

    public function store(StoreIndustryTypeRequest $request)
    {
        $industryType = IndustryType::create($request->all());

        return to_route('admin.industry-types.index');
    }

    public function edit(IndustryType $industryType)
    {
        abort_if(Gate::denies('industry_type_edit_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.industryTypes.edit', compact('industryType'));
    }

    public function update(UpdateIndustryTypeRequest $request, IndustryType $industryType)
    {
        $industryType->update($request->all());

        return to_route('admin.industry-types.index');
    }

    public function show(IndustryType $industryType)
    {
        abort_if(Gate::denies('industry_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.industryTypes.show', compact('industryType'));
    }

    public function destroy(IndustryType $industryType)
    {
        abort_if(Gate::denies('industry_type_delete_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $industryType->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyIndustryTypeRequest $request)
    {
        IndustryType::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}

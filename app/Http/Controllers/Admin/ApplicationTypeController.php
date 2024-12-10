<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ApplicationTypeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyApplicationTypeRequest;
use App\Http\Requests\StoreApplicationTypeRequest;
use App\Http\Requests\UpdateApplicationTypeRequest;
use App\Models\ApplicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ApplicationTypeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('application_type_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ApplicationType::select();
            // search inputs
            if (isset($request->search_status) && $request->search_status != 'all') {
                $query->where('status', $request->search_status);
            }
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->where('name', 'LIKE', '%' . $search_input . '%');
            }
            $query->select(sprintf('%s.*', (new ApplicationType())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name = 'application_type';
                $permission_name = 'application_type';
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
        return view('admin.applicationTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('application_type_create_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.applicationTypes.create');
    }

    public function store(StoreApplicationTypeRequest $request)
    {
        $applicationType = ApplicationType::create($request->all());

        return to_route('admin.application-types.index');
    }

    public function edit(ApplicationType $applicationType)
    {
        abort_if(Gate::denies('application_type_edit_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.applicationTypes.edit', compact('applicationType'));
    }

    public function update(UpdateApplicationTypeRequest $request, ApplicationType $applicationType)
    {
        $applicationType->update($request->all());

        return to_route('admin.application-types.index');
    }

    public function show(ApplicationType $applicationType)
    {
        abort_if(Gate::denies('application_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.applicationTypes.show', compact('applicationType'));
    }

    public function destroy(ApplicationType $applicationType)
    {
        abort_if(Gate::denies('application_type_delete_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $applicationType->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyApplicationTypeRequest $request)
    {
        ApplicationType::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}

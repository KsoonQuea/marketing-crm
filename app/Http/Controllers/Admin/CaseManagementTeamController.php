<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCaseManagementTeamRequest;
use App\Http\Requests\StoreCaseManagementTeamRequest;
use App\Http\Requests\UpdateCaseManagementTeamRequest;
use App\Models\CaseList;
use App\Models\CaseManagementTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CaseManagementTeamController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('case_management_team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CaseManagementTeam::with(['case'])->select(sprintf('%s.*', (new CaseManagementTeam())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'case_management_team_show';
                $editGate = 'case_management_team_edit';
                $deleteGate = 'case_management_team_delete';
                $crudRoutePart = 'case-management-teams';

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

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('age', function ($row) {
                return $row->age ? $row->age : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('designation', function ($row) {
                return $row->designation ? $row->designation : '';
            });
            $table->editColumn('shareholding', function ($row) {
                return $row->shareholding ? $row->shareholding : '';
            });
            $table->editColumn('responsible_area', function ($row) {
                return $row->responsible_area ? $row->responsible_area : '';
            });
            $table->editColumn('experience_year', function ($row) {
                return $row->experience_year ? $row->experience_year : '';
            });
            $table->editColumn('case_year', function ($row) {
                return $row->case_year ? $row->case_year : '';
            });
            $table->editColumn('director_relationship', function ($row) {
                return $row->director_relationship ? $row->director_relationship : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'case']);

            return $table->make(true);
        }

        return view('admin.caseManagementTeams.index');
    }

    public function create()
    {
        abort_if(Gate::denies('case_management_team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.caseManagementTeams.create', compact('cases'));
    }

    public function store(StoreCaseManagementTeamRequest $request)
    {
        $caseManagementTeam = CaseManagementTeam::create($request->all());

        return to_route('admin.case-management-teams.index');
    }

    public function edit(CaseManagementTeam $caseManagementTeam)
    {
        abort_if(Gate::denies('case_management_team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseManagementTeam->load('case');

        return view('admin.caseManagementTeams.edit', compact('caseManagementTeam', 'cases'));
    }

    public function update(UpdateCaseManagementTeamRequest $request, CaseManagementTeam $caseManagementTeam)
    {
        $caseManagementTeam->update($request->all());

        return to_route('admin.case-management-teams.index');
    }

    public function show(CaseManagementTeam $caseManagementTeam)
    {
        abort_if(Gate::denies('case_management_team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseManagementTeam->load('case');

        return view('admin.caseManagementTeams.show', compact('caseManagementTeam'));
    }

    public function destroy(CaseManagementTeam $caseManagementTeam)
    {
        abort_if(Gate::denies('case_management_team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseManagementTeam->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseManagementTeamRequest $request)
    {
        CaseManagementTeam::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}

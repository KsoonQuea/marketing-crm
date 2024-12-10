<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCaseLogRequest;
use App\Http\Requests\StoreCaseLogRequest;
use App\Http\Requests\UpdateCaseLogRequest;
use App\Models\CaseList;
use App\Models\CaseLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseLogController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_log_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseLogs = CaseLog::with(['user', 'case'])->get();

        return view('admin.caseLogs.index', compact('caseLogs'));
    }

    public function create()
    {
        abort_if(Gate::denies('case_log_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.caseLogs.create', compact('cases', 'users'));
    }

    public function store(StoreCaseLogRequest $request)
    {
        $caseLog = CaseLog::create($request->all());

        return to_route('admin.case-logs.index');
    }

    public function edit(CaseLog $caseLog)
    {
        abort_if(Gate::denies('case_log_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseLog->load('user', 'case');

        return view('admin.caseLogs.edit', compact('caseLog', 'cases', 'users'));
    }

    public function update(UpdateCaseLogRequest $request, CaseLog $caseLog)
    {
        $caseLog->update($request->all());

        return to_route('admin.case-logs.index');
    }

    public function show(CaseLog $caseLog)
    {
        abort_if(Gate::denies('case_log_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseLog->load('user', 'case');

        return view('admin.caseLogs.show', compact('caseLog'));
    }

    public function destroy(CaseLog $caseLog)
    {
        abort_if(Gate::denies('case_log_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseLog->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseLogRequest $request)
    {
        CaseLog::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}

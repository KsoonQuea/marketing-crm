<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCaseCallLogRequest;
use App\Http\Requests\StoreCaseCallLogRequest;
use App\Http\Requests\UpdateCaseCallLogRequest;
use App\Models\CaseCallLog;
use App\Models\CaseList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseCallLogController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_call_log_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCallLogs = CaseCallLog::with(['user', 'case'])->get();

        return view('admin.caseCallLogs.index', compact('caseCallLogs'));
    }

    public function create()
    {
        abort_if(Gate::denies('case_call_log_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.caseCallLogs.create', compact('cases', 'users'));
    }

    public function store(StoreCaseCallLogRequest $request)
    {
        $request->merge(['datetime' => now()]);
        CaseCallLog::create($request->all());
        return redirect()->route('admin.case-lists.show',[$request->case_id,'#call-logs'])->with('message','Case Log Added Successfully.');
    }

    public function edit(CaseCallLog $caseCallLog)
    {
        abort_if(Gate::denies('case_call_log_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseCallLog->load('user', 'case');

        return view('admin.caseCallLogs.edit', compact('caseCallLog', 'cases', 'users'));
    }

    public function update(UpdateCaseCallLogRequest $request, CaseCallLog $caseCallLog)
    {
        $caseCallLog->update($request->all());

        return to_route('admin.case-call-logs.index');
    }

    public function show(CaseCallLog $caseCallLog)
    {
        abort_if(Gate::denies('case_call_log_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCallLog->load('user', 'case');

        return view('admin.caseCallLogs.show', compact('caseCallLog'));
    }

    public function destroy(CaseCallLog $caseCallLog)
    {
        abort_if(Gate::denies('case_call_log_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCallLog->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseCallLogRequest $request)
    {
        CaseCallLog::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}

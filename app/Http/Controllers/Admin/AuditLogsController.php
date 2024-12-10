<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AuditLogsDataTable;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class AuditLogsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = AuditLog::select();
            $query->with(['user'])->select(sprintf('%s.*', (new AuditLog())->table))->search($request->all());
            $table = DataTables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->editColumn('user_id', function ($row) {
                return $row->user_id ? $row->user->name : '';
            });
            $table->editColumn('description', function ($row) {
                return str_replace("audit:","",$row->description);
            });
            $table->editColumn('properties', function ($row) {
                return json_encode($row->properties);
            });
            return $table->make(true);
        }
        $users = User::all();
        return view('admin.auditLogs.index', compact('users'));
    }

    public function show(AuditLog $auditLog): Factory|View
    {
        abort_if(Gate::denies('audit_log_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.auditLogs.show', compact('auditLog'));
    }
}

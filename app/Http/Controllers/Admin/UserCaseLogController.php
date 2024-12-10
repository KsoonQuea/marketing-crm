<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUserCaseLogRequest;
use App\Http\Requests\StoreUserCaseLogRequest;
use App\Http\Requests\UpdateUserCaseLogRequest;
use App\Models\CaseDisburseDetails;
use App\Models\CaseList;
use App\Models\User;
use App\Models\UserCaseLog;
use App\Notifications\CaseCreateNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use function PHPUnit\Framework\isEmpty;

class UserCaseLogController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_case_log_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UserCaseLog::with(['user', 'case'])->select(sprintf('%s.*', (new UserCaseLog())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_case_log_show';
                $editGate = 'user_case_log_edit';
                $deleteGate = 'user_case_log_delete';
                $crudRoutePart = 'user-case-logs';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('case_case_code', function ($row) {
                return $row->case ? $row->case->case_code : '';
            });

            $table->editColumn('case_stage', function ($row) {
                return $row->case_stage ? $row->case_stage : '';
            });
            $table->editColumn('action_status', function ($row) {
                return $row->action_status ? $row->action_status : '';
            });
            $table->editColumn('action_remark', function ($row) {
                return $row->action_remark ? $row->action_remark : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'case']);

            return $table->make(true);
        }

        return view('admin.userCaseLogs.index');
    }

    public function create()
    {
        abort_if(Gate::denies('user_case_log_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userCaseLogs.create', compact('cases', 'users'));
    }

    public function store(Request $request)
    {
        try {
            $teamLeader = false;
            $manager    = false;
            $credit     = false;
            $account    = false;

            if (is_null($request->get('remark')) || $request->get('remark') == ''){
                return redirect()->back()->withErrors(['Please fill in the remark field']);
            }

            $userCaseLog = UserCaseLog::create($request->all());

            /* Action
             * 1 : check
             * 2 : rework
             * 3 : resubmit
             * 5 : drop
             *
             * */

            if ($request->action == 2) {
                CaseList::find($request->case_id)->update(['case_status' => 3]);

                //send notification
                // Notify this BFE
                $bfes    = User::where('id', $request->salesman_id)->get();

                foreach ($bfes as $bfe) {
                    $bfe->notify(new CaseCreateNotification($request->case_id, $request->case_code, 3));
                }

                DB::commit();
            }
            elseif ($request->action == 3) {
                CaseList::find($request->case_id)->update(['case_status' => 0]);

                //send notification
                /*
                * 1 : Super Admin
                * 2 : Admin
                * 3 : BFE
                * 4 : Sales Manager
                * 5 : Credit
                * 6 : Account
                * */

                // Notify all Manager
                $managers = User::getUserViaRole(4);
                foreach ($managers as $manager) {
                    $manager->notify(new CaseCreateNotification($request->case_id, $request->case_code, 4));
                }

                // Notify all Credit
                $credits = User::getUserViaRole(5);
                foreach ($credits as $credit) {
                    $credit->notify(new CaseCreateNotification($request->case_id, $request->case_code, 4));
                }

                // Notify all Admin
                $credits = User::getUserViaRole(2);
                foreach ($credits as $credit) {
                    $credit->notify(new CaseCreateNotification($request->case_id, $request->case_code, 4));
                }

                // Notify all Super Admin
                $credits = User::getUserViaRole(1);
                foreach ($credits as $credit) {
                    $credit->notify(new CaseCreateNotification($request->case_id, $request->case_code, 4));
                }

                DB::commit();
            }
            else if ($request->action == 1) {
                $userCaseLogs = UserCaseLog::with(['case.salesman.teams'])->where('case_id', $request->case_id)->where('action', 1)->get();
                foreach ($userCaseLogs as $userCaseLog) {
                    switch ($userCaseLog->user_role) {
                        case 3:
                            if (isset($userCaseLog->case->salesman->teams)) {
                                foreach ($userCaseLog->case->salesman->teams as $teams) {
                                    $isTeamLeader = $teams->team_lead_id == $userCaseLog->user->id;
                                    if ($isTeamLeader) {
                                        $teamLeader = true;
                                        break;
                                    }
                                }
                            }
                            break;
                        case 4:
                            $manager = true;
                            break;
                        case 5:
                            $credit = true;
                            break;
                        case 6:
                            $account = true;
                            break;
                        default:
                            break;
                    }
                }

                if ($credit) {
                    //Change Case Status
                    CaseList::find($request->case_id)->update(['case_status' => 1]);

                } else {
                    CaseList::find($request->case_id)->update(['case_status' => 0]);
                }
            }
            else if($request->action == 5){
                // drop
                CaseList::find($request->case_id)->update(['case_status' => 5]);
                // send notification
                // Notify this BFE
                $bfes = User::where('id', $request->salesman_id)->get();

                foreach ($bfes as $bfe) {
                    $bfe->notify(new CaseCreateNotification($request->case_id, $request->case_code, 2));
                }
                DB::commit();
            }
            return redirect()->route('admin.case-lists.show',[$request->case_id])->with('message', 'Checked List Added');
        }
        catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect()->route('admin.case-lists.show',[$request->case_id])->withErrors([$message]);
        }
    }

    public function edit(UserCaseLog $userCaseLog)
    {
        abort_if(Gate::denies('user_case_log_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userCaseLog->load('user', 'case');

        return view('admin.userCaseLogs.edit', compact('cases', 'userCaseLog', 'users'));
    }

    public function update(UpdateUserCaseLogRequest $request, UserCaseLog $userCaseLog)
    {
        $userCaseLog->update($request->all());

        return to_route('admin.user-case-logs.index');
    }

    public function show(UserCaseLog $userCaseLog)
    {
        abort_if(Gate::denies('user_case_log_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userCaseLog->load('user', 'case');

        return view('admin.userCaseLogs.show', compact('userCaseLog'));
    }

    public function destroy(UserCaseLog $userCaseLog)
    {
        abort_if(Gate::denies('user_case_log_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userCaseLog->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyUserCaseLogRequest $request)
    {
        UserCaseLog::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('about_create') && Gate::denies('about_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new About();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

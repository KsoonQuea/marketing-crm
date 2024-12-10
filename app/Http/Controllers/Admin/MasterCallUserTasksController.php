<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CaseCallLog;
use App\Models\CaseDirectorCommitment;
use App\Models\CaseList;
use App\Models\Director;
use App\Models\MasterCallList;
use App\Models\MasterCallUserTask;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;


class MasterCallUserTasksController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!(Gate::denies('call_all_pending_index_2') ^ Gate::denies('call_personal_pending_index_2')), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $my_id = auth()->user()->id;
            $query = MasterCallUserTask::with(['batch','list'])->where('user_id',$my_id)->where('master_call_user_tasks.status',0);
            // search inputs
            if(isset($request->search_input)){
                $search_input = $request->search_input;
                $query->whereHas('list', function ($query_list) use ($search_input){
                    $query_list->where('name','LIKE','%'.$search_input.'%');
                    $query_list->orWhere('phone','LIKE','%'.$search_input.'%');
                    $query_list->orWhere('company_name','LIKE','%'.$search_input.'%');
                    $query_list->orWhere('revenue','LIKE','%'.$search_input.'%');
                });
            }
            $query->select(sprintf('%s.*', (new MasterCallUserTask())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                if (!Gate::denies('call_remark_2') == true){
                    return '<a href="javascript:void(0);" class="btn btn-primary btn-xs btn-checked ms-2" title="Actions" onclick="Update('.$row->response_status.','.$row->id.');"><i class="fa fa-edit"></i></a>';
                }
                else{
                    return '';
                }
            });
            $table->editColumn('batch.description', function ($row) {
                return $row->batch ? $row->batch->description : '';
            });
            $table->editColumn('status', function ($row) {
                $status_name = MasterCallUserTask::STATUS_SELECT[$row->status];
                return $status_name;
            });
            $table->rawColumns(['actions','placeholder','status','batch.description']);
            return $table->make(true);
        }
        return view('admin.salesmanCalls.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(MasterCallUserTask $masterCallUserTask)
    {
        //
    }

    public function edit(MasterCallUserTask $masterCallUserTask)
    {
        //
    }

    public function update(Request $request, MasterCallUserTask $masterCallUserTask)
    {
        //
    }

    public function destroy(MasterCallUserTask $masterCallUserTask)
    {
        //
    }

    public function caseLogHistory(Request $request)
    {
        $task_id = $request->id;
        $MasterCallUserTask = MasterCallUserTask::find($task_id);
        $phone = $MasterCallUserTask->list->phone;
        $list = $MasterCallUserTask->list;
        if($phone){
            $tbody_data = CaseCallLog::with('user')->where('phone',$phone)->get();
            if($tbody_data && count($tbody_data) > 0){
                $status_code = 0;
            } else {
                $status_code = 1;
            }
        } else {
            $status_code = 2;
        }
        return [
            'status_code' => $status_code,
            'tbody_data' => $tbody_data ?? [],
            'list' => $list ?? [],
        ];
    }

    public function allCall(Request $request)
    {
        abort_if(!(Gate::denies('call_all_all_index_2')^Gate::denies('call_personal_all_index_2')), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $my_id = auth()->user()->id;
            $query = MasterCallUserTask::with(['batch','list'])->where('user_id',$my_id);
            // search inputs
            if(isset($request->search_input)){
                $search_input = $request->search_input;
                $query->orWhereHas('list', function ($query_list) use ($search_input){
                    $query_list->where('name','LIKE','%'.$search_input.'%');
                    $query_list->orWhere('phone','LIKE','%'.$search_input.'%');
                    $query_list->orWhere('company_name','LIKE','%'.$search_input.'%');
                    $query_list->orWhere('revenue','LIKE','%'.$search_input.'%');
                });
            }
            if(isset($request->search_status) && $request->search_status != 'all'){
                $query->where('status',$request->search_status);
            }
            if(isset($request->search_response_status) && $request->search_response_status != 'all'){
                $query->where('response_status',$request->search_response_status);
            }
            $query->select(sprintf('%s.*', (new MasterCallUserTask())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                if (! Gate::denies('call_remark_2') == true){
                    $action = '<a href="#" class="btn btn-primary btn-xs btn-checked ms-2" title="Actions" onclick="Update('.$row->response_status.','.$row->id.');"><i class="fa fa-edit"></i></a>';
                }
                else{
                    $action = '';
                }

                $hit = 0;

                if($row->list){
                    $hit = CaseList::where('company_name','LIKE',$row->list->company_name)->count() ?? 0;
                }
                if($row->status == 1 && $hit <= 0){
                    if (! Gate::denies('call_convert_case_2') == true){
                        $action .= '<a href="javascript:void(0);" class="btn btn-secondary btn-xs ms-2" onclick="addCase('.$row->id.');">Add Case</a>';
                    }
                }
                return $action;
            });
            $table->editColumn('batch.description', function ($row) {
                return $row->batch ? $row->batch->description : '';
            });
            $table->editColumn('status', function ($row) {
                $status_name = MasterCallUserTask::STATUS_SELECT[$row->status];
                return '<b class="text-' . (($row->status == 0) ? 'muted' : 'info') . '">' . $status_name . '</b>';
            });
            $table->editColumn('response_status', function ($row) {
                $status_name = MasterCallUserTask::RESPONSE_STATUS_SELECT[$row->response_status];
                $status_class = MasterCallUserTask::RESPONSE_STATUS_CLASSES[$row->response_status];
                if($row->response_status == 5){
                     return '<span class="special-option">Do Not Call List</span>';
                } else {
                    return '<b class="text-'.$status_class.'">'.$status_name.'</b>';
                }
            });
            $table->rawColumns(['actions','placeholder','status','batch.description','response_status']);
            return $table->make(true);
        }
        return view('admin.salesmanCalls.all-call');
    }

    public function calledPhone(Request $request)
    {
        // abort_if(Gate::denies('salesman_calls_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try{
            $id = $request->id;
            $response_status = $request->response_status;
            $MasterCallUserTask = MasterCallUserTask::find($id);
            $user_id = $MasterCallUserTask->user_id;
            $list = $MasterCallUserTask->list;
            $phone = $list->phone;
            $list_id = $list->id;
            $list->update(['status'=>2]); // go to "Called"
            $MasterCallUserTask->update(['status'=>1,'response_status'=>$response_status]); // go to "Called"
            CaseCallLog::create([
                'details' => $request->details,
                'phone' => $phone,
                'datetime' => date("Y-m-d H:i:s"),
                'user_id' => $user_id,
                'case_id' => NULL,
                'master_call_list_id' => $list_id,
                'response_status' => $response_status,
            ]);
            $message = 'Update Successfully.';
        } catch (\Exception $e){
            $message = $e->getMessage();
        }
        return back()->with('message',$message);
    }

    public function addCase(Request $request){
        $status_code = 1; $message = ''; $case_id = NULL;
        $id = $request->id;
        DB::beginTransaction();
        try{
            $MasterCallUserTask = MasterCallUserTask::find($id);
            $list = $MasterCallUserTask->list;
            $name_field = str_replace(['/',',',', '],",",$list->name);
            $director_name_array = explode(',',$name_field);
            $ic_field = str_replace(['/',',',', '],",",$list->name);
            $director_ic_array = explode(',',$ic_field);
            // $phone_field = str_replace(['/',',',', '],",",$list->name);
            // $director_phone_array = explode(',',$phone_field);

            // create case
            $case_latest_num = CaseList::select('id')->count() + 1;
            $case_code = 'C'.sprintf('%05d', $case_latest_num);
            $caseList = CaseList::create([
                'case_code' => $case_code,
                'salesman_id' => Auth::user()->id,
                'company_name' => $list->company_name,
                'business_activity' => $list->company_description,
                'address' => $list->company_address,
            ]);
            // create director
            foreach($director_name_array as $key => $director_name){
                $new_director = Director::create([
                    'name' => $director_name,
                    'ic' => $director_ic_array[$key],
                ]);
                CaseDirectorCommitment::create([
                    'case_id' => $caseList->id,
                    'director_id' => $new_director->id,
                    'director_name' => $director_name,
                    'director_ic' => $director_ic_array[$key],
                    'group_id' => $key,
                ]);
            }
            $status_code = 0;
            $case_id = $caseList->id;
            DB::commit();
        } catch (\Exception $e){
            $message = 'Error. '.$e->getMessage();
            DB::rollback();
        }
        return [
            'status_code' => $status_code,
            'message' => $message,
            'case_id' => $case_id,
        ];
    }
}

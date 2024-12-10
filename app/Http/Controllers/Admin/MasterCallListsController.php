<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RemarkHistoryExport;

use App\Http\Controllers\AssignPhoneToUserController;
use App\Http\Controllers\Controller;
use App\Models\CaseCallLog;
use App\Models\MasterCallList;
use App\Models\MasterCallUserTask;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Traits\ParseCsvImportCsvImportTraitRequest;
use App\Models\MasterCallBatch;
use Illuminate\Support\Str;
use SpreadsheetReader;

class MasterCallListsController extends Controller
{

    public function index(Request $request)
    {
        abort_if(Gate::denies('call_master_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MasterCallList::with(['batch']);
            // search inputs
            if(isset($request->search_status) && $request->search_status != 'all'){
                $query->where('status',$request->search_status);
            }
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->whereHas('batch', function ($query_batch) use ($search_input) {
                    $query_batch->where('description', 'LIKE', '%' . $search_input . '%');
                });
                $query->orWhere('name', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('ic', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('phone', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('company_name', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('company_address', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('company_description', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('revenue', 'LIKE', '%' . $search_input . '%');
            }
            if ($request->date_from !== null && $request->date_to !== null) {
                $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
            }else{
                if ($request->date_from !== null) {
                    $query->where('created_at', '>=', $request->date_from);
                }
                if ($request->date_to !== null) {
                    $query->where('created_at', '<=', $request->date_to);
                }
            }
            // queries
            $query->select(sprintf('%s.*', (new MasterCallList())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                if (!Gate::denies('call_master_delete_2') == true){
                    return '<a class="btn btn-danger btn-xs" href="#"><i class="fa fa-trash"></i></a>';
                }
                else{
                    return '';
                }
            });
            $table->editColumn('batch.description', function ($row) {
                return $row->batch ? $row->batch->description : '';
            });
            $table->editColumn('name', function ($row) {
                $name = str_replace(['/',',',', '],", ",$row->name);
                $ic = str_replace(['/',',',', '],", ",$row->ic);
                $phone = str_replace(['/',',',', '],", ",$row->phone);
                $info = '<span class="text-danger">Name:</span> '.$name.'<br>'
                .'<span class="text-danger">IC:</span> '.$ic.'<br>'
                .'<span class="text-danger">Phone:</span> '.str_replace("/",", ",$phone);
                return '<div class="">'.$info.'</div>';
            });
            $table->editColumn('status', function ($row) {
                $status_name = MasterCallList::STATUS_SELECT[$row->status];
                $status_class = MasterCallList::STATUS_CLASSES[$row->status];
                return '<b class="text-'.$status_class.'">'.$status_name.'</b>';
            });
            $table->rawColumns(['actions', 'placeholder', 'status', 'batch.description','name']);
            return $table->make(true);
        }
        $users = User::getUserViaRole(3);
        return view('admin.masterCallLists.index',compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('call_master_excel_create_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.masterCallLists.create');
    }

    public function store(ParseCsvImportCsvImportTraitRequest $request)
    {
        $request->merge(['model' => 'MasterCallList']);
        $request->input('description') != "" ? $description = $request->input('description') : $description = 'Batch ' . Str::random(6);

        $batch = MasterCallBatch::create([
            'description' => $description,
        ]);
        $request->merge(['master_call_batch_id' => $batch->id]);
        $this->parseCsvImport($request);
        return redirect()->route('admin.master-call-lists.index')->with('message', 'Add Master Call List Successfully.');
    }

    public function show(MasterCallList $masterCallList)
    {
        //
    }

    public function edit(MasterCallList $masterCallList)
    {
        //
    }

    public function update(Request $request, MasterCallList $masterCallList)
    {
        //
    }

    public function destroy(MasterCallList $masterCallList)
    {
        //
    }

    public function parseCsvImport($request)
    {
        $file = $request->file('csv_file');
        $path = $file->path();

        $reader = new SpreadsheetReader($path);
        $headers = $reader->current();

        $i = 0;
        while ($reader->next() !== false && $i < 100) {
            foreach ($reader->current() as $key => $value) {
                $column_title = str_replace(" ", "_",strtolower(trim($headers[$key])));
                $field = str_replace(array("\r\n", "\n\r", "\n", "\r"), ',', $value);
                if($column_title != ''){
                    switch($column_title){
                        case 'address':$column_title = 'company_address';break;
                        case 'business_activities':$column_title = 'company_description';break;
                        case 'director_name':$column_title = 'name';break;
                        case 'director_ic':$column_title = 'ic';break;
                        case 'phone_number':$column_title = 'phone';break;
                    }
                    // $value = strtoupper(trim($value));
                    $field = str_replace(['/',',',', '],", ",$field);
                    $data[$column_title] = $field;
                }
            }
            $data['master_call_batch_id'] = $request->input('master_call_batch_id');
            $lines2[] = $data;
            $i++;
        }


        $for_insert = array_chunk($lines2, 100);

        foreach ($lines2 as $insert_item) {

            // dd($insert_item);

                // MasterCallList::upsert(
                //     array_values($insert_item),
                //     ['company_name', 'company_address', 'company_description', 'revenue', 'name', 'ic', 'phone', 'master_call_batch_id']
                // );

            MasterCallList::create($insert_item);


        }
    }

    public function seperatePhone(Request $request)
    {

        try{
            $amount = $request->amount;
            $users_id = $request->input('users_id');
            $assignController = new AssignPhoneToUserController();
            $message = $assignController->assignPhone($users_id,$amount);
        } catch(\Exception $e){
            $message = $e->getMessage();
        }
        return back()->with('message',$message);
    }

    public function remarkHistory(Request $request)
    {
        abort_if(Gate::denies('call_remark_history_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = CaseCallLog::with(['user','case']);
            // global search
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->whereHas('user', function ($query_batch) use ($search_input) {
                    $query_batch->where('name', 'LIKE', '%' . $search_input . '%');
                });
                $query->orWhereHas('case', function ($query_batch) use ($search_input) {
                    $query_batch->where('case_code', 'LIKE', '%' . $search_input . '%');
                });
                $query->orWhere('datetime', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('details', 'LIKE', '%' . $search_input . '%');
                $query->orWhere('phone', 'LIKE', '%' . $search_input . '%');
            }
            // date range
            if ($request->date_from !== null) {
                $query->whereDate('datetime', '>=', $request->date_from);
            }
            if ($request->date_to !== null) {
                $query->whereDate('datetime', '<=', $request->date_to);
            }

            $query->select(sprintf('%s.*', (new CaseCallLog())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('details', function ($row) {
                return $row->details ?? '-';
            });
            $table->editColumn('case.case_code', function ($row) {
                return $row->case?->case_code;
            });
            $table->editColumn('list.company_name', function ($row) {
                return $row->list?->company_name;
            });
            $table->editColumn('list.company_name', function ($row) {
                return $row->list?->company_name;
            });
            $table->editColumn('response_status', function ($row) {
                $status_name = MasterCallUserTask::RESPONSE_STATUS_SELECT[$row->response_status];
                $status_class = MasterCallUserTask::RESPONSE_STATUS_CLASSES[$row->response_status];
                return '<b class="text-'.$status_class.'">'.$status_name.'</b>';
            });

            $table->rawColumns(['actions', 'placeholder', 'details','response_status']);
            return $table->make(true);
        }
        return view('admin.masterCallLists.remark-history');
    }

    public function exportCallRemarkHistory(Request $request)
    {
        return (new RemarkHistoryExport($request))->download('remark-history.xlsx');
//        return back()->with('message','Export successfully.');
    }
}

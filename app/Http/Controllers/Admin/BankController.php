<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BankDataTable;
use App\Enum\Status;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBankRequest;
use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;
use App\Models\Bank;
use App\Models\BankOfficer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BankController extends Controller
{
    use CsvImportTrait;

//    public function index(BankDataTable $dataTable, Request $request)
//    {
//        abort_if(Gate::denies('bank_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//
//        return $dataTable->render('admin.banks.index');
//    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('platform_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Bank::with(['officers']);
            // search inputs
            if (isset($request->search_status) && $request->search_status != 'all') {
                $query->where('status', $request->search_status);
            }
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->where('name', 'LIKE', '%' . $search_input . '%');
            }
            $query->select(sprintf('%s.*', (new Bank())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name = 'bank';
                $permission_name = 'platform';
                $except = ['show'];
                $active = $row->status == Status::Active ? true : false;
                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row',
                    'active'
                ));
            });
            $table->editColumn('status', function ($row) {
                $status = $row->status->getName();
                $class = ($status == 'Active') ? 'green' : 'muted';
                return '<b class="text-'.$class.'">'.$status.'</b>';
            });
            $table->editColumn('officers.name', function ($row){
                $officers = [];
                foreach($row->officers as $row){
                    $display = $row->name. ' - <b class="text-primary">'.$row->commission.'%</b>';
                    array_push($officers,$display);
                }
                return implode(", ",$officers);
            });
            $table->rawColumns(['actions', 'placeholder', 'status', 'officers.name']);
            return $table->make(true);
        }
        return view('admin.banks.index');
    }


    public function create()
    {
        abort_if(Gate::denies('platform_create_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.banks.create');
    }

    public function store(StoreBankRequest $request)
    {
        $bank = Bank::create($request->all());
        if($request->input('officer_name') !== null){
            foreach($request->input('officer_name') as $name){
                BankOfficer::create([
                    'name' => $name,
                    'bank_id' => $bank->id,
                ]);
            }
        }
        return to_route('admin.banks.index');
    }

    public function edit(Bank $bank)
    {
        abort_if(Gate::denies('platform_edit_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.banks.edit', compact('bank'));
    }

    public function update(UpdateBankRequest $request, Bank $bank)
    {
        $bank->update($request->all());
        $bank->officers()->delete(); // remove
        if($request->input('officer_name') !== null){
            $commissions = $request->input('commission');
            foreach($request->input('officer_name') as $key => $name){
                BankOfficer::create([
                    'name' => $name,
                    'bank_id' => $bank->id,
                    'commission' => $commissions[$key],
                ]);
            }
        }
        return to_route('admin.banks.index');
    }

    public function show(Bank $bank)
    {
        abort_if(Gate::denies('bank_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.banks.show', compact('bank'));
    }

    // public function destroy(Bank $bank)
    // {
    //     abort_if(Gate::denies('bank_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $bank->delete();

    //     return redirect()->back();
    // }

    // public function massDestroy(MassDestroyBankRequest $request)
    // {
    //     Bank::whereIn('id', request('ids'))->delete();

    //     return response()->noContent(Response::HTTP_NO_CONTENT);
    // }

    public function remove(Bank $bank)
    {
        abort_if(Gate::denies('platform_inactive_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $bank->update([
            'status' => Status::Inactive,
        ]);

        return redirect()->back();
    }

    public function restore(bank $bank)
    {
        abort_if(Gate::denies('platform_active_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $bank->update([
            'status' => Status::Active,
        ]);

        return redirect()->back();
    }
}

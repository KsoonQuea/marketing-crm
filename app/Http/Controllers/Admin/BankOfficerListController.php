<?php

namespace App\Http\Controllers\Admin;
use App\Models\Bank;
use App\Http\Controllers\Controller;
use App\Models\BankOfficer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BankOfficerListController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('bank_officer_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BankOfficer::with(['bank']);
            // search inputs
            if(isset($request->search_status) && $request->search_status != 'all'){
                $query->where('status',$request->search_status);
            }
            if(isset($request->search_input)){
                $search_input = $request->search_input;
                $query->where('created_at','LIKE','%'.$search_input.'%');
                $query->orWhere('name','LIKE','%'.$search_input.'%');
                $query->orWhere('ic','LIKE','%'.$search_input.'%');
                $query->orWhereHas('bank', function ($query_bank) use ($search_input){
                    $query_bank->where('name','LIKE','%'.$search_input.'%');
                });
            }
            $query->select(sprintf('%s.*', (new BankOfficer())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name               = 'bank_officer';
                $permission_name    = 'bank_officer';
                $except             = [''];
//                $active             = $row->status->value !== 0;

//                if ($row->hasRole('Admin')) {
//                    $except = ['show', 'remove', 'destroy'];
//                }
//
//                if ($active){
//                    $except = ['destroy'];
//                }

                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row',
//                    'active'
                ));
            });
            $table->editColumn('bank.name', function ($row){
                return $row->bank->name ?? "";
            });
//            $table->editColumn('status', function ($row) {
//                $status_name = $row->status->getName();
//                $status_class = ($status_name == 'Active') ? 'green' : 'muted';
//                return '<b class="text-'.$status_class.'">'.$status_name.'</b>';
//            });
            $table->rawColumns(['actions','placeholder','bank.name']);
            return $table->make(true);
        }

        return view('admin.bankOfficer.index');
    }

    public function create()
    {
        abort_if(Gate::denies('bank_officer_create_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $banks = Bank::pluck('name', 'id');
        return view('admin.bankOfficer.create', compact('banks'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'ic' => 'required',
            'banks' => 'required',
            'bank_account' => 'required',
            'commission' => 'required'
        ]);

        $bankOfficer = BankOfficer::create([
            'name' => $request->name,
            'ic' => $request->ic,
            'bank_id' => $request->banks,
            'bank_account' => $request->bank_account,
            'commission' => $request->commission
        ]);

        return redirect()->route('admin.bank-officers.index')->with('message','Created successfully.');
    }


    public function edit(BankOfficer $bank_officer)
    {
        abort_if(Gate::denies('bank_officer_edit_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $banks = Bank::pluck('name', 'id');
        return view('admin.bankOfficer.edit', compact('banks','bank_officer'));
    }

    public function  update(Request $request,BankOfficer $bankOfficer){
        $validatedData = $request->validate([
            'name' => 'required',
            'ic' => 'required',
            'banks' => 'required',
            'bank_account' => 'required',
            'commission' => 'required'
        ]);

        $bankOfficer = $bankOfficer->update([
            'name' => $request->name,
            'ic' => $request->ic,
            'bank_id' => $request->banks,
            'bank_account' => $request->bank_account,
            'commission' => $request->commission
        ]);

        return redirect()->route('admin.bank-officers.index')->with('message','Updated successfully.');
    }

    public function show()
    {
        abort_if(Gate::denies('bank_officer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.bankOfficer.show');
    }

    public function destroy(BankOfficer $bank_officer)
    {
        abort_if(Gate::denies('bank_officer_delete_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bank_officer->delete();

        return redirect()->back();
    }
}

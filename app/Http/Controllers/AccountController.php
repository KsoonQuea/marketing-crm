<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Pdf\AccountController as AccountModule;
use App\Models\Invoice;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    private function reformatToNumeric($input)
    {
        $nagtive = 0;
        if (strpos($input, '(') !== false) {
            $nagtive = 1;
        }
        $new_input = floatval(preg_replace('/[^\d.]/', '', $input));
        $new_value = number_format($new_input, 2, '.', '');
        if($nagtive == 1){ $return = -$new_value; } else { $return = $new_value; }
        return $return;
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('reimbursement_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = Invoice::where('disbursement_type', 1);
//            $query->where('disbursement_type',1);
            $query->select(sprintf('%s.*', (new Invoice())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $edit_url = route('admin.accounts.edit',$row->id);
                $pdf_url = route('admin.accounts.export-pdf',$row->id);

                $action = '';

                if (!Gate::denies('reimbursement_edit_2') ){
                    $action .= '<a href="'.$edit_url.'" class="btn btn-info" style="margin:3px;"><i class="fa fa-edit"></i></a>';
                }

                if (!Gate::denies('reimbursement_print_2')){
                    $action .= '<a href="'.$pdf_url.'" class="btn btn-primary"><i class="fa fa-print"></i></a>';
                }

                return $action;
            });
            $table->rawColumns(['actions', 'placeholder']);
            return $table->make(true);
        }
        return view('admin.accounts.index');
    }

    public function create()
    {
        $year = date("Y");$month = date('n');
        $invoice_front = 'IV-'.substr($year, -2);
        // auto_generate
        $last_invoice       = Invoice::where('year',$year)->orderBy('running_number','desc')->first();
        $running_number     = ($last_invoice->running_number ?? 0)+1;
        $invoice_middle     = sprintf('%04d', $running_number);
        // reuse
        $last_invoice2      = Invoice::onlyTrashed()->where('year',$year)->orderBy('running_number','desc')->first();
        $running_number2    = $last_invoice2->running_number ?? 1;
        $invoice_middle2    = sprintf('%04d', $running_number2);
        $invoice_no         = $invoice_front.$invoice_middle;
        $invoice_no2        = $invoice_front.$invoice_middle2;

        $auto_generate = [
            'inv_no'        => $invoice_no,
            'running_no'    => $running_number,
        ];

        $preview_type = 0;
        return view('admin.accounts.create',compact('preview_type','auto_generate'));
    }

    public function store(Request $request)
    {
        if($request->input('submission') == '1'){
            // print pdf
            $account = new AccountModule();
            return $account->generatePDF($request->all());
        } else {
            // store invoice
            try{
                $company_address_1 = $request->get('company_address_1');
                $company_address_2 = $request->get('company_address_2');
                $company_address_3 = $request->get('company_address_3');

                $service_fees = $request->get('service_fee');
                $service_fees = $this->reformatToNumeric($service_fees);
                $company_address = $company_address_1.$company_address_2.$company_address_3;

                $request->merge([
                    'service_fee' => $service_fees,
                    'company_address' => $company_address,
                ]);;

                $invoice = Invoice::create($request->all());
                $year   = $request->date != null ? date("Y",strtotime($request->date)) : date('Y');
                $month  = $request->date != null ? date("n",strtotime($request->date)) : date('m');
                if($request->selection == '1'){
                    $file_num = $request->auto_generate_inv_no;
                    $running_number = $request->auto_generate_running_no;
                } else {
                    $file_num = $request->re_use_inv_no;
                    $running_number = NULL;
                }
                $invoice->update([
                    'file_num'          => $file_num,
                    'running_number'    => $running_number,
                    'disbursement_type' => 1,
                    'year'              => $year,
                    'month'             => $month,
                ]);
                DB::commit();
                return redirect()->route('admin.accounts.index')->with('message','Create Invoice Successfully.');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['Create Invoice Failed.'.$e->getMessage()]);
            }
        }
    }

    public function edit($id)
    {
        $invoice = Invoice::find($id);
        $preview_type = 2;
        $service_fee = $invoice->service_fee;
        if($invoice->sst_status == 1){
            $sst_amount = $service_fee*0.06;
        } else{
            $sst_amount = 0;
        }
        $total_amount = $service_fee+$sst_amount;
        $other_data = [
            'service_fee' => $service_fee,
            'number_word' => strtoupper(convertNumberToWord($total_amount)),
            'sst_amount' => $sst_amount,
            'total_amount' => $total_amount,
        ];
        return view('admin.accounts.edit',compact('invoice','preview_type','other_data'));
    }

    public function update(Request $request, $id)
    {
        if($request->input('submission') == '1'){
            // print pdf
            $account = new AccountModule();
            return $account->generatePDF($request->all());
        } else {
            // update invoice
            try{
                $company_address_1 = $request->get('company_address_1');
                $company_address_2 = $request->get('company_address_2');
                $company_address_3 = $request->get('company_address_3');

                $company_address = $company_address_1.$company_address_2.$company_address_3;
                $service_fees = $request->get('service_fee');
                $service_fees = $this->reformatToNumeric($service_fees);

                $request->merge([
                    'service_fee' => $service_fees,
                    'company_address' => $company_address,
                ]);

                $invoice = Invoice::find($id);
                $invoice->update($request->all());
                $year   = $request->date != null ? date("Y",strtotime($request->date)) : date('Y');
                $month  = $request->date != null ? date("n",strtotime($request->date)) : date('m');
                $invoice->update([
                    'disbursement_type' => 1,
                    'year' => $year,
                    'month' => $month,
                ]);
                DB::commit();
                return redirect()->route('admin.accounts.index')->with('message','Update Invoice Successfully.');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['Create Invoice Failed.'.$e->getMessage()]);
            }
        }
    }

    public function exportPdfFromIndex($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        $data = [
            'service_fee' => $invoice->service_fee,
            'sst_status' => $invoice->sst_status,
            'selection' => 3,
            'file_num' => $invoice->file_num,
            'company_name' => $invoice->company_name,
            'company_address' => $invoice->company_address,
            'company_address_1' => $invoice->company_address_1,
            'company_address_2' => $invoice->company_address_2,
            'company_address_3' => $invoice->company_address_3,
            'date' => $invoice->date,
            'contact_person' => $invoice->contact_person,
            'contact_phone' => $invoice->contact_phone,
            'description' => $invoice->description,
        ];
        // print pdf
        $account = new AccountModule();
        return $account->generatePDF($data);
    }
}

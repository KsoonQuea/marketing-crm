<?php

namespace App\Http\Controllers;
use App\Models\commissionSettingDetails;
use App\Models\commissionSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CommissionSettingsController extends Controller
{
    public function index(Request $request)
    {
        //abort_if(Gate::denies('commission_settings_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $parent_query   = commissionSettings::all();
        $mix_query      = commissionSettingDetails::with(['commission_settings'])->get();
        if ($request->ajax()) {
            $query = commissionSettingDetails::with(['commission_settings']);

            // search inputs
            if (isset($request->search_status) && $request->search_status != 'all') {
                $query->where('status', $request->search_status);
            }
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->where('name', 'LIKE', '%' . $search_input . '%');
            }
            $query->select(sprintf('%s.*', (new commissionSettingDetails())->table));

//            dd($query);

            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name = 'commission_settings';
                $permission_name = 'commission_settings';
                $except = ['show'];
                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row'
                ));
            });

            $table->editColumn('commission_settings.class', function ($row) {
                $item = $row->commission_settings->class;

                return $item;
            });
            $table->editColumn('monthly_target', function ($row) {
                $item = $row->commission_settings->monthly_target;

                return $item;
            });
            $table->editColumn('rate', function ($row) {
                $item = $row->rate;

                return $item;
            });

            $table->setRowData([
                'range' => 'row-{{$range}}',
                'range_fee' => 'row-{{$range_fee}}',
            ]);

            $table->rawColumns(['actions', 'placeholder', 'commission_settings.class', 'monthly_target', 'rate']);
            return $table->make(true);
        }
        return view('admin.commissionSettings.index', compact('parent_query', 'mix_query'));
    }

    public function create()
    {
        //abort_if(Gate::denies('commission_settings_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.commissionSettings.create');
    }

    public function store(Request $request)
    {
        $setting = commissionSettings::create([
            'class' => $request->class,
            'monthly_target' => $request->monthly_target,
            'quarterly_target' => $request->quarterly_target,
        ]);
        foreach($request->input('range') as $key => $range){
            commissionSettingDetails::create([
                'rate'=> $request->input('rate')[$key],
                'range' => $range,
                'range_fee' => $request->input('range_fee')[$key],
                'commission_settings_id' => $setting->id,
            ]);
        }
        return redirect()->route('admin.commission_settings.index')->with('message','Add Commission successfully.');
    }

    public function edit($id)
    {
        //abort_if(Gate::denies('commission_settings_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $commissionSettings = commissionSettings::find($id);
        return view('admin.commissionSettings.edit', compact('commissionSettings'));
    }

    public function update($commissionSettingsId, Request $request)
    {
        commissionSettings::find($commissionSettingsId)->update([
            'class' => $request->class,
            'monthly_target' => $request->monthly_target,
            'quarterly_target' => $request->quarterly_target,
        ]);
        commissionSettingDetails::where('commission_settings_id',$commissionSettingsId)->delete(); // remove existing data
        foreach($request->input('range') as $key => $range){
            commissionSettingDetails::create([
                'rate'=> $request->input('rate')[$key],
                'range' => $range,
                'range_fee' => $request->input('range_fee')[$key],
                'commission_settings_id' => $commissionSettingsId,
            ]);
        }
        return redirect()->route('admin.commission_settings.index')->with('message','Edit Commission successfully.');
    }

    public function show($id)
    {
        //abort_if(Gate::denies('commission_settings_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $commissionSettings = commissionSettings::find($id);
        return view('admin.commissionSettings.edit', compact('commissionSettings'));
    }

    public function destroy(commissionSettings $commissionSettings)
    {
        //abort_if(Gate::denies('commission_settings_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $commissionSettings->delete();
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DirectorDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDirectorRequest;
use App\Http\Requests\StoreDirectorRequest;
use App\Http\Requests\UpdateDirectorRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Director;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DirectorController extends Controller
{
    use CsvImportTrait;

//    public function index(DirectorDataTable $dataTable, Request $request)
//    {
//        abort_if(Gate::denies('director_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//
//
//        return $dataTable->render('admin.directors.index');
//    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('director_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = Director::query();
            // search inputs
            if(isset($request->search_input)){
                $search_input = $request->search_input;
                $query->where('created_at','LIKE','%'.$search_input.'%');
                $query->orWhere('name','LIKE','%'.$search_input.'%');
                $query->orWhere('ic','LIKE','%'.$search_input.'%');
                $query->orWhere('phone','LIKE','%'.$search_input.'%');
            }
            $query->select(sprintf('%s.*', (new Director())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name = 'director';
                $permission_name = 'director';
                $except = [''];
                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row'
                ));
            });
            $table->editColumn('name', function ($row){
                return $row->name ? $row->name : '-';
            });
            $table->editColumn('ic', function ($row){
                return $row->ic ? $row->ic : '-';
            });
            $table->editColumn('phone', function ($row){
                return $row->phone ? $row->phone : '-';
            });
            $table->rawColumns(['actions','placeholder']);
            return $table->make(true);
        }
        return view('admin.directors.index');
    }

    public function create()
    {
        abort_if(Gate::denies('director_create_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $states = State::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.directors.create', compact('cities', 'countries', 'states'));
    }

    public function store(StoreDirectorRequest $request)
    {
        $request_data = $request->except('city','state','country');
        $request_data['city_id'] = $request->city;
        $request_data['state_id'] = $request->state;
        $request_data['country_id'] = $request->country;

        $director = Director::create($request_data);

        return to_route('admin.directors.index')->with('message','Create Director Successfully.');
    }

    public function edit(Director $director)
    {
        abort_if(Gate::denies('director_edit_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $states = State::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $director->load('city', 'state', 'country');

        return view('admin.directors.edit', compact('cities', 'countries', 'director', 'states'));
    }

    public function update(UpdateDirectorRequest $request, Director $director)
    {
        $request_data = $request->except('city','state','country');
        $request_data['city_id'] = $request->city;
        $request_data['state_id'] = $request->state;
        $request_data['country_id'] = $request->country;

        $director->update($request_data);

        return to_route('admin.directors.index')->with('message','Edit Director Successfully.');
    }

    public function show(Director $director)
    {
        abort_if(Gate::denies('director_view_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $director->load('city', 'state', 'country');

        return view('admin.directors.show', compact('director'));
    }

    public function destroy(Director $director)
    {
        abort_if(Gate::denies('director_delete_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $director->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyDirectorRequest $request)
    {
        Director::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}

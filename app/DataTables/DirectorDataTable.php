<?php

namespace App\DataTables;

use App\Models\CaseList;
use App\Models\Director;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DirectorDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->orderColumns(['name', 'ic'], '-:column $1')
            ->addColumn('action', function ($row) {
                $name = 'director';
                $except = [''];

                return view('partials.datatablesActions', compact(
                    'name',
                    'except',
                    'row'
                ));
            });
    }

    public function query(Director $model, Request $request): \Illuminate\Database\Eloquent\Builder
    {
        return $model->select($model->getTable() . '.*')->search($request->all());
    }

    public function html(): Builder
    {
//        dd(3);
        return $this->builder()
            ->setTableId('DirectorTable')
            ->columns($this->getColumns())
            ->parameters([
                'language' => dataTableLang(),
            ])
            ->responsive([
                'details' => [
                    'display' => '$.fn.dataTable.Responsive.display.childRowImmediate',
                    'type' => '',
                ],
            ])
            ->ajax([
                'url' => url()->current(),
                'type' => 'GET',
                'data' => "function (d) { d.name = $('#name').val(); d.ic = $('#ic').val(); },",
            ])
            ->dom('Brtip');
    }

    protected function getColumns(): array
    {
//        dd(4);
        return [
            Column::make('name')
                ->content('-'),
            Column::make('ic')
                ->content('-'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}

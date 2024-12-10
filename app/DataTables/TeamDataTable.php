<?php

namespace App\DataTables;

use App\Models\Team;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TeamDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->orderColumns(['name'], '-:column $1')
            ->addColumn('action', function ($row) {
                $name = 'team';
                $except = ['show'];

                return view('partials.datatablesActions', compact(
                    'name',
                    'except',
                    'row'
                ));
            });
    }

    public function query(Team $model, Request $request): \Illuminate\Database\Eloquent\Builder
    {
        return $model->search($request->all())->select($model->getTable().'.*');
    }

    public function html(): Builder
    {
        return $this->builder()
            ->setTableId('TeamDataTable')
            ->columns($this->getColumns())
            ->parameters([
                'language' => dataTableLang(),
            ])
            ->ajax([
                'url' => url()->current(),
                'type' => 'GET',
                'data' => "function (d) { d.name = $('#uname').val();},",
            ])
            ->responsive([
                'details' => [
                    'display' => '$.fn.dataTable.Responsive.display.childRowImmediate',
                    'type' => '',
                ],
            ])
            ->dom('Brtip');
    }

    protected function getColumns(): array
    {
        return [
            Column::make('name')
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
        return 'Team_'.date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\CaseCreditCheckType;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CaseCreditCheckTypeDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->orderColumns(['name'], '-:column $1')
            ->editColumn('status', fn ($row) => $row->status?->getName())
            ->addColumn('action', function ($row) {
                $name = 'case_credit_check_type'; // name is same as permission
                $except = [];

                return view('partials.datatablesActions', compact(
                    'name',
                    'except',
                    'row'
                ));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CaseCreditCheckType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CaseCreditCheckType $model,Request $request): QueryBuilder
    {
        return $model->select($model->getTable() . '.*')->search($request->all());
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('casecreditchecktype-table')
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
                        'data' => "function (d) { d.name = $('#uname').val(); d.status = $('#ustatus').val(); },",
                    ])
                    ->dom('Brtip');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::make('name'),
            Column::make('status')
                ->content('-'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'CaseCreditCheckType_' . date('YmdHis');
    }
}
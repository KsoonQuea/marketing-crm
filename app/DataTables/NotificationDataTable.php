<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NotificationDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->orderColumns(['name', 'status'], '-:column $1')
            ->editColumn('role', fn($row) => $row?->roles?->first()->name ?? '-')
            ->editColumn('status', fn ($row) => $row->status?->getName())
            ->addColumn('action', function ($row) {
                $name = 'user';
                $except = [''];
                if ($row?->name === 'Super Admin') {
                    $except = ['show', 'remove', 'destroy'];
                }

                return view('partials.datatablesActions', compact(
                    'name',
                    'except',
                    'row'
                ));
            });
    }

    public function query(User $model, Request $request): \Illuminate\Database\Eloquent\Builder
    {
        dd($model->notifications()->get());
        return $model->notifications()->get();
    }

    public function html(): Builder
    {
        return $this->builder()
            ->setTableId('UserTable')
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
                'data' => "function (d) { d.name = $('#uname').val();  d.email = $('#uemail').val(); d.status = $('#ustatus').val(); },",
            ])
            ->dom('Brtip');
    }

    protected function getColumns(): array
    {
        return [
            Column::make('name')
                ->content('-'),
            Column::make('email')
                ->content('-'),
            Column::make('unreadNotifications')
                ->content('-')
                ->orderable(false),
            Column::make('status')
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

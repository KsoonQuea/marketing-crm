@extends('layouts.admin')
@section('content')
@can('bank_statement_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.bank-statements.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.bankStatement.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'BankStatement', 'route' => 'admin.bank-statements.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.bankStatement.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-BankStatement">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.bankStatement.fields.bank') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankStatement.fields.case') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankStatement.fields.bank_owner') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankStatement.fields.bank_account') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankStatement.fields.credit') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankStatement.fields.debit') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankStatement.fields.month_end_balance') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('bank_statement_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.bank-statements.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.bank-statements.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'bank_name', name: 'bank.name' },
{ data: 'case_case_code', name: 'case.case_code' },
{ data: 'bank_owner', name: 'bank_owner' },
{ data: 'bank_account', name: 'bank_account' },
{ data: 'credit', name: 'credit' },
{ data: 'debit', name: 'debit' },
{ data: 'month_end_balance', name: 'month_end_balance' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-BankStatement').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection
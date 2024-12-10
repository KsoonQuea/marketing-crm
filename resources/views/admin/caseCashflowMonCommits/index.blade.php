@extends('layouts.admin')
@section('content')
@can('case_cashflow_mon_commit_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.case-cashflow-mon-commits.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.caseCashflowMonCommit.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'CaseCashflowMonCommit', 'route' => 'admin.case-cashflow-mon-commits.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.caseCashflowMonCommit.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-CaseCashflowMonCommit">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.caseCashflowMonCommit.fields.case') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseCashflowMonCommit.fields.avg_mon_end_bank_balances') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseCashflowMonCommit.fields.avg_mon_credit_transactions') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseCashflowMonCommit.fields.mon_commitment') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseCashflowMonCommit.fields.tot_mon_commitment_for_directors') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseCashflowMonCommit.fields.tot_mon_commitment_of_directors_and_company') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseCashflowMonCommit.fields.annualized_revenue') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseCashflowMonCommit.fields.income_factor') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseCashflowMonCommit.fields.dsr') }}
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
@can('case_cashflow_mon_commit_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.case-cashflow-mon-commits.massDestroy') }}",
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
    ajax: "{{ route('admin.case-cashflow-mon-commits.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'case_case_code', name: 'case.case_code' },
{ data: 'avg_mon_end_bank_balances', name: 'avg_mon_end_bank_balances' },
{ data: 'avg_mon_credit_transactions', name: 'avg_mon_credit_transactions' },
{ data: 'mon_commitment', name: 'mon_commitment' },
{ data: 'tot_mon_commitment_for_directors', name: 'tot_mon_commitment_for_directors' },
{ data: 'tot_mon_commitment_of_directors_and_company', name: 'tot_mon_commitment_of_directors_and_company' },
{ data: 'annualized_revenue', name: 'annualized_revenue' },
{ data: 'income_factor', name: 'income_factor' },
{ data: 'dsr', name: 'dsr' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-CaseCashflowMonCommit').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection
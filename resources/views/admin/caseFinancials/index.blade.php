@extends('layouts.admin')
@section('content')
@can('case_financial_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.case-financials.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.caseFinancial.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'CaseFinancial', 'route' => 'admin.case-financials.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.caseFinancial.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-CaseFinancial">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.current_asset') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.non_current_asset') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.director_asset') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.related_customer_asset') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.customer_asset') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.current_liabilities') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.non_current_liabilities') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.director_liabilities') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.related_customer_liabilities') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.customer_liabilities') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.loan_n_hp') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.share_capital') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.revenue') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.sales_cost') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.finance_cost') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.depreciation') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.profit') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.tax') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseFinancial.fields.financial_date') }}
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
@can('case_financial_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.case-financials.massDestroy') }}",
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
    ajax: "{{ route('admin.case-financials.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'current_asset', name: 'current_asset' },
{ data: 'non_current_asset', name: 'non_current_asset' },
{ data: 'director_asset', name: 'director_asset' },
{ data: 'related_customer_asset', name: 'related_customer_asset' },
{ data: 'customer_asset', name: 'customer_asset' },
{ data: 'current_liabilities', name: 'current_liabilities' },
{ data: 'non_current_liabilities', name: 'non_current_liabilities' },
{ data: 'director_liabilities', name: 'director_liabilities' },
{ data: 'related_customer_liabilities', name: 'related_customer_liabilities' },
{ data: 'customer_liabilities', name: 'customer_liabilities' },
{ data: 'loan_n_hp', name: 'loan_n_hp' },
{ data: 'share_capital', name: 'share_capital' },
{ data: 'revenue', name: 'revenue' },
{ data: 'sales_cost', name: 'sales_cost' },
{ data: 'finance_cost', name: 'finance_cost' },
{ data: 'depreciation', name: 'depreciation' },
{ data: 'profit', name: 'profit' },
{ data: 'tax', name: 'tax' },
{ data: 'financial_date', name: 'financial_date' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-CaseFinancial').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection
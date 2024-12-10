@extends('layouts.admin')
@section('content')
@can('case_director_commitment_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.case-director-commitments.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.caseDirectorCommitment.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'CaseDirectorCommitment', 'route' => 'admin.case-director-commitments.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.caseDirectorCommitment.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-CaseDirectorCommitment">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.caseDirectorCommitment.fields.case') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseDirectorCommitment.fields.director_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseDirectorCommitment.fields.house_loan') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseDirectorCommitment.fields.personal_loan') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseDirectorCommitment.fields.hire_purchase') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseDirectorCommitment.fields.credit_card_limit') }}
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
@can('case_director_commitment_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.case-director-commitments.massDestroy') }}",
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
    ajax: "{{ route('admin.case-director-commitments.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'case_case_code', name: 'case.case_code' },
{ data: 'director_name', name: 'director_name' },
{ data: 'house_loan', name: 'house_loan' },
{ data: 'personal_loan', name: 'personal_loan' },
{ data: 'hire_purchase', name: 'hire_purchase' },
{ data: 'credit_card_limit', name: 'credit_card_limit' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-CaseDirectorCommitment').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection
@extends('layouts.admin')
@section('content')
@can('case_management_team_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.case-management-teams.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.caseManagementTeam.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'CaseManagementTeam', 'route' => 'admin.case-management-teams.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.caseManagementTeam.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-CaseManagementTeam">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.caseManagementTeam.fields.case') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseManagementTeam.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseManagementTeam.fields.age') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseManagementTeam.fields.phone') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseManagementTeam.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseManagementTeam.fields.designation') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseManagementTeam.fields.shareholding') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseManagementTeam.fields.responsible_area') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseManagementTeam.fields.experience_year') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseManagementTeam.fields.case_year') }}
                    </th>
                    <th>
                        {{ trans('cruds.caseManagementTeam.fields.director_relationship') }}
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
@can('case_management_team_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.case-management-teams.massDestroy') }}",
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
    ajax: "{{ route('admin.case-management-teams.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'case_case_code', name: 'case.case_code' },
{ data: 'name', name: 'name' },
{ data: 'age', name: 'age' },
{ data: 'phone', name: 'phone' },
{ data: 'email', name: 'email' },
{ data: 'designation', name: 'designation' },
{ data: 'shareholding', name: 'shareholding' },
{ data: 'responsible_area', name: 'responsible_area' },
{ data: 'experience_year', name: 'experience_year' },
{ data: 'case_year', name: 'case_year' },
{ data: 'director_relationship', name: 'director_relationship' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-CaseManagementTeam').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection
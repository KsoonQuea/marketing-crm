@extends('layouts.admin')
@section('content')
@can('case_log_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.case-logs.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.caseLog.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.caseLog.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-CaseLog">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.caseLog.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.caseLog.fields.case') }}
                        </th>
                        <th>
                            {{ trans('cruds.caseLog.fields.details') }}
                        </th>
                        <th>
                            {{ trans('cruds.caseLog.fields.datetime') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($caseLogs as $key => $caseLog)
                        <tr data-entry-id="{{ $caseLog->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $caseLog->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $caseLog->case->case_code ?? '' }}
                            </td>
                            <td>
                                {{ $caseLog->details ?? '' }}
                            </td>
                            <td>
                                {{ $caseLog->datetime ?? '' }}
                            </td>
                            <td>
                                @can('case_log_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.case-logs.show', $caseLog->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('case_log_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.case-logs.edit', $caseLog->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('case_log_delete')
                                    <form action="{{ route('admin.case-logs.destroy', $caseLog->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        @method('DELETE')
                                        @csrf
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('case_log_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.case-logs.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-CaseLog:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
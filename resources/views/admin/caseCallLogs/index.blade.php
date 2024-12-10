@extends('layouts.admin')
@section('content')
@can('case_call_log_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.case-call-logs.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.caseCallLog.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.caseCallLog.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-CaseCallLog">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.caseCallLog.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.caseCallLog.fields.case') }}
                        </th>
                        <th>
                            {{ trans('cruds.caseCallLog.fields.details') }}
                        </th>
                        <th>
                            {{ trans('cruds.caseCallLog.fields.datetime') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($caseCallLogs as $key => $caseCallLog)
                        <tr data-entry-id="{{ $caseCallLog->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $caseCallLog->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $caseCallLog->case->case_code ?? '' }}
                            </td>
                            <td>
                                {{ $caseCallLog->details ?? '' }}
                            </td>
                            <td>
                                {{ $caseCallLog->datetime ?? '' }}
                            </td>
                            <td>
                                @can('case_call_log_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.case-call-logs.show', $caseCallLog->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('case_call_log_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.case-call-logs.edit', $caseCallLog->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('case_call_log_delete')
                                    <form action="{{ route('admin.case-call-logs.destroy', $caseCallLog->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('case_call_log_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.case-call-logs.massDestroy') }}",
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
  let table = $('.datatable-CaseCallLog:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
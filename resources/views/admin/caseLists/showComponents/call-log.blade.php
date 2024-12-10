@php $permission_call_log = $permissions['call_log']; @endphp
<h5 class="tab-pane-header">Call Logs</h5>
<div class="mt-2 float-right">
    @if($permission_call_log['create'] == 1)
    <button class="btn btn-primary btn-sm call-logs-create">
        <i class="fa fa-pencil"></i> &nbsp; Create Lead Centre
    </button>
    @endif
</div>
<div class="table-responsive">
    <table class="table-bordered w-100 addable-form-table">
        <tbody>
            <tr>
                <th>No.</th>
                <th>Details</th>
                <th>DateTime</th>
                <th>User</th>
            </tr>
            @forelse ($caseList->case_logs as $case_log)
                <tr>
                    <td>{{ $case_log->id }} </td>
                    <td>{!! $case_log->details !!}</td>
                    <td>{{ $case_log->datetime }}</td>
                    <td>{{ $case_log->user->name }}</td>
                </tr>
            @empty
            <tr>
                <td colspan="8">No Result Found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<!-- modal -->
<div id="callLogsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-inside-title">Case Lead Centre Create</h4>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.case-call-logs.store') }}">
                @csrf
                <div class="form-group">
                    <label for="call-log-remark">Details</label>
                    <textarea class="form-control" name="details" id="call-log-remark"></textarea>
                </div>
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="case_id" value="{{ $caseList->id }}">
                <div class="button-container">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="#" class="cancel btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // text-editor
        CKEDITOR.replace('call-log-remark', {
            toolbar:[
                { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
                { name: 'styles', items: [ 'Format', 'FontSize' ] },
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
            ],
        });
        // modal
    $('.call-logs-create').click(function() {
        $('#callLogsModal').show();
    });
    $('.cancel').click(function() {
        $(this).parent().parent().parent().parent().parent().hide();
    });
    window.onclick = function(event) {
        if(event.target.getAttribute('id') == 'memo-modal'){
            $('#called-modal').hide();
        }
    }
    </script>
@endpush


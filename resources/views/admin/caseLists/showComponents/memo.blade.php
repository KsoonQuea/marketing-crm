@php $permission_memo = $permissions['memo']; @endphp
<h5 class="tab-pane-header">Memo</h5> &nbsp;
<div class="mt-2 float-right">
    @if($permission_memo['create'] == 1)
    <button class="btn btn-primary btn-sm memo-create">
        <i class="fa fa-pencil"></i> &nbsp; Create Memo
    </button>
    @endif
</div>
<div class="table-responsive">
    <table class="table-bordered w-100 addable-form-table">
        <tbody>
            <tr>
                <th width="200">Date</th>
                <th width="250">Name of Editor or Position</th>
                <th>Remarks</th>
            </tr>
            @if (isset($caseList->memos) && count($caseList->memos) > 0)
            @foreach ($caseList->memos as $rowMemo)
            <tr>
                <td>{{ $rowMemo->created_at ?? '' }}</td>
                <td>{{ $rowMemo->user_name ?? '' }}
                    ({{ $rowMemo->position ?? '' }})
                </td>
                <td>{!! $rowMemo->remark ?? '' !!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="3">No Result Found.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- modal -->
<div id="memo-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-inside-title">Create Memo</h4>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.case-lists.storeMemo') }}">
                @csrf
                <div class="form-group">
                    <label for="memo-remark">Remarks</label>
                    <textarea class="form-control" name="remark" id="memo-remark"></textarea>
                </div>
                <input type="hidden" name="case_id" value="{{ $caseList->id }}" />
                <div class="button-container">
                    <button type="submit" class="btn btn-primary" id="action-submit-btn">Submit</button>
                    <a href="#" class="cancel btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // text-editor
    CKEDITOR.replace('memo-remark', {
        toolbar:[
            { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
            { name: 'styles', items: [ 'Format', 'FontSize' ] },
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat' ] },
            { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
        ],
    });
    // modal
    $('.memo-create').click(function() {
        $('#memo-modal').show();
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

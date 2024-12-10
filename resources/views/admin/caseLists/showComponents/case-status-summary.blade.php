@php $permission_css = $permissions['case_status_summary']; @endphp
@php $permission_memo = $permissions['memo']; @endphp

<style>
    .bg-disabled{
        background-color: #EBEBE4;
    }
</style>

<!-- Case Status Summary -->
<form method="post" action="{{ route('admin.case-lists.caseStatusUpdate') }}" id="css-form">
    @csrf
    <h5 class="tab-pane-header float-left">Case Status Summary</h5>
    @if($caseType_num != 2 && $caseType_num != 3)
    @can('case_summary_edit_2')
        <button type="submit" class="btn btn-primary btn-sm mt-2 float-right {{ $caseType_class }}"><i class="fa fa-edit me-2"></i>Save</button>
    @endcan
    @endif
    <div class="table-responsive">
        <input type="hidden" id="count-case-row" value="{{ count($case_bank_status) ?? 0 }}" />
        <input type="hidden" name="case_list_id" value="{{ $caseList->id }}" />
            <table class="table-bordered form-table-two" id="case-status-tbody">
            <tbody>
                <tr class="border-b-gray" style="font-size:0.9em; width: 100%">
                    <th style="width: 20%">Platform</th>
                    <th style="width: 10%">Offer</th>
                    <th style="width: 10%">Agreement</th>
                    <th style="width: 10%">Site Visit</th>
                    <th style="width: 10%">Case Submission</th>
                    <th style="line-height: 1.2em; width: 10%;">Result<br>
                        <span style="font-size:0.7em;">(<span class="text-light-success">Approved</span>/
                            <span class="text-light-danger">Decline</span>)</span>
                    </th>
                    <th style="width: 10%">Acceptance</th>
                    <th style="width: 10%">Disbursement</th>
                    <th style="width: 5%">Action</th>
                </tr>
                @php
                    $row_num = count($case_bank_status);
                @endphp

            @if (isset($case_bank_status) && count($case_bank_status) > 0)
                @foreach ($case_bank_status as $key => $rowCaseBankStatus)
                    @php $disabled_var = false; @endphp
                    <tr class="border-b-gray">
                        <td style="width: 20%;">
                            <div class="row">
                                <div class="col-6"><span class="text-primary">Platform : </span></div>
                                <div class="col-6">
                                    <select name="old_bank[{{ $key }}]" data-key="{{ $key }}" class="input-border-b bank-select-old {{ $caseType_class }}">
                                        @foreach ($Bank as $rowBank)
                                            <option value="{{ $rowBank->id }}"
                                                {{ $rowBank->id == $rowCaseBankStatus['bank_id'] ? 'selected' : '' }}>
                                                {{ $rowBank->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6"><span class="text-muted">Officer :</span></div>
                                <div class="col-6">
                                    <select name="old_officer[{{ $key }}]" class="input-border-b {{ $caseType_class }}" id="old-officer-select-{{$key}}">
                                        @if(isset($rowCaseBankStatus['bank_officers']) && count($rowCaseBankStatus['bank_officers'])>0)
                                            @foreach($rowCaseBankStatus['bank_officers'] as $old_officer_list)
                                                <option value="{{ $old_officer_list->id }}" {{ $rowCaseBankStatus['bank_officer_id'] == $old_officer_list->id ? 'selected' : '' }}>
                                                    {{ $old_officer_list->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </td>

                        @foreach ($rowCaseBankStatus['dates'] as $key_2 => $rowCBSDate)
                            @php
                               $class = '';
                               if($key_2 == 4){
                                   if($rowCBSDate['amount'] > 0 && $rowCBSDate['date']!= ''){
                                       $class = 'bg-light-success text-white';
                                       $disabled_var = false;
                                   } else if($rowCBSDate['amount'] == 0 && $rowCBSDate['date'] != '') {
                                       $class = 'bg-light-danger text-white';
                                       $disabled_var = true;
                                   }
                                }

                            $check_1st_td = '';
                            @endphp
                            @if($key_2 == 1 && $key == 0)
                                <td style="width: 10%;" rowspan="{{ $row_num }}" id="first_td"
                                    class="{{ $class }} {{ ($key_2 == $caseBankList[$key]->current_status || $rowCBSDate['date'] == null) ? ($disabled_var ? 'bg-disabled' : '') : 'bg-disabled' }} bank_status_td p-0 m-0 pb-1">
                                    <input type="date" name="old_bank_date[{{ $key }}][{{ $key_2 }}]"
                                           class="input-border-b p-0 m-0 {{ $class }} {{ $caseType_class }} {{ $key_2 == $caseBankList[$key]->current_status || $rowCBSDate['date'] == null ? ($disabled_var ? 'bg-disabled' : '') : 'bg-disabled' }}"
                                           value="{{ $rowCBSDate["date"] }}" {{ ($key_2 == $caseBankList[$key]->current_status || $rowCBSDate['date'] == null) ? ($disabled_var ? 'readonly' : '') : 'readonly' }}/>
                                </td>

                                @php $check_1st_td = 'first_td_tag'; @endphp

                            @elseif($key_2 == 0)
                                <td style="width: 10%;" class="{{ $class }} {{ ($key_2 == $caseBankList[$key]->current_status) ? ($disabled_var ? 'bg-disabled' : '') : 'bg-disabled' }} pb-1 p-0 m-0">
                                    <input type="date" name="old_bank_date[{{ $key }}][{{ $key_2 }}]"
                                           class="input-border-b p-0 m-0 {{ $class }} {{ $caseType_class }} {{ ($key_2 == $caseBankList[$key]->current_status ) ? ($disabled_var ? 'bg-disabled' : '') : 'bg-disabled' }}"
                                           value="{{ $rowCBSDate['date'] }}" {{ ($key_2 == $caseBankList[$key]->current_status ) ? ($disabled_var ? 'readonly' : '') : 'readonly' }}/>
                                    <input type="text" name="old_amount[{{ $key }}][{{ $key_2 }}]"
                                           class="number-input input-border-b p-0 m-0 {{ ($key_2 == $caseBankList[$key]->current_status ) ? ($disabled_var ? 'bg-disabled' : '') : 'bg-disabled' }} {{ $class }} {{ $caseType_class }}"
                                           value="{{ number_format($rowCBSDate['amount']) }}" min="0" {{ ($key_2 == $caseBankList[$key]->current_status ) ? ($disabled_var ? 'readonly' : '') : 'readonly' }}/>
                                </td>
                            @elseif($key_2 != 1 && $case_bank_status[0]['dates'][1]["date"] == null)
                                <td style="width: 10%;" class="{{ $class }} {{ ($key_2 == $caseBankList[$key]->current_status && $rowCaseBankStatus['dates'][1]["date"] != null ) ? ($disabled_var ? 'bg-disabled' : '') : 'bg-disabled' }} pb-1 p-0 m-0">
                                    <input type="date" name="old_bank_date[{{ $key }}][{{ $key_2 }}]"
                                           class="input-border-b p-0 m-0 {{ $class }} {{ $caseType_class }} {{ ($key_2 == $caseBankList[$key]->current_status && $rowCaseBankStatus['dates'][1]["date"] != null ) ? ($disabled_var ? 'bg-disabled' : '') : 'bg-disabled' }}"
                                           value="{{ $rowCBSDate['date'] }}" {{ ($key_2 == $caseBankList[$key]->current_status && $rowCaseBankStatus['dates'][1]["date"] != null ) ? ($disabled_var ? 'readonly' : '') : 'readonly' }}/>
                                    <input type="text" name="old_amount[{{ $key }}][{{ $key_2 }}]"
                                           class="number-input input-border-b p-0 m-0 {{ ($key_2 == $caseBankList[$key]->current_status && $rowCaseBankStatus['dates'][1]["date"] != null ) ? ($disabled_var ? 'bg-disabled' : '') : 'bg-disabled' }} {{ $class }} {{ $caseType_class }}"
                                           value="{{ number_format($rowCBSDate['amount']) }}" min="0" {{ ($key_2 == $caseBankList[$key]->current_status && $rowCaseBankStatus['dates'][1]["date"] != null ) ? ($disabled_var ? 'readonly' : '') : 'readonly' }}/>
                                </td>
                            @elseif($key_2 != 1)
                                <td style="width: 10%;" class="{{ $class }} {{ ($key_2 == $caseBankList[$key]->current_status ) ? ($disabled_var ? 'bg-disabled' : '') : 'bg-disabled' }} pb-1 p-0 m-0">
                                    <input type="date" name="old_bank_date[{{ $key }}][{{ $key_2 }}]"
                                           class="input-border-b p-0 m-0 {{ $class }} {{ $caseType_class }} {{ ($key_2 == $caseBankList[$key]->current_status ) ? ($disabled_var ? 'bg-disabled' : '') : 'bg-disabled' }}"
                                           value="{{ $rowCBSDate['date'] }}" {{ ($key_2 == $caseBankList[$key]->current_status ) ? ($disabled_var ? 'readonly' : '') : 'readonly' }}/>
                                    <input type="text" name="old_amount[{{ $key }}][{{ $key_2 }}]"
                                           class="number-input input-border-b p-0 m-0 {{ ($key_2 == $caseBankList[$key]->current_status ) ? ($disabled_var ? 'bg-disabled' : '') : 'bg-disabled' }} {{ $class }} {{ $caseType_class }}"
                                           value="{{ number_format($rowCBSDate['amount']) }}" min="0" {{ ($key_2 == $caseBankList[$key]->current_status ) ? ($disabled_var ? 'readonly' : '') : 'readonly' }}/>
                                </td>
                            @endif
                        @endforeach
                        <td class="text-center" style="width: 5%;">

                            <div id="{{ $check_1st_td }}"></div>

                            <a href="javascript:void(0)" class=" {{ ($caseType_num != 2 && $caseType_num != 3) ? 'rmv_smy_row' : '' }}">
                                <input type="hidden" value="{{ $key }}"><i class="fa fa-times tw-border-solid tw-border-2 tw-bg-red-500 tw-rounded tw-text-white px-2 py-1"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr id="platform-no-result-tr">
                    <td colspan=9">No Result Found.</td>
                </tr>
            @endif
            </tbody>

                @if($caseType_num != 2 && $caseType_num != 3)
                    @can('case_summary_edit_2')
                        <tfoot>
                        <tr>
                            <td colspan="9" class="text-center py-1">
                                <button type="button" class="btn btn-light btn-xs {{ $caseType_class }}" id="add-case-row-button">
                                    <i class="fa fa-plus me-2"></i>Add New Bank & Dates
                                </button>
                            </td>
                        </tr>
                        </tfoot>
                    @endcan
                @endif
        </table>
    </div>
</form>

<!-- memo -->
<div class="memo-div mt-4">
    <h5 class="tab-pane-header">Memo</h5> &nbsp;
    <div class="mt-2 float-right">
        @if($caseType_num != 2 && $caseType_num != 3)
            @can("case_memo_edit_2")
                <button class="btn btn-primary btn-sm memo-create {{ $caseType_class }}" id="memo-create">
                    <i class="fa fa-pencil"></i> &nbsp; Create Memo
                </button>
            @endcan
        @endif
    </div>
    <div class="table-responsive">
        <table class="table-bordered form-table-two w-100" id="memo-table">
            <thead class="sm-thead">
                <tr>
                    <th width="150">Date</th>
                    <th width="250">Name of Editor or Position</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
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

<!-- Acknowledgement -->
<div class="acknowledgement mt-4">
    <h5 class="tab-pane-header float-left">Acknowledgement</h5>
    <div class="table-responsive">
        <table class="table-bordered form-table-two w-100" id="acknowledge-table">
            <thead class="sm-thead">
                <tr>
                    <th>No</th>
                    <th>Action</th>
                    <th>Remark</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            @php
                $count = 0;
            @endphp
            @forelse ($caseList->user_case_logs as $user_case_log)
                @php
                    $count++;
                @endphp
                <tr>
                    <td>{{ $count }}</td>
                    <td>{{ App\Models\UserCaseLog::STATUS_SELECT[$user_case_log->action] }}</td>
                    <td>{!! $user_case_log->remark !!}</td>
                    <td>{{ $user_case_log->user->name }}</td>
                    <td>{{ $user_case_log->roles->name }}</td>
                    <td>{{ $user_case_log->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No Result Found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script>
    //global value
    let summary_num = 1;
    let row_num = {{ $row_num }};

    function removeSummaryFunc(){
        $(".rmv_smy_row").click(function (){
            if ($(this).children('input').val() == 0){
                $(this).parent().parent().find('*').not('#first_td').empty();
            }
            else {
                $(this).parent().parent().empty();
            }

            if ($(".rmv_smy_row").length == 0) {
                $('#first_td').parent().empty();
                summary_num = 1;
                row_num = 0;
            }
        });
    }

    removeSummaryFunc();

    // ------- Case Status Summary -------
    // add new summary
    $('#add-case-row-button').click(function(e) {
        $('#platform-no-result-tr').hide();
        var count = $('#count-case-row').val();
        count = Number(count) + 1;
        $('#count-case-row').val(count);
        var options = '<option value="" disabled selected>&nbsp;</option>';
        @foreach ($Bank as $key => $rowBank)
            var default_bank_id = '{{ ($key==0)?$rowBank->id:0 }}';
            options += '<option value="{{ $rowBank->id }}">{{ $rowBank->name }}</option>';
        @endforeach

        var new_summary_num = summary_num + {{ $key }};
        var bank_status_body = '';

        @foreach ($bankStatus as $rowbankStatus_key => $rowbankStatus)

            @if($rowbankStatus_key == 1)
            if (summary_num == 1 && row_num == 0){
            bank_status_body +=
                '<td class="p-0 m-0 pb-1 bank_status_td {{ $rowbankStatus_key == 0 ? '' : 'bg-disabled' }}" id = "first_td" >' +
                '<input type="date" name="new_bank_date[' + count +'][]" class="input-border-b {{ $caseType_class }} {{ $rowbankStatus_key == 0 ? '' : 'bg-disabled' }}" value="{{ $agreement_date }}" {{ $rowbankStatus_key == 0 ? '' : 'readonly' }}/>' +
                '</td>';
            }
            @elseif($rowbankStatus_key != 1)
            bank_status_body +=
                '<td class="p-0 m-0 pb-1 {{ $rowbankStatus_key == 0 ? '' : 'bg-disabled' }} bank_status_td">' +
                '<input type="date" name="new_bank_date[' + count +'][]" class="input-border-b {{ $caseType_class }} {{ $rowbankStatus_key == 0 ? '' : 'bg-disabled' }}" value="" {{ $rowbankStatus_key == 0 ? '' : 'readonly' }}/>' +
                '<input type="text" name="new_amount[' + count +'][]" class="number-input input-border-b {{ $caseType_class }} {{ $rowbankStatus_key == 0 ? '' : 'bg-disabled' }}" value="0" min="0" {{ $rowbankStatus_key == 0 ? '' : 'readonly' }}/>' +
                '</td>';
            @endif

        @endforeach

        var newTbody = '<tr class="border-b-gray">' +
                '<td>' +
                    '<div class="row">'+
                        '<div class="col-6"><span class="text-primary">Platform : </span></div>'+
                        '<div class="col-6">'+
                            '<select name="new_bank[' + count + ']" data-key="' + count + '" class="input-border-b bank-select-new">' + options + '</select>' +
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-6"><span class="text-muted">Officer : </span></div>'+
                        '<div class="col-6">'+
                            '<select name="new_officer[' + count + ']" class="input-border-b" id="new-officer-select-' + count + '">'+'</select>'+
                        '</div>'+
                    '</div>'+
                '</td>' + bank_status_body +
                '<td class="text-center"><a href="javascript:void(0)" class="{{ ($caseType_num != 2 && $caseType_num != 3) ? 'rmv_smy_row' : '' }}" ><input type="hidden" value="'+ row_num +'"><i class="fa fa-times tw-border-solid tw-border-2 tw-bg-red-500 tw-rounded tw-text-white px-2 py-1"></i></a></td>' +
            '</tr>';

                summary_num++;

        $('#case-status-tbody').append(newTbody);

        $("#first_td").attr('rowspan', ++row_num);

        // var bank_status_td_block = false;
        //
        // $('.bank_status_td').each(function (key, item){
        //     if (!bank_status_td_block){
        //         $(this).attr('rowspan', ++row_num);
        //         bank_status_td_block == true;
        //     }
        // });

        // default for new
        findBankOfficerNew(default_bank_id,count);
        $('.number-input').on('input', function (e){
            var value = $(this).val();
            $(this).val(addCommas(value));
        });

        removeSummaryFunc();
    });

    // old summary
    function findBankOfficerOld(id,key){
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            type: "POST",
            url: "{{ route('admin.case-lists.findBankOfficers') }}",
            data: { id: id, },
            success: function (data) {
                var options = '';
                $.each(data.bank_officers,function( index, value ) {
                    options += '<option value="'+value.id+'">'+value.name+'</option>';
                });
                $('#old-officer-select-'+key).html(options);
            }
        });
    }
    // new summary
    function findBankOfficerNew(id,key){
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            type: "POST",
            url: "{{ route('admin.case-lists.findBankOfficers') }}",
            data: { id: id, },
            success: function (data) {
                var options = '';
                $.each(data.bank_officers,function( index, value ) {
                    options += '<option value="'+value.id+'">'+value.name+'</option>';
                });
                $('#new-officer-select-'+key).html(options);
            }
        });
    }

    // actions trigger
    $('.bank-select-old').on('change', function (e){
        var id = $(this).val();
        var key = $(this).data('key');
        findBankOfficerOld(id,key);
    });
    $(document).on('change','.bank-select-new', function(){
        var id = $(this).val();
        var key = $(this).data('key');
        findBankOfficerNew(id,key);
    });
    $(function (e) {
        @if($caseType_class != 'management_class')
        $("#css-form input, #css-form select, #css-form textarea").each(function(){
            var input = $(this);
            $(this).parent().find('td:not(.td-label)').addClass("disable-div"); // disabled class to parent td
            input.prop('disabled',true);
            $('.add-row-btn').hide();
        });
        @endif
{{--        @if (isset($case_bank_status) && count($case_bank_status) > 0)--}}
{{--            @foreach ($case_bank_status as $key => $rowCaseBankStatus)--}}
{{--                var id = '{{ $rowCaseBankStatus['bank_id'] }}';--}}
{{--                var key = '{{ $key }}';--}}
{{--                findBankOfficerOld(id,key);--}}
{{--            @endforeach--}}
{{--        @endif--}}
    });
</script>
<script>
    // ------- Memo -------
    // table
{{--    @if (isset($caseList->memos) && count($caseList->memos) > 0)--}}
{{--    $('#memo-table').dataTable({--}}
{{--        searching: false,--}}
{{--        lengthChange: false,--}}
{{--        pageLength: 10,--}}
{{--    });--}}
{{--    @endif--}}

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
    $('#memo-create').click(function() {
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
<script>
// ------- Acknowledgement -------
$('#acknowledge-table').dataTable({
    searching: false,
    lengthChange: false,
    pageLength: 10,
});
</script>
@endpush

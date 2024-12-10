<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>All Call</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">All Call</li>
        <x-slot:breadcrumb_action></x-slot:breadcrumb_action>
    </x-admin.breadcrumb>
    <div class="card">
        <div class="card-body p-2">
            <div class="search-div">
                <form onsubmit="return false;">
                    <div class="row">
                        <div class="col-12 col-md-3 pe-0">
                            <input type="text" id="search_input" class="form-control form-control-sm" placeholder="Search field here...">
                        </div>
                        <div class="col-12 col-md-3 pe-0">
                            <select class="form-control form-control-sm" id="search_status">
                                <option value="all">All Status</option>
                                @foreach(App\Models\MasterCallUserTask::STATUS_SELECT as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-3 pe-0">
                            <select class="form-control form-control-sm" id="search_response_status">
                                <option value="all">All Response</option>
                                @foreach(App\Models\MasterCallUserTask::RESPONSE_STATUS_SELECT as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="float-end">
                                <button class="btn btn-light-blue btn-sm btn-search" id="search-btn" type="button"><i class="fa fa-search me-2"></i>Search</button>
                                <button class="btn btn-light btn-sm btn-search" type="reset"><i class="fa fa-undo me-2"></i>Clear</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-bordered ajaxTable datatable datatable-MasterCallUserTask custom-table table-sm">
                <thead class="thead-bg">
                    <tr>
                        <th>Company Name</th>
                        <th>Director Name</th>
                        <th>Revenue</th>
                        <th>Status</th>
                        <th>Response</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- modal -->
    <div id="called-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-inside-title">Actions - <span id="title-phone-no"></span></h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.salesman-calls.called-phone') }}" id="actions-form">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-12 col-md-4">
                            <table class="table table-bordered table-xs w-full special-table">
                                <tbody >
                                    <tr>
                                        <th width="120">Company Name</th>
                                        <td class="text-secondary" id="company_name"></td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td class="text-secondary" id="company_address"></td>
                                    </tr>
                                    <tr>
                                        <th>Business Activities</th>
                                        <td class="text-secondary" id="company_description"></td>
                                    </tr>
                                    <tr>
                                        <th>Revenue</th>
                                        <td class="text-secondary" id="revenue"></td>
                                    </tr>
                                    <tr>
                                        <th>Director Name</th>
                                        <td class="text-secondary" id="director_name"></td>
                                    </tr>
                                    <tr>
                                        <th>IC</th>
                                        <td class="text-secondary" id="director_ic"></td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td class="text-secondary" id="director_phone"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-md-8 mb-3" id="case-log-history"></div>
                    </div>
                    <div class="form-group" id="remark-comment-div">
                        <span>Remark/Comment</span> &nbsp;<span class="text-xs remark-error text-danger">* Remark/Comment Required</span>
                        <textarea class="form-control form-control-sm" id="ck-editor-textarea" rows="4" name="details" style="resize:none;"></textarea>
                        <span class="text-xs text-muted">Only <b class="text-green">Interest</b> required Remark/Comment.</span>
                    </div>
                    <div class="form-group" id="customer-response-div">
                        <span>Customer Response<span class="text-danger">*</span></span><br>
                        <div class="row mx-2 mt-1">
                            @foreach(App\Models\MasterCallUserTask::RESPONSE_STATUS_SELECT as $key => $value)
                                @if($key == 5)
                                    <div class="col-12 col-md-4 col-lg-2 form-check" id="div-response-input-{{$key}}">
                                        <input class="form-check-input" type="radio" name="response_status" id="flexRadioDefault{{$key}}" value="{{$key}}" required>
                                        <label class="form-check-label special-option" for="flexRadioDefault{{$key}}">
                                            Do Not Call List
                                        </label>
                                    </div>
                                @else
                                <div class="col-12 col-md-4 col-lg-2 form-check" id="div-response-input-{{$key}}">
                                    <input class="form-check-input" type="radio" name="response_status" id="flexRadioDefault{{$key}}" value="{{$key}}" required>
                                    <label class="form-check-label text-{{App\Models\MasterCallUserTask::RESPONSE_STATUS_CLASSES[$key]}}" for="flexRadioDefault{{$key}}">
                                        {{ $value }}
                                    </label>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="button-container">
                        <input type="hidden" name="id" id="input_id" value=""/>
                        <button type="button" class="btn btn-primary" id="action-submit-btn">Submit</button>
                        <a href="#" class="cancel btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // modal function
            function open_called_modal(id)
            {
                $('#case-log-history').html("");
                var _token = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': _token } });
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.salesman-calls.case-log-history') }}",
                    data: {
                        id : id,
                        _token : _token
                    },
                    dataType: "JSON",
                    success: function (data) {
                        if(data.status_code == 0){
                            var tbody = '';
                            $.each(data.tbody_data, function(index, value) {
                                tbody += '<tr>';
                                tbody += '<td>'+value.created_at+'</td>';
                                tbody += '<td>'+value.details+'</td>';
                                tbody += '<td>'+value.user.name+'</td>';
                                tbody += '</tr>';
                            });
                            var thead = '<tr><th width="200">Called At</th><th>Remarks</th><th width="200">Called By</th></tr>';
                            var title = '<div class="pb-1">This Phone No. related Log History</div>';
                            var table_display = title+'<table class="table table-bordered table-xs"><thead>'+thead+'</thead><tbody>'+tbody+'</tbody></table>';
                            $('#case-log-history').html(table_display);
                        }
                        // other
                        $('#company_name').html(data.list.company_name);
                        $('#company_address').html(data.list.company_address);
                        $('#company_description').html(data.list.company_description);
                        $('#revenue').html(data.list.revenue);
                        $('#director_name').html(data.list.name);
                        $('#director_ic').html(data.list.ic);
                        $('#director_phone').html(data.list.phone);
                        $('#title-phone-no').html(data.list.phone);
                    }
                });
                $('#input_id').val(id);
                $('#called-modal').show();
            }
            // submit modal
            function submitform()
            {
                $('.remark-error').hide();
                $('.cke_inner').removeClass('border-red');
                // check
                var check = 0;
                var response_status = $('input[name="response_status"]:checked').val();
                if(response_status == 4){ // interest
                    var messageLength = CKEDITOR.instances['ck-editor-textarea'].getData().replace(/<[^>]*>/gi, '').length;
                    if( !messageLength ) {
                        check += 1;
                        $('.remark-error').show();
                        $('.cke_inner').addClass('border-red');
                    }
                }
                if(check == 0){
                    $('#actions-form').submit();
                }
            }
            // add case
            function addCase(id) {
                if (confirm('Confirm add to case?')) {
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    $.ajaxSetup({headers: {'X-CSRF-TOKEN': _token}});
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.salesman-calls.add-case') }}",
                        data: {
                            id: id,
                            _token: _token
                        },
                        dataType: "JSON",
                        success: function (data) {
                            // console.log(data);
                            if (data.status_code == 0) {
                                var this_url = "{{ route('admin.case-lists.create',':id')}}";
                                this_url = this_url.replace(':id', data.case_id);
                                window.location.href = this_url;
                            } else {
                                alert(data.message);
                            }
                        }
                    });
                }
            }
            // button action & modal
            function Update(response,id){
                $('#div-response-input-0').hide();
                $('#div-response-input-1').hide();
                $('#div-response-input-2').hide();
                $('#div-response-input-3').hide();
                $('#div-response-input-4').hide();
                $('#remark-comment-div').show();
                $('#customer-response-div').show();
                $('#action-submit-btn').show();
                switch(response){
                    case 0:
                        $('#div-response-input-1').show();
                        $('#div-response-input-2').show();
                        $('#div-response-input-3').show();
                        $('#div-response-input-4').show();
                        break;
                    case 1:
                        $('#div-response-input-1').show();
                        $('#div-response-input-2').show();
                        $('#div-response-input-3').show();
                        $('#div-response-input-4').show();
                        break;
                    default:
                        $('#remark-comment-div').hide();
                        $('#customer-response-div').hide();
                        $('#action-submit-btn').hide();
                }
                open_called_modal(id);
            }
            $(".cancel").click(function() {
                $(this).parent().parent().parent().parent().parent().hide();
            });
            window.onclick = function(event) {
                if(event.target.getAttribute('id') == 'called-modal'){
                    $('#called-modal').hide();
                }
            }
            $('#action-submit-btn').on('click', function (e){ submitform(); });

            // table
            $(function () {
                let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                let dtOverrideGlobals = {
                    buttons: dtButtons,
                    processing: true,
                    serverSide: true,
                    retrieve: true,
                    searching: false,
                    lengthChange: false,
                    aaSorting: [],
                    ajax: {
                        url: "{{ route('admin.salesman-calls.all-call.index') }}",
                        data: function (d) {
                            d.search_status = $('#search_status').val(),
                            d.search_response_status = $('#search_response_status').val(),
                            d.search_input = $('#search_input').val()
                        }
                    },
                    columns: [
                        { data: 'list.company_name', name: 'list.company_name' },
                        { data: 'list.name', name: 'list.name' },
                        { data: 'list.revenue', name: 'list.revenue' },
                        { data: 'status', name: 'status' },
                        { data: 'response_status', name: 'response_status' },
                        { data: 'actions', name: '{{ trans('global.actions') }}' }
                    ],
                    orderCellsTop: true,
                    order: [[ 1, 'desc' ]],
                    pageLength: 10,
                };
                let table = $('.datatable-MasterCallUserTask').DataTable(dtOverrideGlobals);
                $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                });
                $("#search-btn").click(function(){ table.draw(); });

                // text-editor
                CKEDITOR.replace( 'ck-editor-textarea', {
                    toolbar:[
                        { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
                        { name: 'styles', items: [ 'Format', 'FontSize' ] },
                        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat' ] },
                        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                    ],
                });
                $('.remark-error').hide();
            });
        </script>
    @endpush
</x-admin.app-layout>




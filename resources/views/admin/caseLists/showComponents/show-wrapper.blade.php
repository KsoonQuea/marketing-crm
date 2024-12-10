<x-admin.app-layout custom-errors="{!! $custom_errors !!}">
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick-theme.css') }}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-case.css') }}">
    @endpush
    <div class="text-center" id="overlay">
        <div class="loader-box">
            <div class="loader-3"></div>
        </div>
    </div>
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ $caseList->company_name }}
                <span class="breadcrumb-title-sm">Case Code: <b>{{ $caseList->case_code }}</b></span>
            </h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.case-lists.index') }}">
                Case List
            </a>
        </li>
        <li class="breadcrumb-item active">Show Case</li>
    </x-admin.breadcrumb>

    <!-- Contents -->
    <div class="card show-case-card">
        <div class="card-body p-0">
            <div class="row">
                <!-- tab header -->
                <div class="col-12 col-md-12 col-lg-8">
                    <ul class="nav nav-tabs nav-primary">
                        <li class="nav-item">
                            <a class="nav-link {{ routeActive('admin.case-lists.show-credit') }}" href="{{ route('admin.case-lists.show-credit',$caseList->id) }}">
                                Credit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ routeActive('admin.case-lists.show-caseInfo') }}" href="{{ route('admin.case-lists.show-caseInfo',$caseList->id) }}">
                                Cases Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ routeActive('admin.case-lists.show-attachment') }}" href="{{ route('admin.case-lists.show-attachment',$caseList->id) }}">
                                Attachment
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ routeActive('admin.case-lists.show-agreement') }}" href="{{ route('admin.case-lists.show-agreement',$caseList->id) }}">
                                Agreement & Billing
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- buttons -->
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="button-container p-3 pb-0">
                        @switch($caseList->case_status)
                            @case(0)
                            @if(!$isSeen)
                                @can('case_check_2')
                                    <button class='case-seen btn btn-primary-light btn-sm'>Checked</button>
                                @endcan
                                @can('case_rework_2')
                                    <button class="case-return btn btn-danger btn-sm">Rework</button>
                                @endcan
                                @can('case_drop_2')
                                    <button class="btn btn-dark btn-sm drop-btn">Drop</button>
                                @endcan
                            @endif

                            @php $caseType_class = 'management_class' @endphp
                            @break

                            @case(3)
                            @can('case_resubmit_2')
                                <button class='case-resubmit btn btn-primary-light btn-sm'>Resubmit</button>
                            @endcan

                            @php $caseType_class = 'bfe_class' @endphp
                            @break

                            @case(5)
                            @php $caseType_class = 'drop_class' @endphp
                            @break

                            @default
                            @php $caseType_class = '' @endphp
                        @endswitch
                    </div>
                </div>

{{--                <hr style="width: 95%">--}}

            </div>
        </div>
        @yield('view-content')
    </div>

    <!-- ********* modal ********* -->
    <div id="seenReturnModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-inside-title">Case Action <span class="action_title_span"></span></h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.user-case-logs.store') }}">
                    @csrf
                    {!! csrf_field() !!}
                    <input type="hidden" name="user_id"     value="{{ Auth::user()->id }}">
                    <input type="hidden" name="action"      id="action">
                    <input type="hidden" name="user_role"   value="{{ Auth::user()->roles->first()->id }}">
                    <input type="hidden" name="case_id"     value="{{ $caseList->id }}">
                    <input type="hidden" name="case_code"   value="{{ $caseList->case_code }}">
                    <input type="hidden" name="salesman_id" value="{{ $caseList->salesman_id }}">
                    <input type="hidden" name="action_text" value="" id="action_text" readonly
                           style="display: block; width:100%;">
                    <div class="form-group">
                        <label for="seen-return-remark">Remark</label>
                        <textarea class="form-control" name="remark" id="seen-return-remark"></textarea>
                    </div>
                    <div class="button-container">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="#" class="cancel btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/js/auto-complete/auto-complete.js') }}"></script>
        <script>
            $(document).ready(function() {
                var status = {{ $caseList->case_status }};
                switch (status){
                    case 0: case 1: case 2:
                        @canany(['case_check_2', 'case_rework_2', 'case_drop_2'])
                        @else
                        $('.able-disabled:input').prop('disabled', true);
                        $('select').prop('disabled', true);
                        $('textarea').prop('disabled', true);
                        $('.management_class').prop('disabled', true);
                        @endcanany
                        break;

                    case 3:
                        @cannot('case_resubmit_2')
                        $('.able-disabled:input').prop('disabled', true);
                            $('select').prop('disabled', true);
                            $('textarea').prop('disabled', true);
                            $('.bfe_class').prop('disabled', true);
                        @endcannot
                        break;

                    case 4: case 5:
                        $('.able-disabled:input').prop('disabled', true);
                        // $("input").prop('disabled', true);
                        $('select').prop('disabled', true);
                        $('textarea').prop('disabled', true);
                        $('.drop_class').prop('disabled', true);
                        $('.no-disabled').prop('disabled', false);
                        break;
                }

                // overlay remove
                $('#overlay').fadeOut();
                // declare
                $('.accordion').click(function() {
                    if ($(this).next().is(":visible")) {
                        $(this).next().hide();
                    } else {
                        $(this).next().show();
                    }
                });

                // select2 declare
                $(".select2").select2();

                // modal related
                window.onclick = function(event) {
                    if (event.target.id == 'seenReturnModal') {
                        $('#seenReturnModal').hide();
                    }
                }
                // close modal
                $('.cancel').click(function() {
                    $(this).parent().parent().parent().parent().parent().hide();
                });

                // modal listing
                $('.case-seen').click(function() {
                    $('#seenReturnModal').show();
                    $('#action_text').val('{{ App\Models\UserCaseLog::STATUS_SELECT[1] }}');
                    $('.action_title_span').text('(Checked)');
                    $('#action').val(1);
                });
                $('.case-return').click(function() {
                    $('#seenReturnModal').show();
                    $('#action_text').val('{{ App\Models\UserCaseLog::STATUS_SELECT[2] }}');
                    $('.action_title_span').text('(Return)');
                    $('#action').val(2);
                });
                $('.case-resubmit').click(function() {
                    $('#seenReturnModal').show();
                    $('#action_text').val('{{ App\Models\UserCaseLog::STATUS_SELECT[3] }}');
                    $('.action_title_span').text('(Resubmit)');
                    $('#action').val(3);
                });
                $('.drop-btn').click(function (){
                    $('#seenReturnModal').show();
                    $('#action_text').val('{{ App\Models\UserCaseLog::STATUS_SELECT[5] }}');
                    $('.action_title_span').text('(Drop)');
                    $('#action').val(5);
                });

                // monthpicker
                $(".month-picker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'mm yyyy',
                    minView: 'months',
                    view: 'months',
                    language: 'en',
                });
                // no disabled for specific fields
                $('#platform').prop('disabled', false);
                $('#invoiceType').prop('disabled', false);
                $('input[name="case_id"]').prop('disabled', false);
                $('input[name="_token"]').prop('disabled', false);
                $('.dont-disabled').prop('disabled', false);
            });
        </script>
        <script>
            // case action - checked
            CKEDITOR.replace('seen-return-remark', {
                toolbar: [{
                    name: 'clipboard',
                    items: ['Undo', 'Redo']
                },
                    {
                        name: 'styles',
                        items: ['Format', 'FontSize']
                    },
                    {
                        name: 'basicstyles',
                        items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat']
                    },
                    {
                        name: 'colors',
                        items: ['TextColor', 'BGColor']
                    },

                ],
            });
            // nav
            $(function(){
                var hash = window.location.hash;
                hash && $('ul.nav a[href="' + hash + '"]').tab('show');

                $('.nav-tabs a').click(function (e) {
                    $(this).tab('show');
                    var scrollmem = $('head').scrollTop() || $('html').scrollTop();
                    window.location.hash = this.hash;
                    $('html,body').scrollTop(scrollmem);
                });
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        </script>
        @include('admin.caseLists.partials.caseJs')
    @endpush
</x-admin.app-layout>

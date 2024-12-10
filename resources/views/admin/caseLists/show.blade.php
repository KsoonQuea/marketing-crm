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
        <div class="card-body p-3">
            <div class="row">
                <!-- tab header -->
                <div class="col-12 col-md-12 col-lg-8">
                    <ul class="nav nav-tabs nav-primary" id="case_tabs1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="credit-tab" data-bs-toggle="pill" href="#credit" role="tab"
                               aria-controls="credit" aria-selected="true">
                                Credit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="case_info-tab" data-bs-toggle="pill" href="#case_info" role="tab"
                               aria-controls="case_info" aria-selected="false">
                                Cases Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="documents-tab" data-bs-toggle="pill" href="#documents" role="tab"
                               aria-controls="documents" aria-selected="false">
                                Attachment
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="agmt-tab" data-bs-toggle="pill" href="#agmt" role="tab"
                               aria-controls="agmt" aria-selected="false">
                                Agreement & Billing
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- buttons -->
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="button-container">
                        @can('user_case_log_create')
                            @if (!$isSeen)
                                <button class='case-seen btn btn-primary-light btn-sm'>Checked</button>
                                <button class="case-return btn btn-danger btn-sm">Rework</button>
                            @endif
                        @endcan
                        @php $this_roles_id = auth()->user()->roles?->first()?->id; @endphp
                        @if($caseList->case_status == 3 && $this_roles_id == 2)
                            <!-- is bfe, able resubmit -->
                            <button class='case-resubmit btn btn-primary-light btn-sm'>Resubmit</button>
                        @endif
                        @if($caseList->case_status != 5 && ($this_roles_id == 1 || $this_roles_id == 3))
                        <!-- drop function (master account & sales manager only) -->
                        <button class="btn btn-dark btn-sm drop-btn">Drop</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <!-- Credit Tab -->
                <div class="tab-pane active" id="credit" role="tabpanel" aria-labelledby="credit-tab">
                    <ul class="nav nav-pills mt-3 inside-nav" id="credit-tab">
                        <li class="nav-item">
                            <a class="nav-link active" id="case-status-summary-tab" data-bs-toggle="pill" href="#case-status-summary" role="tab"
                               aria-controls="case-status-summary" aria-selected="true">
                                Summary & Memo
                            </a>
                        </li>
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" id="memo-tab" data-bs-toggle="pill" href="#memo" role="tab"--}}
{{--                               aria-controls="memo" aria-selected="true">--}}
{{--                                Memo & Acknowledgement--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li class="nav-item">
                            <a class="nav-link" id="pcr-tab" data-bs-toggle="pill" href="#pcr" role="tab"
                               aria-controls="pcr" aria-selected="true">
                                Pulse Check Report
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="case-status-summary" role="tabpanel" aria-labelledby="case-status-summary-tab">
                            @include('admin.caseLists.showComponents.case-status-summary')
                        </div>
{{--                        <div class="tab-pane fade" id="memo" role="tabpanel" aria-labelledby="memo-tab">--}}
{{--                            @include('admin.caseLists.showComponents.memo')--}}
{{--                        </div>--}}
                        <div class="tab-pane fade" id="pcr" role="tabpanel" aria-labelledby="pcr-tab">
                            @include('admin.caseLists.showComponents.pulse-check-report')
                        </div>
                    </div>

                </div>

                <!-- Case Information Tab -->
                <div class="tab-pane" id="case_info" role="tabpanel" aria-labelledby="case_info-tab">
                    <ul class="nav nav-pills mt-3 inside-nav" id="case_info-tab">
                        <li class="nav-item">
                            <a class="nav-link active" id="kyc-tab" data-bs-toggle="pill" href="#kyc" role="tab"
                               aria-controls="kyc" aria-selected="true">
                                KYC
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="financial-tab" data-bs-toggle="pill" href="#financial" role="tab"
                               aria-controls="financial" aria-selected="true">
                                Financial
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="bankstt-tab" data-bs-toggle="pill" href="#bankstt" role="tab"
                               aria-controls="bankstt" aria-selected="true">
                                Bank Statement
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="directorCommitment-tab" data-bs-toggle="pill" href="#directorCommitment" role="tab"
                               aria-controls="directorCommitment" aria-selected="true">
                                Directors commitment
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kyc" role="tabpanel" aria-labelledby="kyc-tab">
                            @include('admin.caseLists.showComponents.kyc')
                        </div>
                        <div class="tab-pane fade" id="financial" role="tabpanel" aria-labelledby="financial-tab">
                            @include('admin.caseLists.showComponents.financial')
                        </div>
                        <div class="tab-pane fade" id="bankstt" role="tabpanel" aria-labelledby="bankstt-tab">
                            @include('admin.caseLists.showComponents.bank-statement')
                        </div>
                        <div class="tab-pane fade" id="directorCommitment" role="tabpanel" aria-labelledby="directorCommitment-tab">
                            @include('admin.caseLists.showComponents.director-commitment')
                        </div>
                    </div>
                </div>

                <!-- Attachment Tab -->
                <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                    @include('admin.caseLists.showComponents.documents')
                </div>

                <!-- Agreement & BillingTab -->
                <div class="tab-pane fade" id="agmt" role="tabpanel" aria-labelledby="agmt-tab">
                    @include('admin.caseLists.showComponents.agreement-billing')
                </div>

                <!-- Billing Tab (Hidden) -->
                <div class="tab-pane fade" id="call-logs" role="tabpanel" aria-labelledby="call-logs-tab">
                    @include('admin.caseLists.showComponents.call-log')
                </div>

                <!-- Director Tab (Hidden) -->
                <div class="tab-pane fade" id="directors" role="tabpanel" aria-labelledby="directors-tab">
                    @include('admin.caseLists.showComponents.director')
                </div>
            </div>
        </div>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
        <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/js/auto-complete/auto-complete.js') }}"></script>
        <script>
            $(document).ready(function() {

                $(".select2").select2();

                $('.close').click(function() {
                    $(this).parent().parent().parent().parent().hide();
                });

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
                    $('#action_text').val('{{ App\Models\UserCaseLog::STATUS_SELECT[3] }}');
                    $('.action_title_span').text('(Drop)');
                    $('#action').val(5);
                });

                $('.accordion').click(function() {
                    if ($(this).next().is(":visible")) {
                        $(this).next().hide();
                    } else {
                        $(this).next().show();
                    }
                });

                window.onclick = function(event) {
                    if (event.target.id == 'seenReturnModal') {
                        $('#seenReturnModal').hide();
                    }
                }
            });
        </script>
        <script>
            Dropzone.autoDiscover = false;
            var uploadedPhotoMap = {}
            // Dropzone.options.documentDropzone = {
            var myDropzone = new Dropzone("div#document-dropzone",{
                url: '{{ isset($caseList->company_name)?route('admin.case-lists.storeMedia')."?company_name=" .$caseList->company_name:route('admin.case-lists.storeMedia') }}',
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function (file, response) {
                    $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
                    uploadedPhotoMap[file.name] = response.name
                },
                removedfile: function (file) {
                    //console.log(file)
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedPhotoMap[file.name]
                    }
                    $('form').find('input[name="document[]"][value="' + name + '"]').remove()
                },
                init: function () {
                    @if (isset($bonusRecord) && $bonusRecord->image)
                    var files = {!! json_encode($bonusRecord->image) !!}
                    for(
                    var i
                in
                    files
                )
                    {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        this.options.thumbnail.call(this, file, file.preview)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
                    }
                    @endif
                },
                error: function (file, response) {
                    if ($.type(response) === 'string') {
                        var message = response //dropzone sends it's own error messages in string
                    } else {
                        var message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
            });

            var directors = {!! json_encode($directors_array) !!};

            // autocomplete(document.getElementById("director_commitment_director"), directors);

            function financing_instrument() {
                return {
                    fields: [],
                    addNewField() {
                        this.fields.push({
                            txt1: '',
                            txt2: '',
                            txt3: '',
                            txt4: '',
                        });
                    },
                    removeField(index) {
                        this.fields.splice(index, 1);
                    }
                }
            }

        </script>
        <script>
            Dropzone.autoDiscover = false;
            var uploadedAgreementMap= {};
            var agreementDropzone = new Dropzone("div#agreement-dropzone",{
                url: '{{ route('admin.case-lists.storeMedia') }}',
                maxFilesize: 2, // MB
                acceptedFiles: '.pdf,.png,.jpeg,.jpg',
                maxFiles: 1,
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function (file, response) {
                    $('form').append('<input type="hidden" name="agreement[]" value="' + response.name + '">')
                    uploadedAgreementMap[file.name] = response.name
                },
                removedfile: function (file) {
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedAgreementMap[file.name]
                    }
                    $('form').find('input[name="agreement[]"][value="' + name + '"]').remove()
                },
                init: function () {
                    @if (isset($agreement_document) && $agreement_document)
                    var files = {!! json_encode($agreement_document) !!}
                    for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        this.options.thumbnail.call(this, file, file.preview)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="agreement[]" value="' + file.file_name + '">')
                    }
                    @endif
                },
                error: function (file, response) {
                    if ($.type(response) === 'string') {
                        var message = response //dropzone sends it's own error messages in string
                    } else {
                        var message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
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
        <script>
            $(document).ready(function(){
                $('#overlay').fadeOut();
            });
        </script>
        @include('admin.caseLists.partials.caseJs')
    @endpush
</x-admin.app-layout>

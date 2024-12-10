<x-admin.app-layout>
    @push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-case.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            /* display: none; <- Crashes Chrome on hover */
            -webkit-appearance: none;
            margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
        }

        input[type=number] {
            -moz-appearance:textfield; /* Firefox */
        }

        .show_increment_normal::-webkit-inner-spin-button, .show_increment_normal::-webkit-outer-spin-button {
            -webkit-appearance:inner-spin-button !important;
        }

        .show_increment_firefox {
            -moz-appearance: button !important; /* Firefox */
        }

        .autocomplete {
            /*the container must be positioned relative:*/
            position: relative;
            display: inline-block;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }
        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }
        .autocomplete-items div:hover {
            /*when hovering an item:*/
            background-color: #e9e9e9;
        }
        .autocomplete-active {
            /*when navigating through the items using the arrow keys:*/
            background-color: DodgerBlue !important;
            color: #ffffff;
        }

        .custom-table th,
        .custom-table td {
            padding: 0.75em 1em;
        }

        .custom-table thead th {
            padding: 0.75em 1em !important;
        }
    </style>
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Create Case</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.case-lists.index') }}">
                Case List
            </a>
        </li>
        <li class="breadcrumb-item active">Create Case</li>
    </x-admin.breadcrumb>

    <div class="card">
        <div class="card-header p-0">
            <ul class="nav nav-tabs nav-primary" id="warningtab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="kyc-tab" data-bs-toggle="pill" href="#kyc" role="tab" aria-controls="kyc" aria-selected="true">KYC</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="financial-tab" data-bs-toggle="pill" href="#financial" role="tab" aria-controls="financial" aria-selected="false">Financial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="bankstt-tab" data-bs-toggle="pill" href="#bankstt" role="tab" aria-controls="bankstt" aria-selected="false">Bank Statement</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="director-tab" data-bs-toggle="pill" href="#director" role="tab" aria-controls="director" aria-selected="false">Directors commitment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="director-tab" data-bs-toggle="pill" href="#documents" role="tab" aria-controls="documents" aria-selected="false">Document</a>
                </li>

            </ul>
        </div>
        <div class="card-body p-3">
            <form method="POST" action="{{ route("admin.case-lists.update", [$caseList->id]) }}" id="createUpdateCaseForm" enctype="multipart/form-data" AUTOCOMPLETE="off">
                @method('PUT')
                @csrf
                 <div class="tab-content" id="warningtabContent">
                    <div class="tab-pane fade show active" id="kyc" role="tabpanel" aria-labelledby="kyc-tab">
                        @include('admin.caseLists.createComponents.kyc')
                    </div>

                    <div class="tab-pane fade" id="financial" role="tabpanel" aria-labelledby="financial-tab">
                        @include('admin.caseLists.createComponents.financial')
                    </div>

                    <div class="tab-pane fade" id="bankstt" role="tabpanel" aria-labelledby="bankstt-tab">
                        @include('admin.caseLists.createComponents.bankStt')
                    </div>

                    <div class="tab-pane fade" id="director" role="tabpanel" aria-labelledby="director-tab">
                        @include('admin.caseLists.createComponents.directorCommitment')
                    </div>

                    <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="document-tab">
                        @include('admin.caseLists.createComponents.document')
                    </div>
                </div>
            </form>
            @include('admin.caseLists.createComponents.modal')
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
        <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
        <script>
            var uploadedPhotoMap = {}
            Dropzone.options.documentDropzone = {
                url: '{{ isset($caseList->company_name)?route('admin.case-lists.storeMedia')."?company_name=" .$caseList->company_name:route('admin.case-lists.storeMedia') }}',
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(file, response) {
                    $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
                    uploadedPhotoMap[file.name] = response.name
                },
                removedfile: function(file) {
                    console.log(file)
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedPhotoMap[file.name]
                    }
                    $('form').find('input[name="document[]"][value="' + name + '"]').remove()
                },
                init: function() {
                    @if (isset($bonusRecord) && $bonusRecord->image)
                    var files = {!! json_encode($bonusRecord->image) !!}
                    for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        this.options.thumbnail.call(this, file, file.preview)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
                    }
                    @endif
                },
                error: function(file, response) {

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
            }

            function newFolderModalFormAjax(){
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.case-lists.newFolders', ['caseList' => $caseList->id, 'type' => 'create']) }}",
                    data: {
                        folder_name: $("#folder_name").val(),
                        path: $("#path2").val(),
                    },
                    success: function (result) {
                        $('#createUpdateCaseForm').submit()
                    }
                });
            }

            function uploadModalFormAjax(){
                var data = $('#create_storeDocuments').serialize();

                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.case-lists.storeDocuments', ['caseList' => $caseList->id, 'type' => 'create']) }}",
                    data: data,
                    success: function (result) {
                        $('#createUpdateCaseForm').submit()
                    }
                });
            }

            //case document create
            $(document).ready(function() {
                $(".error-area").parent("td").children("span").css("background-color", "#ffdddd");
                $(".error-area").parent("td").children("span").children("span").css("background-color", "#ffdddd");
                $(".error-area").parent("td").children("span").children("span").children("span").css("background-color", "#ffdddd");

                $('.img-label').click(function(e) {
                    if ($('#select').is(":visible")) {
                        e.preventDefault();
                        window.open($(this).parent().attr('href'), '_blank');
                    }
                });

                $('.documents-title').click(function(e) {
                    if ($(this).next().is(":visible")) {
                        $(this).next().hide();
                        $(this).find('.document-triangle').removeClass('fa-angle-up').addClass('fa-angle-down');
                    } else {
                        $(this).next().show();
                        $(this).find('.document-triangle').removeClass('fa-angle-down').addClass('fa-angle-up');
                    }
                });

                $('#select').click(function() {
                    $('#upload').hide();
                    $('#select').hide();
                    $('#close').show();
                    $('#create_delete').show();
                    $('#selectall').show();
                    $('#zip').show();
                    $(".document-check-box").removeAttr("disabled");
                });

                $('#close').click(function() {
                    $('#upload').show();
                    $('#select').show();
                    $('#close').hide();
                    $('#create_delete').hide();
                    $('#selectall').hide();
                    $('#unselectall').hide();
                    $('#zip').hide();
                    $('.documents-title').next().hide();
                    $('.documents-title').find('.document-triangle').removeClass('fa-angle-up').addClass('fa-angle-down');
                    $(".document-check-box").prop("checked", false);
                    $(".document-check-box").attr("disabled", "disabled");
                });

                $('#selectall').click(function() {
                    $('.documents-title:not(".media-empty")').next().show();
                    $('.documents-title:not(".media-empty")').find('.document-triangle').removeClass('fa-angle-down').addClass('fa-angle-up');
                    $('#unselectall').show();
                    $('#selectall').hide();
                    $(".document-check-box").prop("checked", true);
                });

                $('#unselectall').click(function() {
                    $('#selectall').show();
                    $('#unselectall').hide();
                    $('.documents-title').next().hide();
                    $('.documents-title').find('.document-triangle').removeClass('fa-angle-up').addClass('fa-angle-down');
                    $(".document-check-box").prop("checked", false);
                });

                $('#zip').click(function() {
                    var selected = [];
                    $(".document-check-box:checked").each(function() {
                        selected.push($(this).attr('mediaid'));
                    });
                    if (selected.length > 0) {
                        window.open(
                            "{{ route('admin.case-lists.zip', ['caseList' => $caseList->id]) }}?mediaid=" +
                            selected.join(','), '_blank');
                    }
                });

                $('#create_delete').click(function() {
                    var selected = [];
                    $(".document-check-box:checked").each(function() {
                        selected.push($(this).attr('mediaid'));
                    });
                    if (selected.length > 0) {
                        var route =
                            "{{ route('admin.case-lists.delete', ['caseList' => $caseList->id]) }}?type=create&mediaid=" +
                            selected.join(',');

                        console.log(route)

                        $.ajaxSetup({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                        });
                        $.ajax({
                            type: "GET",
                            url: route,
                            data: {
                                data: 0
                            },
                            success: function (result) {
                                $('#createUpdateCaseForm').submit()
                            }
                        });
                    }
                });

                $('.case-document-container').click(function(e) {
                    if (!$('#select').is(":visible")) {
                        e.preventDefault();
                        $(this).find('.document-check-box').prop('checked', !$(this).find('.document-check-box')
                            .prop('checked'));
                    }
                });

                $('#upload,#upload_sub').click(function(event) {
                    $('#path1').val($(this).attr('path'));
                    $('#uploadModal').show();
                    event.stopPropagation();
                });

                $('#new_folder,#new_folder_sub').click(function(event) {
                    $('#path2').val($(this).attr('path'));
                    $('#newFolderModal').show();
                    event.stopPropagation();
                });

                $('.remove_folder').click(function(event) {
                    $('#path3').val($(this).attr('path'));
                    $('#deleteModal').show();
                    event.stopPropagation();
                });

                $('.cancel').click(function() {
                    $(this).parent().parent().parent().parent().parent().hide();
                });

                window.onclick = function(event) {
                    if (event.target.id == 'uploadModal') {
                        $('#uploadModal').hide();
                    }
                    if (event.target.id == 'newFolderModal') {
                        $('#newFolderModal').hide();
                    }
                    if (event.target.id == 'deleteModal') {
                        $('#deleteModal').hide();
                    }
                }

                // monthpicker
                $(".month-picker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'mm yyyy',
                    minView: 'months',
                    view: 'months',
                    language: 'en',
                });
            });

            //run the next / pervious Btn Function
            $('.btnNext').click(function() {
                const nextTabLinkEl = $('.nav-tabs .active').closest('li').next('li').find('a')[0];
                const nextTab = new bootstrap.Tab(nextTabLinkEl);
                nextTab.show();
            });

            $('.btnPrevious').click(function() {
                const prevTabLinkEl = $('.nav-tabs .active').closest('li').prev('li').find('a')[0];
                const prevTab = new bootstrap.Tab(prevTabLinkEl);
                prevTab.show();
            });

            $(".select2").select2();

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

            //director cmmt
            // function runDirCmmt(index){
            //     // $('[name="mgmt_team_name[]"]').each(function (key, item){
            //     //     var name    = item.value;
            //     //     var ic      = $('[name="mgmt_team_ic[]"]')[key].value;
            //     //     var phone   = $('[name="mgmt_team_phone[]"]')[key].value;
            //     //
            //     //     if ((name !== '' && ic !== '' && phone !== '') && (name !== null && ic !== null && phone !== null)){
            //     //         director_commitment().addNewCardFromKYC({
            //     //             director_name: name,
            //     //             director_ic: ic,
            //     //             director_phone: phone,
            //     //         });
            //     //
            //     //         $("#add_bankStt").click();
            //     //     }
            //     // });
            //
            //     var name    = $('[name="mgmt_team_name[]"]')[index].value;
            //     var ic      = $('[name="mgmt_team_ic[]"]')[index].value;
            //     var phone   = $('[name="mgmt_team_phone[]"]')[index].value;
            //
            //     if ((name !== '' && ic !== '' && phone !== '') && (name !== null && ic !== null && phone !== null)){
            //         director_commitment().addNewCardFromKYC({
            //             director_name: name,
            //             director_ic: ic,
            //             director_phone: phone,
            //         });
            //
            //         $("#add_bankStt").click();
            //     }
            // }
    </script>
        @include('admin.caseLists.partials.caseJs')
    @endpush
</x-admin.app-layout>

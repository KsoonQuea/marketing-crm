@extends('admin.caseLists.showComponents.show-wrapper')

<style>
    .document-folder-first{
        background: red;
    }
    .documents-title{
        color:#ffffff;
        padding:0.25em 1em;
        margin:5px 0 0 0;
        background-color:#2198c3;
        font-weight:600;
    }
    .document-folder-files{
        padding: 3px 12px!important;
        border-bottom:1px solid gray;
        background: #ffffff ;
        color:#002855 ;
        font-weight:400;
        font-size:0.9em;
        margin:0;
    }
    .document-folder-files-none{
        padding: 3px 12px!important;
        background: #f5f7fb;
        color:gray;
        font-weight:400;
        font-size:0.9em;
        margin:0;
    }
    .btn-documents{
        background:#ffffff00;
        color:#ffffff;
        margin-top:-2px!important;
        font-size:0.8em!important;
        padding: 0.375rem 0.5rem!important;
    }
    .btn-documents:hover{ color:#ffffff70!important; }
    .image_grid input:checked + .caption::after{
        color: #9bfb54!important;
        border:none!important;
        left:90%!important;
    }
</style>

@section('view-content')
    <div class="p-3 able-disabled">
        @php $permission_document = $permissions['document']; @endphp

        <h5 class="tab-pane-header">Documents</h5> &nbsp;
        <div class="mt-2 float-right">
            {{--    @if($permission_document['close_button'] == 1)<button id="close" class='select-after btn btn-dark btn-sm'><i class="fa fa-close me-2"></i>Close</button>@endif--}}
            {{--    @if($permission_document['new_folder'] == 1)<button id="new_folder" path="" class='btn btn-primary btn-sm'><i class="fa fa-folder me-2"></i>New Folder</button>@endif--}}
            {{--    @if($permission_document['upload'] == 1)<button id="upload" path="" class='select-before btn btn-primary-light btn-sm'><i class="fa fa-upload me-2"></i>Upload</button>@endif--}}
            {{--    @if($permission_document['select'] == 1)<button id="select" class="select-before btn btn-secondary btn-sm">Select</button>@endif--}}
            {{--    @if($permission_document['select_all'] == 1)<button id="selectall" class='select-after btn btn-primary-light btn-sm'>Select All</button>@endif--}}
            {{--    @if($permission_document['unselect_all'] == 1)<button id="unselectall" class='select-after btn btn-primary-light btn-sm'>Unselect All</button>@endif--}}
            {{--    @if($permission_document['delete'] == 1)<button id="delete" class='select-after btn btn-secondary btn-sm'><i class="fa fa-trash me-2"></i>Delete</button>@endif--}}
            {{--    @if($permission_document['zip_download'] == 1)<button id="zip" class="select-after btn btn-secondary btn-sm"><i class="fa fa-download me-2"></i>Zip & Download</button>@endif--}}

            <button id="close" class='select-after btn btn-dark btn-sm {{ $caseType_class }}'><i class="fa fa-close me-2"></i>Close</button>
            @can('case_folder_create_2')
                <button id="new_folder" path="" class='btn btn-primary btn-sm {{ $caseType_class }}'><i class="fa fa-folder me-2"></i>New Folder</button>
            @endcan
            @can('case_file_create_2')
                <button id="upload" path="" class='select-before btn btn-primary-light btn-sm {{ $caseType_class }}'><i class="fa fa-upload me-2"></i>Upload</button>
            @endcan
            <button id="select" class="select-before btn btn-secondary btn-sm {{ $caseType_class }}">Select</button>
            <button id="selectall" class='select-after btn btn-primary-light btn-sm {{ $caseType_class }}'>Select All</button>
            <button id="unselectall" class='select-after btn btn-primary-light btn-sm {{ $caseType_class }}'>Unselect All</button>
            @can('case_file_delete_2')
                <button id="delete" class='select-after btn btn-secondary btn-sm {{ $caseType_class }}'><i class="fa fa-trash me-2"></i>Delete</button>
            @endcan
            @can('case_file_zip_2')
                <button id="zip" class="select-after btn btn-secondary btn-sm {{ $caseType_class }}"><i class="fa fa-download me-2"></i>Zip & Download</button>
            @endcan
        </div>
        <div class='row grid-two imageandtext'>
            {!! $documentsView !!}
        </div>

        <!-- modal -->
        <div id="newFolderModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-inside-title">New Folder Create</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.case-lists.newFolders', ['caseList' => $caseList->id, 'type' => 'edit']) }}">
                        @csrf
                        <input type="hidden" name="path" id="path2">
                        <div class="form-group">
                            <label for="document">Folder Name</label>
                            <input type="text" name="folder_name" id="folder_name" value="" style="display: block; width:100%;">
                        </div>
                        <div class="button-container">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="#" class="cancel btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="uploadModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-inside-title">Case Documents Upload</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.case-lists.storeDocuments', ['caseList' => $caseList->id, 'type' => 'edit']) }}">
                        @csrf
                        <input type="hidden" name="path" id="path1">
                        <div class="form-group">
                            <label for="document">Document</label>
                            <div class="needsclick dropzone" id="document-dropzone">
                            </div>
                        </div>
                        <div class="button-container">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="#" class="cancel btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-inside-title">Case Documents Folder Delete</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.case-lists.removeFolder', ['caseList' => $caseList->id, 'type' => 'edit']) }}">
                        @csrf
                        <input type="hidden" name="path" id="path3">
                        <div class="form-group">
                            <h5>Confirm delete folder and file inside?</h5>
                        </div>
                        <div class="button-container">
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <a href="#" class="cancel btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
            <script>
                // dropzone
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
                $(document).ready(function() {
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
                        $('#delete').show();
                        $('#selectall').show();
                        $('#zip').show();
                        $('.documents-title').next().hide();
                        $('.documents-title').find('.document-triangle').removeClass('fa-angle-up').addClass('fa-angle-down');
                        $(".document-check-box").removeAttr("disabled");
                        $(".document-check-box").prop("checked", false);
                    });

                    $('#close').click(function() {
                        $('#upload').show();
                        $('#select').show();
                        $('#close').hide();
                        $('#delete').hide();
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

                    $('#delete').click(function() {
                        var selected = [];
                        $(".document-check-box:checked").each(function() {
                            selected.push($(this).attr('mediaid'));
                        });
                        if (selected.length > 0) {
                            window.location.href =
                                "{{ route('admin.case-lists.delete', ['caseList' => $caseList->id]) }}?type=show&mediaid=" +
                                selected.join(',');
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
                        console.log(11230);
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
                });
            </script>
        @endpush
    </div>
@endsection

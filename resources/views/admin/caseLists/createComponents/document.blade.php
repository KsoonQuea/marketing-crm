@push('styles')
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
            background: #ffffff;
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
@endpush
<div class="row">
    <div class="col-3">
        <h6 class="card-title">Documents</h6> &nbsp;
    </div>
    <div class="col-9">
        <div class="float-right">
            <button type="button" id="close" class='select-after btn btn-dark btn-sm'><i class="fa fa-close me-2"></i>Close</button>
            <button type="button" id="new_folder" path="" class='btn btn-primary btn-sm'><i class="fa fa-folder me-2"></i>New Folder</button>
            <button type="button" id="upload" path="" class='select-before btn btn-primary-light btn-sm'><i class="fa fa-upload me-2"></i>Upload</button>
            <button type="button" id="select" class="select-before btn btn-secondary btn-sm">Select</button>
            <button type="button" id="selectall" class='select-after btn btn-primary-light btn-sm'>Select All</button>
            <button type="button" id="unselectall" class='select-after btn btn-primary-light btn-sm'>Unselect All</button>
            <button type="button" id="create_delete" class='select-after btn btn-secondary btn-sm'><i class="fa fa-trash me-2"></i>Delete</button>
{{--            <button type="button" id="zip" class="select-after btn btn-secondary btn-sm"><i class="fa fa-download me-2"></i>Zip & Download</button>--}}
        </div>
    </div>
</div>

<div class='row grid-two imageandtext'>
    {!! $documentsView !!}
</div>

<!-- submit form button -->
<br>
<hr class="mt-3">

<div class="row">
    <div class="col-3">
        <button type="button" class="btn btn-primary-light btnPrevious">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
            Previous</button>
    </div>
    <div class="col-4">

    </div>
    <div class="col-5">
        <div class="float-right">
            <button type="submit" name="caseCreateSubmission" form="createUpdateCaseForm" id="caseCreateSubmission_draft" class="btn btn-info" value="draft">
                <i class="fa fa-file-text me-3" aria-hidden="true"></i>
                Save As Draft
            </button>

            <button type="submit" name="caseCreateSubmission" form="createUpdateCaseForm" class="btn btn-primary" value="case_create">
                <i class="fa fa-arrow-up me-3"></i>
                Create New Case
            </button>
        </div>
    </div>
</div>

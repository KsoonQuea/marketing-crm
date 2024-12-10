{{--      modal part - document part     --}}
<div id="newFolderModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-inside-title">New Folder Create</h4>
        </div>
        <div class="modal-body">
            <form id="newFolderModalForm" method="POST" action="{{ route('admin.case-lists.newFolders', ['caseList' => $caseList->id, 'type' => 'create']) }}">
                @csrf
                <input type="hidden" name="path" id="path2">
                <div class="form-group">
                    <label for="document">Folder Name</label>
                    <input type="text" name="folder_name" id="folder_name" value="" style="display: block; width:100%;">
                </div>
                <div class="button-container">
                    <button type="button" class="btn btn-primary" onclick="newFolderModalFormAjax()">Submit</button>
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
            <form method="POST" id="create_storeDocuments" action="{{ route('admin.case-lists.storeDocuments', ['caseList' => $caseList->id, 'type' => 'create']) }}">
                @csrf
                <input type="hidden" name="path" id="path1">
                <div class="form-group">
                    <label for="document">Document</label>
                    <div class="needsclick dropzone" id="document-dropzone">
                    </div>
                </div>
                <div class="button-container">
                    <button type="button" onclick="uploadModalFormAjax()" class="btn btn-primary">Submit</button>
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

@forelse ($default_directory as $key=> $director)
    <div id="{{ $key }}-container" lvl={{ $director->lvl }} style="{{$director->lvl>=3?'padding-left:10px;':''}}">
        @if ($key != 'default')
            <div class="documents-title {{count($director->media)<=0 ? 'media-empty': ''}}" lvl={{ $director->lvl }}>
                {{ $key }} &nbsp; <i class="document-triangle fa fa-angle-down"></i>
            {{--@if($documentPermission == 1)--}}
                <div class="float-right">
                    @can('case_folder_delete_2')
                        <button type="button" id="remove_folder" path="{{ $director->path }}" class="remove_folder btn btn-primary btn-documents tw-leading-snug {{ $caseType_class }}" style="color:#ffa7a7;">
                            <i class="fa fa-trash"></i>
                        </button>
                    @endcan
                    @can('case_folder_create_2')
                        <button type="button" id="new_folder_sub" path="{{ $director->path }}" class="btn btn-primary btn-documents tw-leading-snug {{ $caseType_class }}">
                            <i class="fa fa-folder"></i>
                        </button>
                    @endcan
                    @can('case_file_create_2')
                        <button type="button" id="upload_sub" path="{{ $director->path }}" class="btn btn-primary btn-documents tw-leading-snug {{ $caseType_class }}">
                            <i class="fa fa-upload"></i>
                        </button>
                    @endcan
                </div>
            {{--@endif--}}
            </div>
        @endif
        <div class="row p-0 tw-m-px" id="{{ $key }}" lvl={{ $director->lvl }} style="{{$director->lvl>=2?'display:none;':''}} transition:2s;">
            @forelse ($director->media as $media_key=>$media)
                <a class="col-12 imageandtext image_grid case-document-container document-folder-files" href="{{ $media->original_url }}" target="_blank">
                    <label class="img-label" for="{{ $key . $media_key }}">
                        <input class="document-check-box" type="checkbox" name="{{ $key . $media_key }}" id="{{ $key . $media_key }}" mediaid="{{ $media->id }}" disabled>
                        <div class="caption"></div>
                        <span>{{ $media->file_name }}</span>
                    </label>
                </a>
            @empty
                @if($key != 'default')
                <p class="col-12 m-0 imageandtext image_grid case-document-container document-folder-files-none">No documents found</p>
                @endif
            @endforelse
            @if (isset($director->children))
                @include('admin.caseLists.showComponents.document-show', ['default_directory' => $director->children])
            @endif
        </div>
    </div>
@empty
    <p class="imageandtext image_grid case-document-container w-100 document-folder-files-none">No documents found</p>
@endforelse

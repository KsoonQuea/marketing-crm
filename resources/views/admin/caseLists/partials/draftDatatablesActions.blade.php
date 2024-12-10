<div class="tw-flex tw-justify-around tw-items-center tw-space-x-2">
    @can(str($permission_name)->lower()->singular()->snake().'_edit_2')
        <a class="btn btn-xs btn-secondary tw-py-2" href="{{ route('admin.case-lists.create', $row->id) }}">
            <i class="fa fa-edit fa-lg" title="edit"></i>
        </a>
    @endcan
    @can(str($permission_name)->lower()->singular()->snake().'_delete_2')
            <form action="{{ route('admin.case-lists.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Confirmed to remove This Draft?');" class="tw-inline-block">
                @method('DELETE')
                @csrf
                <button class="btn btn-xs btn-danger" type="submit">
                    <i class="fa fa-trash fa-lg" title="delete"></i>
                </button>
            </form>
    @endcan
</div>

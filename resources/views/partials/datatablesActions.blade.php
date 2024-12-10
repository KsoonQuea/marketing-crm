<div class="tw-flex tw-justify-around tw-items-center tw-space-x-2">
    @php

    if (isset($blank)){
        $blank_variable = true;
    }
    else{
        $blank_variable = false;
    }
    @endphp

    @if(isset($finRoadmap))
        @if($finRoadmap == 1)
            @if(Route::has('admin.' . str($name)->lower()->plural()->slug() . '.show') && !in_array('show',$except))
                @can('finRoadmap_edit_2')
                <a class="btn btn-xs btn-primary tw-py-2" target="{{ $blank_variable == true ? '_blank' : '' }}"
                   href="{{ route('admin.' . str($name)->lower()->plural()->slug() . '.show', $row->id) }}">
                    <i class="fa fa-eye fa-lg" title="view"></i>
                </a>
                @endcan
            @endif

            @can('finRoadmap_pending_confirm_2')
                    <button class="btn btn-xs btn-secondary tw-py-2" id="change_status" onclick="showFinRoadmapStatusModal({{ $row->id.', '.$row->status }})">
                        <i class="fa fa-check" aria-hidden="true" title="check"></i>
                    </button>
            @endcan

        @elseif($finRoadmap == 2)
            @if(Route::has('admin.' . str($name)->lower()->plural()->slug() . '.show') && !in_array('show',$except))
                @can('finRoadmap_edit_2')
                    <a class="btn btn-xs btn-primary tw-py-2" target="{{ $blank_variable == true ? '_blank' : '' }}"
                       href="{{ route('admin.' . str($name)->lower()->plural()->slug() . '.show', $row->id) }}">
                        <i class="fa fa-eye fa-lg" title="view"></i>
                    </a>
                @endcan
            @endif

            @can('finRoadmap_confirm_convert_2')
                <button class="btn btn-xs btn-secondary tw-py-2 btn-add-case" id="change_status" title="add class">
                    Add Case
                </button>
            @endcan
        @endif
    @endif

    @if(Route::has('admin.' . str($name)->lower()->plural()->slug() . '.show') && !in_array('show',$except))
{{--        @can(str($name)->lower()->singular()->snake().'_show')--}}
{{--            <a class="btn btn-xs btn-primary tw-py-2"--}}
{{--               href="{{ route('admin.' . str($name)->lower()->plural()->slug() . '.show', $row->id) }}">--}}
{{--                {{ str($name)->lower()->singular()->snake().'_show' }}--}}
{{--                <i class="fa fa-eye fa-lg"></i>--}}
{{--            </a>--}}
{{--        @endcan--}}

        @can(str($permission_name)->lower()->singular()->snake().'_view_2')
            <a class="btn btn-xs btn-primary tw-py-2"
               href="{{ route('admin.' . str($name)->lower()->plural()->slug() . '.show', $row->id) }}">
                <i class="fa fa-eye fa-lg" title="view"></i>
            </a>
        @endcan
    @endif
    @if(Route::has('admin.' . str($name)->lower()->plural()->slug() . '.edit')  && !in_array('edit',$except))
{{--        @can(str($name)->lower()->singular()->snake().'_edit')--}}
{{--            <a class="btn btn-xs btn-info text-white"--}}
{{--               href="{{ route('admin.' . str($name)->lower()->plural()->slug() . '.edit', $row->id) }}">--}}
{{--                <i class="fa fa-edit fa-lg"></i>--}}
{{--            </a>--}}
{{--        @endcan--}}

        @can(str($permission_name)->lower()->singular()->snake().'_edit_2')
            <a class="btn btn-xs btn-info text-white"
               href="{{ route('admin.' . str($name)->lower()->plural()->slug() . '.edit', $row->id) }}">
                <i class="fa fa-edit fa-lg" title="edit"></i>
            </a>
        @endcan
    @endif
     @if(Route::has('admin.' . str($name)->lower()->plural()->slug() . '.remove') && $active && !in_array('remove',$except))
{{--        @can(str($name)->lower()->singular()->snake().'_remove')--}}
{{--            <form action="{{ route('admin.' . str($name)->lower()->plural()->slug() . '.remove', $row->id) }}"--}}
{{--                  method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" class="tw-inline-block">--}}
{{--                @csrf--}}
{{--                @method('PUT')--}}
{{--                <button class="btn btn-xs btn-danger" type="submit">--}}
{{--                    <i class="fa fa-times-circle fa-lg"></i>--}}
{{--                </button>--}}
{{--            </form>--}}
{{--        @endcan--}}

            @can(str($permission_name)->lower()->singular()->snake().'_inactive_2')
            <form action="{{ route('admin.' . str($name)->lower()->plural()->slug() . '.remove', $row->id) }}"
                  method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" class="tw-inline-block">
                @csrf
                @method('PUT')
                <button class="btn btn-xs btn-danger" type="submit">
                    <i class="fa fa-times-circle fa-lg" title="inactive"></i>
                </button>
            </form>
        @endcan
    @endif
    @if(Route::has('admin.' . str($name)->lower()->plural()->slug() . '.restore')  && !$active && !in_array('restore',$except))
{{--        @can(str($name)->lower()->singular()->snake().'_remove')--}}
{{--            <form action="{{ route('admin.' . str($name)->lower()->plural()->slug() . '.restore', $row->id) }}"--}}
{{--                  method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" class="tw-inline-block">--}}
{{--                @csrf--}}
{{--                @method('PUT')--}}
{{--                <button class="btn btn-xs btn-warning" type="submit">--}}
{{--                    <i class="fa fa-undo fa-lg"></i>--}}
{{--                </button>--}}
{{--            </form>--}}
{{--        @endcan--}}

            @can(str($permission_name)->lower()->singular()->snake().'_active_2')
            <form action="{{ route('admin.' . str($name)->lower()->plural()->slug() . '.restore', $row->id) }}"
                  method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" class="tw-inline-block">
                @csrf
                @method('PUT')
                <button class="btn btn-xs btn-warning" type="submit">
                    <i class="fa fa-undo fa-lg" title="active"></i>
                </button>
            </form>
        @endcan
    @endif

    @if(Route::has('admin.' . str($name)->lower()->plural()->slug() . '.destroy')  && !in_array('destroy',$except))
{{--        @can(str($name)->lower()->singular()->snake().'_delete')--}}
{{--            <form action="{{ route('admin.' . str($name)->lower()->plural()->slug() . '.destroy', $row->id) }}"--}}
{{--                  method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" class="tw-inline-block">--}}
{{--                @method('DELETE')--}}
{{--                @csrf--}}
{{--                <button class="btn btn-xs btn-danger" type="submit">--}}
{{--                    <i class="fa fa-trash fa-lg"></i>--}}
{{--                </button>--}}
{{--            </form>--}}
{{--        @endcan--}}

            @can(str($permission_name)->lower()->singular()->snake().'_delete_2')
            <form action="{{ route('admin.' . str($name)->lower()->plural()->slug() . '.destroy', $row->id) }}"
                  method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" class="tw-inline-block">
                @method('DELETE')
                @csrf
                <button class="btn btn-xs btn-danger" type="submit">
                    <i class="fa fa-trash fa-lg" title="delete"></i>
                </button>
            </form>
        @endcan
    @endif
</div>

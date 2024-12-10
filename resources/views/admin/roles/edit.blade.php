<x-admin.app-layout>
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('global.edit') }} {{ trans('cruds.role.title_singular') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">{{ trans('cruds.role.title_singular') }} {{ trans('global.list') }}</a></li>
        <li class="breadcrumb-item active">{{ trans('global.edit') }} {{ trans('cruds.role.title_singular') }}</li>
    </x-admin.breadcrumb>

    <div class="container-fluid">
        <div class="card" style="border-radius: 5px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <label for="" class="mt-2">
                            Role Name:
                        </label>
                    </div>

                    <div class="col-10">
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="role_name" value="{{ old('name', $role->name) }}">
                        <input type="hidden" id="role_id" value="{{ $role->id }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 box-col-4 xl-30">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">

                            <div class="col-sm-12 col-xs-12">

                                <input type="hidden" id="first_permission_id" value="{{ $first_permissionGroups_id }}">

                                <nav>
                                    <div class="main-navbar">
                                        <div id="mainnav">
                                            <ul class="nav-menu">
                                                @foreach($permissionGroupsTitle as $permissionGroupsTitle_key => $permissionGroupsTitle_item)
                                                    <li class="dropdown nav-tabs border-0">
                                                        <a class="nav-link link-nav parent_li_a {{ $permissionGroupsTitle_item->permission_groups->count() > 0 ? 'menu-title' : 'permission_trigger' }} {{ $permissionGroupsTitle_item->name == 'Dashboard Management' ? 'active' : '' }}"
                                                           id="parent_li_a-{{ $permissionGroupsTitle_item->id }}"
                                                           href="{{ $permissionGroupsTitle_item->permission_groups->count() > 0 ? 'javascript:void(0)' : 'javascript:editAjaxFunc('.$permissionGroupsTitle_item->id.' , 0)' }}">
                                                            <span>{{ $permissionGroupsTitle_item->name }}</span>
                                                        </a>

                                                        @if($permissionGroupsTitle_item->permission_groups->count() > 0)
                                                            <ul class="nav-submenu menu-content ms-4"
                                                                style="display: {{ $permissionGroupsTitle_item->name == 'Dashboard Management' ? 'block' : 'none' }};">
                                                                @foreach($permissionGroupsTitle_item->permission_groups as $permission_groups_key => $permission_groups_item)
                                                                    <li><a class="nav-link child_li_a {{ $permission_groups_key == 0 ? 'active' : 'none' }} permission_trigger" id="child_li_a-{{ $permission_groups_item->id }}" href="javascript:editAjaxFunc({{ $permission_groups_item->id }} , 1)">{{ $permission_groups_item->name }}</a></li>

                                                                    <input type="hidden" class="permission_trigger_id"      value="{{ $permission_groups_item->id }}">
                                                                    <input type="hidden" class="permission_trigger_type"    value="1">
                                                                @endforeach
                                                            </ul>

                                                        @else
                                                            <input type="hidden" class="permission_trigger_id"      value="{{ $permissionGroupsTitle_item->id }}">
                                                            <input type="hidden" class="permission_trigger_type"    value="0">
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </nav>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-md-12 box-col-8 xl-70">
                <div class="card">
                    <div class="ps-0">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="pills-created" role="tabpanel" aria-labelledby="pills-created-tab">
                                <div class="card mb-0">
                                    <table class="table">
                                        <tbody id="permission_action_tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(function() {
                $('.parentRole').on('change', function () {
                    let checkboxes = $(this).parent().parent().siblings('ul').children('li').children('label').children('input')
                    if(this.checked) {
                        checkboxes.each(function (i, item) {
                            $(item).prop('checked', true)
                        })
                    } else {
                        checkboxes.each(function (i, item) {
                            $(item).prop('checked', false)
                        })
                    }
                });
            });

            $( document ).ready(function() {
                var first_id = $('#first_permission_id').val();
                editAjaxFunc(first_id, 1);
            });

            function permissionChangeFunc(permission_id, type, permission_type){
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.roles.updateAjax', $role) }}",
                    data: {
                        id                  : permission_id,
                        type                : type,
                        permission_type     : permission_type,
                    },
                    success: function (result) {
                        $("#switch_group-"+permission_id).html(result);

                        // if it is all
                        if (permission_type == 4){
                            var positive_permission_id = permission_id + 1;
                            var negative_permission_id = permission_id - 1;

                            if ($("#all_permission-"+permission_id).is(":checked")){
                                $("#personal_permission-"+positive_permission_id).prop( "disabled", true );
                                $("#personal_permission-"+negative_permission_id).prop( "disabled", true );

                                console.log('personal has been disabled');
                            }
                            else {
                                $("#personal_permission-"+positive_permission_id).prop( "disabled", false );
                                $("#personal_permission-"+negative_permission_id).prop( "disabled", false );

                                console.log('personal can use');
                            }
                        }

                        // if it is personal
                        if (permission_type == 5){
                            var positive_permission_id = permission_id + 1;
                            var negative_permission_id = permission_id - 1;

                            if ($("#personal_permission-"+permission_id).is(":checked")){
                                $("#all_permission-"+positive_permission_id).prop( "disabled", true );
                                $("#all_permission-"+negative_permission_id).prop( "disabled", true );

                                console.log('all has been disabled');
                            }
                            else {
                                $("#all_permission-"+positive_permission_id).prop( "disabled", false );
                                $("#all_permission-"+negative_permission_id).prop( "disabled", false );

                                console.log('all can use le');
                            }
                        }
                    }
                });
            }

            function editAjaxFunc(id, type){
                //layout changer
                $('.parent_li_a').removeClass('active');
                $('.child_li_a').removeClass('active');

                $('#child_li_a-'+id).addClass('active');
                $('#child_li_a-'+id).parent().parent().parent().children('a').addClass('active');

                // main func
                var role_id = $("#role_id").val();

                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.roles.editAjax', $role) }}",
                    data: {
                        id      : id,
                        type    : type,
                        role_id : role_id,
                    },
                    success: function (result) {
                        var obj = jQuery.parseJSON( result );

                        $('#permission_action_tbody').html( obj.permission_details_html );

                        $.each( obj.permission_id_arr, function( key, value ) {
                            var permission_id   = value;
                            var permission_type = obj.permission_type_arr[key];

                            // if it is all
                            if (permission_type == 4){
                                var positive_permission_id = permission_id + 1;
                                var negative_permission_id = permission_id - 1;

                                if ($("#all_permission-"+permission_id).is(":checked")){
                                    $("#personal_permission-"+positive_permission_id).prop( "disabled", true );
                                    // $("#personal_permission-"+negative_permission_id).prop( "disabled", true );
                                }
                                else {
                                    $("#personal_permission-"+positive_permission_id).prop( "disabled", false );
                                    // $("#personal_permission-"+negative_permission_id).prop( "disabled", false );
                                }
                            }

                            // if it is personal
                            if (permission_type == 5){
                                var positive_permission_id = permission_id + 1;
                                var negative_permission_id = permission_id - 1;

                                if ($("#personal_permission-"+permission_id).is(":checked")){
                                    // $("#all_permission-"+positive_permission_id).prop( "disabled", true );
                                    $("#all_permission-"+negative_permission_id).prop( "disabled", true );
                                }
                                else {
                                    // $("#all_permission-"+positive_permission_id).prop( "disabled", false );
                                    $("#all_permission-"+negative_permission_id).prop( "disabled", false );
                                }
                            }
                        });

                    }
                });
            }

            $('#role_name').keyup(function (){
                var permission_id   = 0;
                var type            = 2;
                var role_name       = $(this).val();

                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.roles.updateAjax', $role) }}",
                    data: {
                        id          : permission_id,
                        type        : type,
                        role_name   : role_name,
                    },
                    success: function (result) {
                        $("#switch_group-"+permission_id).html(result);
                    }
                });
            })

        </script>
    @endpush
</x-admin.app-layout>


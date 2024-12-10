<header class="main-nav">
    <div class="sidebar-user text-center">
        <a class="setting-primary" href="{{ route("admin.profile.edit",Auth::user()->id) }}"><i data-feather="settings"></i></a>
        @if (Auth::user()->avatar)
            <img class="img-90 rounded-circle" src="{{ Auth::user()->avatar->getUrl('thumb') }}"
                 alt="{{ Auth::user()->name }}"/>
        @else
            <img class="img-90 rounded-circle" src="{{asset('assets/images/dashboard/1.png')}}"
                 alt="{{ Auth::user()->name }}"/>
        @endif
        <div class="badge-bottom"><span
                class="badge badge-primary">{{ Auth::user()?->roles?->first()?->name ?? '-' }}</span>
        </div>
        <a href="#">
            <h6 class="f-14 f-w-600 mt-3" style="filter: blur(4px) !important;">{{ Auth::user()->name ?? '-' }}</h6>
        </a>
    </div>
    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title link-nav {{ routeActive('admin.index') }}" href="{{ route('admin.index') }}">
                            <i data-feather="home"></i><span>{{ trans('global.dashboard') }}</span>
                        </a>
                    </li>

                    @canany(['call_all_pending_index_2', 'call_personal_pending_index_2', 'call_all_all_index_2', 'call_personal_all_index_2', 'call_master_index_2', 'call_remark_history_index_2', 'call_pending_index_2', 'call_all_index_2'])
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ routeActive('admin.master-call-lists.*') }} {{ routeActive('admin.salesman-calls.*') }}" href="javascript:void(0)">
                            <i data-feather="phone-call"></i><span>Lead Centre</span>
                        </a>
                        <ul class="nav-submenu menu-content" style="display: {{ routeActive(['admin.master-call-lists.*', 'admin.salesman-calls.*'], 2) }};">
                            @can('call_master_index_2')
                            <li>
                                <a href="{{ route('admin.master-call-lists.index') }}" class="{{ routeActive('admin.master-call-lists.index') }}">
                                    Master Call List
                                </a>
                            </li>
                            @endcan
                            @can('call_remark_history_index_2')
                                <li>
                                    <a href="{{ route('admin.master-call-lists.remark-history') }}" class="{{ routeActive('admin.master-call-lists.remark-history') }}">
                                        Call Remark History
                                    </a>
                                </li>
                            @endcan
                            @canany(['call_all_pending_index_2', 'call_personal_pending_index_2'])
                            <li>
                                <a href="{{ route('admin.salesman-calls.index') }}" class="{{ routeActive('admin.salesman-calls.index') }}">
                                    Pending Call
                                    <span class="badge badge-danger float-right">{{ pendingCallCount() }}</span>
                                </a>
                            </li>
                            @endcanany
                            @canany(['call_all_all_index_2', 'call_personal_all_index_2'])
                            <li>
                                <a href="{{ route('admin.salesman-calls.all-call.index') }}" class="{{ routeActive('admin.salesman-calls.all-call.index') }}">
                                    All Call
                                    <span class="badge badge-danger float-right">{{ allCallCount() }}</span>
                                </a>
                            </li>
                            @endcanany
                        </ul>
                    </li>
                    @endcanany

                    @canany(['user_index_2', 'team_index_2', 'management_index_2'])
                        <li class="dropdown">
                            <a class="nav-link menu-title {{ routeActive('admin.users.*') }} {{ routeActive('admin.teams.*') }} {{ routeActive('admin.managements.*') }}" href="javascript:void(0)">
                                <i data-feather="user"></i><span>{{ trans('cruds.userManagement.title') }}</span>
                            </a>
                            <ul class="nav-submenu menu-content" style="display: {{ routeActive(['admin.users.*', 'admin.teams.*','admin.managements.*'], 2) }};">
                                @can('user_index_2')
                                    <li><a href="{{route('admin.users.index')}}" class="{{routeActive('admin.users.*')}}">{{ trans('cruds.user.title') }}</a></li>
                                @endcan
                                @can('team_index_2')
                                    <li><a href="{{route('admin.teams.index')}}" class="{{routeActive('admin.teams.*')}}">{{ trans('cruds.team.title') }}</a></li>
                                @endcan
                                @can('management_index_2')
                                    <li><a href="{{route('admin.management.index')}}" class="{{routeActive('admin.management.*')}}">Managements</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany

                    @canany(['role_index_2', 'industry_type_index_2', 'application_type_index_2', 'request_type_index_2', 'credit_check_type_index_2', 'platform_index_2'])
                        <li class="dropdown">
                            <a class="nav-link menu-title {{ routeActive('admin.permissions.*') }} {{ routeActive('admin.roles.*') }} {{ routeActive('admin.audit-logs.*') }} {{ routeActive('admin.industry-types.*') }} {{ routeActive('admin.application-types.*') }}
                                {{ routeActive('admin.request-types.*') }} {{ routeActive('admin.case-credit-check-types.*') }} {{ routeActive('admin.banks.*') }} {{ routeActive('admin.commission-settings.*') }}" href="javascript:void(0)">
                                <i data-feather="settings"></i><span>{{ trans('cruds.setting.title') }}</span>
                            </a>
                            <ul class="nav-submenu menu-content" style="
                                display: {{ routeActive(['admin.permissions.*', 'admin.roles.*', 'admin.audit-logs.*','admin.industry-types.*','admin.application-types.*','admin.request-types.*','admin.case-credit-check-types.*','admin.banks.*', 'admin.commission-settings.*'], 2) }};">
                                @can('role_index_2')
                                    <li><a href="{{ route('admin.roles.index') }}" class="{{ routeActive('admin.roles.*') }}">{{ trans('cruds.role_permission.title') }}</a></li>
                                @endcan
                            </ul>
                        </li>s
                    @endcanany
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>

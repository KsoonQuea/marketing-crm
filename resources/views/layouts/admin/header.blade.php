<div class="page-main-header">
    <div class="main-header-right row m-0">
        <div class="main-header-left tw-blur-2xl">
            <div class="logo-wrapper tw-blur-2xl">
                <a href="{{ route('admin.index') }}">
                    <div class="tw-flex tw-blur-2xl">
                        <h4 class="tw-text-center">CRM</h4>
                    </div>
                </a>
            </div>
            <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center"
                                           id="sidebar-toggle"> </i></div>
        </div>

        <div class="nav-right col pull-right right-menu p-0">
            <ul class="nav-menus">
                {{ auth()->user()->unreadNotificationss }}
                <li class="onhover-dropdown p-0 noti">
                    <div id="noti_box" class="tw-text-right">
                        <button onclick="notiClick()" id="notiButton" class="btn-color tw-border-0 tw-bg-transparent tw-text-right">
                            <div class="notification-box">
                                <i data-feather="bell"></i>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="dot-animated"></span>
                                @endif
                            </div>
                        </button>
                        <ul class="notification-dropdown">
                        <dialog id="notiOnclick" class="tw-border-0 tw-bg-zinc-50 tw-mt-2">
                            <li class="noti-title">
                                <p class="f-w-700 mb-0 tw-pr-2">You have {{ auth()->user()->unreadNotifications->count() }} Notifications
                                    <span class="pull-right badge badge-primary badge-pill tw-ml-3 tw-bg-red-800 tw-text-white">{{ auth()->user()->unreadNotifications->count() }}</span>
                                </p>
                            </li>
                            @if(auth()->user()->unreadNotifications->count() > 5)
                                @foreach(auth()->user()->unreadNotifications->take(5) as $notification)
                                    @php
                                        $status = 'New Pending Case - ';
                                            if (isset($notification->data['case_type'])){
                                                switch ($notification->data['case_type']){
                                                    case 0:
                                                        $status = 'New Pending Case - ';
                                                        break;
                                                    case 1:
                                                        $status = 'New Approved Case - ';
                                                        break;
                                                    case 2:
                                                        $status = 'New Rejected Case - ';
                                                        break;
                                                    case 3:
                                                        $status = 'New Reworked Case - ';
                                                        break;
                                                    case 4:
                                                        $status = 'New Resubmitted Case - ';
                                                        break;
                                                };
                                            }
                                    @endphp

                                    <li class="noti-primary noti-details">
                                        <a href="{{ route('admin.case-lists.show-credit', ['caseList' => $notification->data['case_id'], 'notification' => $notification]) }}">
                                            <div class="row">
                                                <div class="column-left">
                                                    <span class="notification-bg bg-blue tw-rounded-full noti-icon"><i data-feather="file-text"></i></span>
                                                </div>
                                                <div class="column-right">
                                                    <p class="tw-text-xs noti-detail">{{ $status }} {{ $notification->data['case_code'] }}</p>
                                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                                <li class="noti-primary noti-title">
                                    <a href="{{ route('admin.notification.index') }}" class="noti-text">
                                        <p class="f-w-500 mb-0 p-0 m-0 text-center">
                                            Show More...
                                        </p>
                                    </a>
                                </li>
                            @else
                                @foreach(auth()->user()->unreadNotifications as $notification)
                                    @php
                                        $status = 'New Pending Case - ';
                                        if (isset($notification->data['case_type'])){
                                            switch ($notification->data['case_type']){
                                                case 0:
                                                    $status = 'New Pending Case - ';
                                                    break;
                                                case 1:
                                                    $status = 'New Approved Case - ';
                                                    break;
                                                case 2:
                                                    $status = 'New Rejected Case - ';
                                                    break;
                                                case 3:
                                                    $status = 'New Reworked Case - ';
                                                    break;
                                                case 4:
                                                    $status = 'New Resubmitted Case - ';
                                                    break;
                                                };
                                            }
                                    @endphp

                                    @if(isset($notification->data['case_type']))
                                        <li class="noti-success noti-details">
                                            <a href="{{ route('admin.case-lists.show-credit', ['caseList' => $notification->data['case_id'], 'notification' => $notification]) }}">
                                                <div class="row">
                                                <div class="column-left">
                                                    <span class="notification-bg bg-blue tw-rounded-full noti-icon"><i data-feather="file-text"></i></span>
                                                </div>
                                                <div class="column-right">
                                                    <p class="tw-text-xs noti-detail">{{ $status }} {{ $notification->data['case_code'] }}</p>
                                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                            </dialog>
                        </ul>
                    </div>
                </li>

                <li class="onhover-dropdown p-0">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button href="{{ route('admin.logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="btn btn-primary-light" type="button"><i data-feather="log-out"></i>Log out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
    </div>
</div>

<script>
    var i = document.getElementById("notiOnclick");

    function notiClick() {
        var i = document.getElementById('notiOnclick');
        var displaySetting = i.style.display;
        var notiButton = document.getElementById('notiButton');

        if (displaySetting == 'block') {
        i.style.display = 'none';
        }
        else {
        i.style.display = 'block';
        }
    }
</script>

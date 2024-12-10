<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPermissionRequest;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\CaseList;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
//            $query = User::with(['roles', 'notifications']);
            $query = auth()->user()->unreadNotifications;


            // search inputs
            if(isset($request->search_status) && $request->search_status != 'all'){
                $query->where('status',$request->search_status);
            }
            $table = Datatables::of($query);
            $table->addColumn('case_code', function ($row){
                return $row->data['case_code'];
            });

            $table->addColumn('case_status', function ($row){

                $status_class =  CaseList::STATUS_CLASSES[$row->data['case_type'] ?? 0];

                switch ($row->data['case_type']){
                    case 0:
                        $status_name = 'Pending';
                        break;
                    case 1:
                        $status_name = 'Approved';
                        break;
                    case 2:
                        $status_name = 'Rejected';
                        break;
                    case 3:
                        $status_name = 'Reworked';
                        break;
                    case 4:
                        $status_name = 'Resubmitted';
                        break;
                };

                return '<b class="text-' . $status_class . '">' . $status_name . '</b>';
            });

            $table->addColumn('title', function ($row){

                switch ($row->data['case_type']){
                    case 0:
                        $title = 'New Pending Case - '.$row->data['case_code'];
                        break;
                    case 1:
                        $title = 'New Approved Case - '.$row->data['case_code'];
                        break;
                    case 2:
                        $title = 'New Rejected Case - '.$row->data['case_code'];
                        break;
                    case 3:
                        $title = 'New Reworked Case - '.$row->data['case_code'];
                        break;
                    case 4:
                        $title = 'New Resubmitted Case - '.$row->data['case_code'];
                        break;
                };

                return $title;
            });

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name = 'case';
                $permission_name = 'user';
                $except = [''];
                $active = NULL;
//                if ($row->hasRole('Admin')) {
//                    $except = ['show', 'remove', 'destroy'];
//                }

                $view_more = '<a class="btn btn-xs btn-primary tw-py-2"
                                href="'.route('admin.case-lists.show-credit', ['caseList' => $row->data['case_id'], 'notification' => $row]).'">
                                <i class="fa fa-eye fa-lg"></i>
                              </a>';

                return $view_more;
            });

            $table->rawColumns(['actions','placeholder','','case_status']);

            return $table->make(true);
        }

        return view('admin.notification.index');
    }

    public function refreshNotification()
    {
        $dot_html       = auth()->user()->unreadNotifications->count() > 0 ? '<span class="dot-animated" ></span >' : '';
        $count_number   = auth()->user()->unreadNotifications->count();
        $noti_list      = '';

        $status = 'New Pending Case - ';

        if ($count_number > 5) {
            foreach (auth()->user()->unreadNotifications->take(5) as $notification) {
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

                $noti_list .=
                    '<li class="noti-success noti-details">
                                            <a href="' . route('admin.case-lists.show', ['case_list' => $notification->data['case_id'], 'notification' => $notification]) . '">
                                                <div class="row">
                                                <div class="column-left">
                                                    <span class="notification-bg bg-blue tw-rounded-full noti-icon"><i data-feather="file-text"></i></span>
                                                </div>
                                                <div class="column-right">
                                                    <p class="tw-text-xs noti-detail">' . $status.$notification->data["case_code"] . '</p>
                                                    <span>' . $notification->created_at->diffForHumans() . '</span>
                                                </div>
                                            </div>
                                            </a>
                                        </li>';
            }


            $noti_list .=
                '

                              <li class="noti-primary noti-title">
                                    <a href="' . route('admin.notification.index') . '" class="noti-text">
                                        <p class="f-w-500 mb-0 p-0 m-0 text-center">
                                            Show More...
                                        </p>
                                    </a>
                                </li>';
        }
        else{
            foreach (auth()->user()->unreadNotifications as $notification) {
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

                $noti_list .=
                '<li class="noti-success noti-details">
                                            <a href="' . route('admin.case-lists.show', ['case_list' => $notification->data['case_id'], 'notification' => $notification]) . '">
                                                <div class="row">
                                                <div class="column-left">
                                                    <span class="notification-bg bg-blue tw-rounded-full noti-icon"><i data-feather="file-text"></i></span>
                                                </div>
                                                <div class="column-right">
                                                    <p class="tw-text-xs noti-detail">' . $status.$notification->data["case_code"] . '</p>
                                                    <span>' . $notification->created_at->diffForHumans() . '</span>
                                                </div>
                                            </div>
                                            </a>
                                        </li>'
                ;
            }
        }

        $newNoti =
            '<button onclick="notiClick()" id="notiButton" class="btn-color tw-border-0 tw-bg-transparent tw-text-right">
                            <div class="notification-box">
                                <i data-feather="bell"></i>
                                '.$dot_html.'
                            </div>
                        </button>
                        <ul class="notification-dropdown">
                        <dialog id="notiOnclick" class="tw-border-0 tw-bg-zinc-50 tw-mt-2">
                            <li class="noti-title">
                                <p class="f-w-700 mb-0 tw-pr-2">You have '.$count_number.' Notifications
                                    <span class="pull-right badge badge-primary badge-pill tw-ml-3 tw-bg-red-800 tw-text-white">'.$count_number.'</span>
                                </p>
                            </li>
                            '.$noti_list.'
                            </dialog>
                        </ul>';

        return $newNoti;
    }
}

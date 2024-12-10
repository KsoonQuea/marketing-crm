@extends('layouts.clean-app')
<style>
    /* table */
    .remark-table th,td{
        text-align:left;
        font-size:11px;
        padding:0.25em 0.5em!important;
    }
    .thead-bg{
        background:#B2E7FF;
    }
    .remark-table p{
        padding:0;
        line-height: 0.5;
    }
    /* status */
    .text-green { color: #55ab59; }
    .text-muted { color: #6c757d; }
    .text-warning { color: #ffc107; }
    .text-danger { color:#dc3545; }
    .text-red-box{ background:red; color:#ffffff;padding:0.15em 0.35em; }
</style>
@section('content')
    <div class="print-bg">
        <h5 class="tab-pane-header">Call Remark History</h5>
        <div class="table-responsive">
            <table class="remark-table">
                <thead class="thead-bg">
                    <tr>
                        <th width="85">Created At</th>
                        <th width="150">Company Name</th>
                        <th width="100">Response</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($caseCallLog as $row)
                    <tr>
                        <td>{{ $row->datetime ?? '-' }}</td>
                        <td>{{ $row->list->company_name ?? '' }}</td>
                        <td>
                            @php
                                $status_name = \App\Models\MasterCallUserTask::RESPONSE_STATUS_SELECT[$row->response_status];
                                $status_class = \App\Models\MasterCallUserTask::RESPONSE_STATUS_CLASSES[$row->response_status];
                            @endphp
                            <b class="text-{{$status_class}}">{{ $status_name }}</b>
                        </td>
                        <td>{!! $row->details ?? '' !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

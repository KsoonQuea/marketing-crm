{{--@extends('layouts.admin.billing')--}}
{{--@section('content')--}}
{{--    <style>--}}
{{--        *{--}}
{{--            padding: 2px;--}}
{{--            margin: 2px;--}}
{{--        }--}}

{{--        /* Sales Report */--}}
{{--        .sc-color{--}}
{{--            background-color: rgb(255,242,191) ;--}}
{{--        }--}}
{{--        .sales-company{--}}
{{--            text-align: center;--}}
{{--            vertical-align: middle;--}}
{{--        }--}}

{{--        .scom1-color{--}}
{{--            background-color: rgb(255,230,153) ;--}}
{{--        }--}}

{{--        .sh-color{--}}
{{--            background-color: rgb(221,235,247) ;--}}
{{--        }--}}

{{--        .sa-color{--}}
{{--            background-color: rgb(202,223,242) ;--}}
{{--        }--}}

{{--        .scom2-color{--}}
{{--            background-color: rgb(252,228,214) ;--}}
{{--        }--}}

{{--        .bg-light{--}}
{{--            background-color: rgb(230,237,239);--}}
{{--        }--}}

{{--        .sales-haven{--}}
{{--            background-color: rgb(226,239,218); ;--}}
{{--            color: red ;--}}
{{--            font-weight: bold ;--}}
{{--        }--}}
{{--        /* End Sales Report */--}}

{{--        /* Collection Report */--}}
{{--        .collect-profoma{--}}
{{--            background-color: #ddebf7;--}}
{{--        }--}}

{{--        .collect-invoice{--}}
{{--            background-color: #e2efda ;--}}
{{--        }--}}

{{--        .collect-payment{--}}
{{--            background-color: #fce4d6 ;--}}
{{--        }--}}

{{--        .collect-total{--}}
{{--            border-top: 2px solid ;--}}
{{--            border-bottom: 4px double ;--}}
{{--            text-align: center;--}}
{{--        }--}}
{{--        /* End Collection Report */--}}

{{--        /* Commission Report */--}}
{{--        .com-color{--}}
{{--            background-color: #ebf1de ;--}}
{{--        }--}}
{{--        /* End Commission Report */--}}

{{--        table th{--}}
{{--            background-color: #c4def1;--}}
{{--        }--}}
{{--        table td{--}}
{{--        }--}}

{{--        .fw-bold {--}}
{{--            font-weight: bold !important;--}}
{{--        }--}}
{{--    </style>--}}

{{--    <table>--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>Nexus Capital Sdn Bhd</th>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <th>{!! $title.' - '.$content_title !!}</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--    </table>--}}

{{--    <h4 style="margin-left: 25px">Nexus Capital Sdn Bhd</h4>--}}
{{--    <h4 style="margin-left: 25px">{!! $title.' - '.$content_title !!}</h4>--}}

{{--    {!! $html !!}--}}
{{--@endsection--}}


{{--<style>--}}
{{--    *{--}}
{{--        padding: 2px;--}}
{{--        margin: 2px;--}}
{{--    }--}}

{{--    /* Sales Report */--}}
{{--    .sc-color{--}}
{{--        background-color: rgb(255,242,191) ;--}}
{{--    }--}}
{{--    .sales-company{--}}
{{--        text-align: center;--}}
{{--        vertical-align: middle;--}}
{{--    }--}}

{{--    .scom1-color{--}}
{{--        background-color: rgb(255,230,153) ;--}}
{{--    }--}}

{{--    .sh-color{--}}
{{--        background-color: rgb(221,235,247) ;--}}
{{--    }--}}

{{--    .sa-color{--}}
{{--        background-color: rgb(202,223,242) ;--}}
{{--    }--}}

{{--    .scom2-color{--}}
{{--        background-color: rgb(252,228,214) ;--}}
{{--    }--}}

{{--    .bg-light{--}}
{{--        background-color: rgb(230,237,239);--}}
{{--    }--}}

{{--    .sales-haven{--}}
{{--        background-color: rgb(226,239,218); ;--}}
{{--        color: red ;--}}
{{--        font-weight: bold ;--}}
{{--    }--}}
{{--    /* End Sales Report */--}}

{{--    /* Collection Report */--}}
{{--    .collect-profoma{--}}
{{--        background-color: #ddebf7;--}}
{{--    }--}}

{{--    .collect-invoice{--}}
{{--        background-color: #e2efda ;--}}
{{--    }--}}

{{--    .collect-payment{--}}
{{--        background-color: #fce4d6 ;--}}
{{--    }--}}

{{--    .collect-total{--}}
{{--        border-top: 2px solid ;--}}
{{--        border-bottom: 4px double ;--}}
{{--        text-align: center;--}}
{{--    }--}}
{{--    /* End Collection Report */--}}

{{--    /* Commission Report */--}}
{{--    .com-color{--}}
{{--        background-color: #ebf1de ;--}}
{{--    }--}}
{{--    /* End Commission Report */--}}

{{--    table th{--}}
{{--        background-color: #c4def1;--}}
{{--    }--}}
{{--    table td{--}}
{{--    }--}}

{{--    .fw-bold {--}}
{{--        font-weight: bold !important;--}}
{{--    }--}}
{{--</style>--}}

{{--<table>--}}
{{--    <thead>--}}
{{--    <tr>--}}
{{--        <th>Nexus Capital Sdn Bhd</th>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <th>{!! $title.' - '.$content_title !!}</th>--}}
{{--    </tr>--}}
{{--    </thead>--}}
{{--</table>--}}

<h4 style="margin-left: 25px; background-color: red; color: red;">Nexus Capital Sdn Bhd</h4>
<h4 style="margin-left: 25px">{!! $title.' - '.$content_title !!}</h4>

<br>

{!! $html !!}

@include('admin.report.partials.reportJs')

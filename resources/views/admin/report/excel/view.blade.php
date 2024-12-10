@extends('layouts.admin.billing')
@section('content')
    <style>
        *{
            padding: 2px;
            margin: 2px;
        }

        /* Sales Report */
        .sc-color{
            background-color: #ffe0666b !important;
        }
        .sales-company{
            text-align: center;
            vertical-align: middle;
        }

        .scom1-color{
            background-color: #ffe699 !important;
        }

        .sh-color{
            background-color: #ddebf7 !important;
        }

        .sa-color{
            background-color: #9dc4e68c !important;
        }

        .scom2-color{
            background-color: #fce4d6 !important;
        }

        .sales-haven{
            background-color: #e2efda !important;
            color: red !important;
        }
        /* End Sales Report */

        /* Collection Report */
        .collect-profoma{
            background-color: #ddebf7 !important;
        }

        .collect-invoice{
            background-color: #e2efda !important;
        }

        .collect-payment{
            background-color: #fce4d6 !important;
        }

        .collect-total{
            border-top: 2px solid !important;
            border-bottom: 4px double !important;
            text-align: center;
        }
        /* End Collection Report */

        /* Commission Report */
        .com-color{
            background-color: #ebf1de !important;
        }
        /* End Commission Report */

        table{
            text-align: center;
        }

        table th{
            margin: 0;
            border: none;
            background-color: #c4def1;
            width: {{ $td_width }};
            font-size: 10px;
        }
        table td{
            border: none;
            margin: 0;
            background-color: #f8f8f8;
            width: {{ $td_width }};
            font-size: 10px;
        }


        .removeable{
            display: none;
            visibility: hidden;
            width: 0px;
        }

        .conclusion{
            text-align: right;
            background-color: white;
            font-size: 12px;
            margin-left: 500px;
        }

        .non-color-bg-table th{
            margin: 0;
            border: none;
            background-color: white !important;
            width: {{ $td_width }};
            font-size: 10px;
        }

        .non-color-bg-table td{
            border: none;
            margin: 0;
            background-color: white !important;
            width: {{ $td_width }};
            font-size: 10px;
        }

        tbody tr:nth-child(even) {background: #CCC}
        tbody tr:nth-child(odd) {background: #FFF}
    </style>
    <h4 style="margin-left: 25px">Nexus Capital Sdn Bhd</h4>
    <h4 style="margin-left: 25px">{!! $title.' - '.$content_title !!}</h4>

    {!! $html !!}
@endsection

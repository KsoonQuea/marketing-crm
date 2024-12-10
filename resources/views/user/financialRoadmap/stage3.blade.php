<x-user.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
        <style>
            /* old */
            .square {
                height: 15px;
                width: 15px;
                background-color: #b2e7ff;
                border-radius: 4px;
            }
            .square:hover {
                background-color: #2198c3;
            }
            * {
                box-sizing: border-box;
            }
            .fg--search {
                background: white;
                position: relative;
                width: 200px;
            }
            .fg--search input {
                width: 100%;
                padding: 2px;
                border-radius: 10px;
            }
            .fg--search button {
                background: transparent;
                border: none;
                cursor: pointer;
                display: inline-block;
                font-size: 20px;
                position: absolute;
                top: 0;
                right: 0;
                z-index: 2;
            }
            .fg--search input:focus+button .fa-search {
                color: blue;
            }
            .text-symbol{
                font-size:0.5em;
                color:#5d5d5d;
            }/* dashboard card css */
            .text-value{ color:#2198c3; }
            .vertical-middle{ vertical-align: middle!important; }
            .chart-content-font{ font-weight: 400; font-size:0.75em; text-align: right; }
            .chart-content-font .value{ font-size:1.2em; }
            .media-body span{ font-size:0.9em; }
            /* new */
            .card-media-title{ font-size:0.8em!important; }
            .card-value{ font-size:0.7em!important; }
            .counter-title{ font-size:0.6em!important; }
            .counter{ font-weight: 600!important; }

            .input_bg{
                background-color: #E5F9FC !important;
            }

            .card-radius{
                border-radius: 5px !important;
            }

            .primary_font_color{
                color: #05C3DD;
            }

            .secondary_font_color{
                color: #21B9DB;
            }

            .third_font_color{
                color: #A5A5A5;
            }

            .primary_bg_color{
                background-color: #05C3DD;
                color: white;
            }

            .secondary_bg_color{
                background-color: #037699;
                color: white;
            }

            .third_bg_color{
                background-color: #002855;
                color: white;
            }

            .four_bg_color{
                background-color: #21B9DB !important;
                color: white !important;
            }
        </style>
    @endpush

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12 col-xl-3">
                <h4 class="primary_font_color"><b>Financial Roadmap</b></h4>
                <p class="third_font_color">Basic Information</p>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-radius">

                            <div class="card-body">
                                <form class="theme-form">
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Company Name</label>
                                        <input class="form-control btn-pill input_bg" id="exampleInputEmail1" type="text">
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Business Industry</label>
                                        <input class="form-control btn-pill input_bg" id="" type="text">
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Contact Person</label>
                                        <input class="form-control btn-pill input_bg" id="" type="text">
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Contact Number</label>
                                        <input class="form-control btn-pill input_bg" id="" type="text">
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Email</label>
                                        <input class="form-control btn-pill input_bg" id="" type="text">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-9">
                <div class="row">
                    <div class="col-3">
                        <h4 class="secondary_font_color">Financial Year</h4>
                        <p class="third_font_color">Please key in the data below</p>
                    </div>

                    <div class="col-9">
                        <div class="row">
                            <div class="col-3"></div>

                            <div class="col-3">
                                <h5 class="secondary_font_color">2019</h5>
                                <p class="secondary_font_color">(RM)</p>
                            </div>
                            <div class="col-3">
                                <h5 class="secondary_font_color">2020</h5>
                                <p class="secondary_font_color">(RM)</p>
                            </div>
                            <div class="col-3">
                                <h5 class="secondary_font_color">2021</h5>
                                <p class="secondary_font_color">(RM)</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-radius">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-3 primary_bg_color card-radius m-0 pt-3 ml-3">
                                        <h6>STATEMENT OF COMPREHENSIVE INCOME</h6>
                                        <hr width="20%" style="height: 2px">
                                        <small>PROFIT & LOSS STATEMENT</small>
                                    </div>
                                    <div class="col-9 p-l-0">
                                        <table class="table form-table-two ml-0">
                                            <tbody class="">
                                            @foreach($comprehensive_arr as $comprehensive_arr_key => $comprehensive_arr_item)
                                                <tr class="{{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : '' }} m-0">
                                                    <td class="{{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : '' }}">{{ $comprehensive_arr_item }}</td>
                                                    <td class="{{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : 'input_bg' }}">
                                                        <input type="text" class="number-input border-0 {{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : 'input_bg' }}" name="fye_non_current_asset1" value="{{ number_format(($fye_1->non_current_asset ?? 0)) }}" {{ $comprehensive_arr_item == 'Gross Profit' ? 'readonly' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="number-input border-0 {{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : '' }}" name="fye_non_current_asset2" value="{{ number_format(($fye_2->non_current_asset ?? 0)) }}" {{ $comprehensive_arr_item == 'Gross Profit' ? 'readonly' : '' }}>
                                                    </td>
                                                    <td class="{{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : 'input_bg' }}">
                                                        <input type="text" class="number-input border-0 {{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : 'input_bg' }}" name="fye_non_current_asset3" value="{{ number_format(($fye_3->non_current_asset ?? 0)) }}" {{ $comprehensive_arr_item == 'Gross Profit' ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="card card-radius">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-3 secondary_bg_color card-radius m-0 pt-3 ml-3">
                                        <h6>STATEMENT OF FINANCIAL POSITION</h6>
                                        <hr width="20%" style="height: 2px">
                                        <small>BALANCE SHEET STATEMENT</small>
                                    </div>
                                    <div class="col-9 p-l-0">
                                        <table class="table form-table-two">
                                            <tbody>
                                            @foreach($financial_position_arr as $financial_position_arr_key => $financial_position_arr_item)
                                                <tr class="{{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : '' }}">
                                                    <td class="{{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : '' }}">{{ $financial_position_arr_item }}</td>
                                                    <td class="{{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : 'input_bg' }}">
                                                        <input type="text" class="number-input border-0 {{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : 'input_bg' }}" name="fye_non_current_asset1" value="{{ number_format(($fye_1->non_current_asset ?? 0)) }}" {{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'readonly' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="number-input border-0 {{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : '' }}" name="fye_non_current_asset2" value="{{ number_format(($fye_2->non_current_asset ?? 0)) }}" {{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'readonly' : '' }}>
                                                    </td>
                                                    <td class="{{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : 'input_bg' }}">
                                                        <input type="text" class="number-input border-0 {{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : 'input_bg' }}" name="fye_non_current_asset3" value="{{ number_format(($fye_3->non_current_asset ?? 0)) }}" {{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="card card-radius">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-3 third_bg_color card-radius m-0 pt-3 ml-3" >
                                        <h6>STATEMENT OF CASH FLOW</h6>
                                    </div>
                                    <div class="col-9 p-l-0">
                                        <table class="table form-table-two">
                                            <tbody>
                                            @foreach($cash_flow_arr as $cash_flow_arr_key => $cash_flow_arr_item)
                                                <tr>
                                                    <td>{{ $cash_flow_arr_item }}</td>
                                                    <td class="input_bg"><input type="text" class="number-input border-0 input_bg" name="fye_non_current_asset1" value="{{ number_format(($fye_1->non_current_asset ?? 0)) }}"></td>
                                                    <td><input type="text" class="number-input border-0" name="fye_non_current_asset2" value="{{ number_format(($fye_2->non_current_asset ?? 0)) }}"></td>
                                                    <td class="input_bg"><input type="text" class="number-input border-0 input_bg" name="fye_non_current_asset3" value="{{ number_format(($fye_3->non_current_asset ?? 0)) }}"></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mb-4 mt-3 text-end">
                    <button type="submit" class="btn btn-primary-light">Submit</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
        <script>
            // call log functions
            function callAction(this_id){
                open_called_modal(this_id);
            }
            // modal function
            function open_called_modal(id)
            {
                $('#case-log-history').html("");
                var _token = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': _token } });
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.salesman-calls.case-log-history') }}",
                    data: {
                        id : id,
                        _token : _token
                    },
                    dataType: "JSON",
                    success: function (data) {
                        if(data.status_code == 0){
                            var tbody = '';
                            $.each(data.tbody_data, function(index, value) {
                                tbody += '<tr>';
                                tbody += '<td>'+value.created_at+'</td>';
                                tbody += '<td>'+value.details+'</td>';
                                tbody += '<td>'+value.user.name+'</td>';
                                tbody += '</tr>';
                            });
                            var thead = '<tr><th width="200">Called At</th><th>Remarks</th><th width="200">Called By</th></tr>';
                            var title = '<label>This Phone No. related Log History</label>';
                            var table_display = title+'<table class="table table-bordered table-xs"><thead>'+thead+'</thead><tbody>'+tbody+'</tbody></table>';
                            $('#case-log-history').html(table_display);
                        }
                    }
                });
                $('#input_id').val(id);
                $('#called-modal').show();
            }
            $('.cancel').click(function() {
                $(this).parent().parent().parent().parent().parent().hide();
            });
            window.onclick = function(event) {
                if(event.target.getAttribute('id') == 'called-modal'){
                    $('#called-modal').hide();
                }
            }
            // others
            $(document).ready(function () {
                // text-editor
                CKEDITOR.replace( 'ck-editor-textarea', {
                    toolbar:[
                        { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
                        { name: 'styles', items: [ 'Format', 'FontSize' ] },
                        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat' ] },
                        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                    ],
                });
                // datatable
                $('#case-table').DataTable({
                    searching: false,
                    lengthChange: false,
                    info: false,
                    paging: false,
                });
            });
        </script>
        <!-- bfe script -->
        @can('dashboard_bfe_view')
            <script>
                $(document).ready(function () {
                    // donut 1
                    var sales_archievement_option = {
                        chart: {
                            width: 250,
                            type: 'donut',
                        },
                        labels: ['Current', 'Left'],
                        series: [{{$sm['current_charged_personal']}}, {{$sm['left_charged_personal']}}],
                        colors:['{{ $personal_current_color }}', '#4b4c4c'],
                        legend: { show: false },
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontSize: "8px",
                            }
                        },
                    }
                    var sales_archievement = new ApexCharts(
                        document.querySelector("#sales_archievement"),
                        sales_archievement_option
                    );
                    sales_archievement.render();
                    // donut 2
                    var charged_collected_option = {
                        chart: {
                            width: 250,
                            type: 'donut',
                        },
                        labels: ['Collected', 'Left'],
                        series: [{{$sm['collected_fee_personal']}},{{$sm['uncollected_fee_personal']}}],
                        colors:['#4caf50','#4b4c4c'],
                        legend: { show: false },
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontSize: "8px",
                            }
                        },
                    }
                    var charged_collected = new ApexCharts(
                        document.querySelector("#charged_collected"),
                        charged_collected_option
                    );
                    charged_collected.render();

                    @if($salesman_leader == 1)
                    var sales_archievement_team_option = {
                        chart: {
                            width: 250,
                            type: 'donut',
                        },
                        labels: ['Current', 'Left'],
                        series: [{{$sm['current_charged_team']}}, {{$sm['left_charged_team']}}],
                        colors:['{{ $team_current_color }}', '#4b4c4c'],
                        legend: { show: false },
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontSize: "8px",
                            }
                        },
                    }
                    var sales_archievement_team = new ApexCharts(
                        document.querySelector("#sales-archievement-team"),
                        sales_archievement_team_option
                    );
                    sales_archievement_team.render();
                    // donut 2
                    var charged_collected_team_option = {
                        chart: {
                            width: 250,
                            type: 'donut',
                        },
                        labels: ['Collected', 'Left'],
                        series: [{{$sm['collected_fee_team']}},{{$sm['uncollected_fee_team']}}],
                        colors:['#4caf50','#4b4c4c'],
                        legend: { show: false },
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontSize: "8px",
                            }
                        },
                    }
                    var charged_collected_team = new ApexCharts(
                        document.querySelector("#charged-collected-team"),
                        charged_collected_team_option
                    );
                    charged_collected_team.render();
                    @endif
                });
            </script>
        @endcan
    @endpush
</x-user.app-layout>



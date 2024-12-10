<x-user.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
        <style>
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                /* display: none; <- Crashes Chrome on hover */
                -webkit-appearance: none;
                margin: 0;
                /* <-- Apparently some margin are still there even though it's hidden */
            }

            input[type=number] {
                -moz-appearance: textfield;
                /* Firefox */
            }

            .show_increment_normal::-webkit-inner-spin-button,
            .show_increment_normal::-webkit-outer-spin-button {
                -webkit-appearance: inner-spin-button !important;
            }

            .show_increment_firefox {
                -moz-appearance: button !important;
                /* Firefox */
            }

            /* old */
            .select2 + .select2-container .select2-selection {
                border-radius: 60px !important;
                background-color: #E5F9FC !important;
            }

            /* Input field */
            .select2 .select2-selection__rendered {
                color: #002855 !important;
                font-weight: bold !important;
            }

            /* Search field */
            .select2-search input {
                background-color: #E5F9FC
            }

            .input_bg{
                background-color: #E5F9FC !important;
                opacity: 80%;

                /*z-index: 2;*/

                /*position: absolute;*/
            }


            .percent_bg{
                background-color: #B3A369 !important;
                color: #FFFFFF !important;
                font-weight: bold;
                text-align: center;
                font-size: 12px;
                border-radius: 30px;
            }

            .card-radius{
                border-radius: 5px !important;
            }

            .primary_font_color{
                color: #05C3DD !important;
            }

            .secondary_font_color{
                color: #21B9DB !important;
            }

            .third_font_color{
                color: #A5A5A5;
            }

            .four_font_color{
                color: #002855 !important;
            }

            .fifth_font_color{
                color: #037699 !important;
            }

            .six_font_color{
                color: #FFFFFF !important;
            }

            .hidden-font-color{
                color: #4A5B65;
            }

            .hidden-bg-color{
                background-color: #f8f8f8;
            }

            .hidden-input-bg-color{
                background-color: #d7fafa;
            }

            .primary_bg_color{
                background-color: #05C3DD !important;
                color: white !important;
            }

            .secondary_bg_color{
                background-color: #037699 !important;
                color: white !important;
            }

            .third_bg_color{
                background-color: #002855 !important;
                color: white !important;
            }

            .four_bg_color{
                background-color: #21B9DB !important;
                color: white !important;
            }

            .fifth_bg_color{
                background-color: #012138 !important;
                color: white !important;
            }

            .six_bg_color{
                background-color: #DCEFFA !important;
            }

            .seven_bg_color{
                background-color: #B3A369 !important;
                color: white !important;
            }

            .eight_bg_color{
                background-color: #53ddf5 !important;
                color: white !important;
            }

            .nine_bg_color{
                background-color: #002855 !important;
                color: white !important;
            }

            .ten_bg_color{
                background-color: white !important;
            }

            .eleven_bg_color{
                background-color: #e0e3c3 !important;
            }

            .twelve_bg_color{
                background-color: #002855 !important;
                color: #B3A369 !important;
                font-weight: bold;
            }

            /*.blurry-text {*/
            /*    color: transparent;*/
            /*    text-shadow: 0 0 5px rgba(0,0,0,0.5);*/
            /*    background: rgba(255,255,255,1);*/
            /*    backdrop-filter: blur(100px);*/
            /*}*/

            .blurry-text {
                /*background-color: black !important;*/
                text-shadow: 0 0 7px black !important;
                color: transparent !important;
            }

            .input-field-color{
                color: #0a1520 !important;
                font-weight: bold !important;
            }
        </style>
    @endpush

    <div class="container-fluid mt-4">
        <ul class="nav nav-tabs nav-primary" id="warningtab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="finReport-tab" data-bs-toggle="pill" href="#finReport" role="tab" aria-controls="finReport" aria-selected="true">Financial Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="finRoadmap-tab" data-bs-toggle="pill" href="#finRoadmap" role="tab" aria-controls="finRoadmap" aria-selected="false">Financial Roadmap</a>
            </li>
        </ul>

        <br>

        <div class="tab-content" id="warningtabContent">
            <div class="tab-pane fade show active" id="finReport" role="tabpanel" aria-labelledby="finReport-tab">
                @include('admin.financialRoadmap.showComponent.financial_report')
            </div>

            <div class="tab-pane fade" id="finRoadmap" role="tabpanel" aria-labelledby="finRoadmap-tab">
                @include('admin.financialRoadmap.showComponent.financial_roadmap')
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
            <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
        <script>
            $(".select2").select2();

            // nav
            $(function(){
                var hash = window.location.hash;
                hash && $('ul.nav a[href="' + hash + '"]').tab('show');

                $('.nav-tabs a').click(function (e) {
                    $(this).tab('show');
                    var scrollmem = $('head').scrollTop() || $('html').scrollTop();
                    window.location.hash = this.hash;
                    $('html,body').scrollTop(scrollmem);
                });
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        </script>
    @endpush
</x-user.app-layout>



<?php

if (! function_exists('dataTableLang')) {
    function dataTableLang()
    {
        return [
            'lengthMenu' => trans('datatable.length_menu'),
            'zeroRecords' => trans('datatable.zero_records'),
            'info' => trans('datatable.info_table'),
            'infoEmpty' => trans('datatable.info_empty'),
            'infoFiltered' => trans('datatable.info_filtered'),
            'loadingRecords' => trans('datatable.loading_records'),
            'processing' => trans('datatable.processing..'),
            'search' => trans('datatable.search'),
            'paginate' => [
                'first' => trans('datatable.first'),
                'last' => trans('datatable.last'),
                'next' => trans('datatable.next'),
                'previous' => trans('datatable.previous'),
            ],
        ];
    }
}

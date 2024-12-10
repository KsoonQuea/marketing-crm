<style>
    /* ------ setup ------ */
    /** {*/
    /*    !*font-family: DejaVu Sans !important;*!*/
    /*    -webkit-print-color-adjust: exact !important;   !* Chrome, Safari, Edge *!*/
    /*    color-adjust: exact !important;                 !*Firefox*!*/
    /*}*/
    .pagebreak {
        clear: both;
        page-break-after: always;
    }
    @page {
        margin: 0cm 0cm;
    }
    .body-class {
        margin-top: 1cm;
        margin-bottom: 1cm;
        margin-left: 1cm;
        margin-right: 1cm;
        font-family: "Montserrat", sans-serif;
        color: #242934;
    }

    /* ------ specific ------ */
    #pdf-div{ font-size:13px!important; }
    #pdf-div table{ border-collapse: collapse; }
    #pdf-div > .border-tr td, .border-tr th{ border:1px solid black;margin:0;}
    #pdf-div .border-bottom-line { border-bottom:1px solid black; }

    /* ------ global ------ */
    .w-full{ width:100%; }
    #pdf-div th{ text-align: left; }
    #pdf-div td{ font-weight: 400; }
    #pdf-div .column {
        float: left;
        padding: 10px;
        height: auto;
    }
    #pdf-div .row:after {
        content: "";
        display: table;
        clear: both;
    }
    .text-center{ text-align:center; }

    /* ------ print ------ */
    @media print {
        .no-print {
            display: none!important;
        }
    }
</style>

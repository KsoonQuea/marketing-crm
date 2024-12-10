@extends('admin.caseLists.showComponents.show-wrapper')

@section('view-content')
    <div class="p-0">
        <ul class="nav nav-tabs border-tab nav-secondary mb-2">
            <li class="nav-item">
                <a class="nav-link active" id="summary-memo-tab" data-bs-toggle="pill" href="#summary-memo" role="tab"
                   aria-controls="summary-memo" aria-selected="true">
                    Summary & Memo
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pcr-tab" data-bs-toggle="pill" href="#pcr" role="tab"
                   aria-controls="pcr" aria-selected="false">
                    Pulse Check Report
                </a>
            </li>
        </ul>
        <div class="tab-content pt-0 p-3 able-disabled">
            <div class="tab-pane fade show active" id="summary-memo" role="tabpanel" aria-labelledby="summary-memo-tab">
                @include('admin.caseLists.showComponents.case-status-summary')
            </div>
            <div class="tab-pane fade" id="pcr" role="tabpanel" aria-labelledby="pcr-tab">
                @include('admin.caseLists.showComponents.pulse-check-report')
            </div>
        </div>
    </div>
@endsection

@extends('admin.caseLists.showComponents.show-wrapper')

@section('view-content')
    <div class="p-0">
        <ul class="nav nav-tabs border-tab nav-secondary mb-2">
            <li class="nav-item">
                <a class="nav-link active" id="agreement-tab" data-bs-toggle="pill" href="#agreement" role="tab"
                   aria-controls="agreement" aria-selected="true">
                    Agreement
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pcr-tab" data-bs-toggle="pill" href="#billing" role="tab"
                   aria-controls="billing" aria-selected="false">
                    Billing
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="uploadPayslip" data-bs-toggle="pill" href="#payslip" role="tab"
                   aria-controls="test" aria-selected="false">
                    Upload Payment Proof
                </a>
            </li>
        </ul>
        <div class="tab-content pt-0 p-3">
            <div class="tab-pane fade show active" id="agreement" role="tabpanel" aria-labelledby="agreement-tab">
                @include('admin.caseLists.showComponents.show-agreement')
            </div>
            <div class="tab-pane fade" id="billing" role="tabpanel" aria-labelledby="billing-tab">
                @include('admin.caseLists.showComponents.show-billing')
            </div>
            <div class="tab-pane fade" id="payslip" role="tabpanel" aria-labelledby="uploadPayslip">
                @include('admin.caseLists.showComponents.show-upload-payslip')
            </div>
        </div>
    </div>
@endsection

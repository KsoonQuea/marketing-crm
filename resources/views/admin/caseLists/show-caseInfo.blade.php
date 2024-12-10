@extends('admin.caseLists.showComponents.show-wrapper')

@section('view-content')
    <div class="p-0">
        <ul class="nav nav-tabs border-tab nav-secondary mb-2">
            <li class="nav-item">
                <a class="nav-link active" id="kyc-tab" data-bs-toggle="pill" href="#kyc" role="tab"
                   aria-controls="kyc" aria-selected="true">
                    KYC
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="financial-tab" data-bs-toggle="pill" href="#financial" role="tab"
                   aria-controls="financial" aria-selected="true">
                    Financial
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="bankstt-tab" data-bs-toggle="pill" href="#bankstt" role="tab"
                   aria-controls="bankstt" aria-selected="true">
                    Bank Statement
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="directorCommitment-tab" data-bs-toggle="pill" href="#directorCommitment" role="tab"
                   aria-controls="directorCommitment" aria-selected="true">
                    Directors commitment
                </a>
            </li>
        </ul>
        <div class="tab-content pt-0 p-3 able-disabled">
            <div class="tab-pane fade show active" id="kyc" role="tabpanel" aria-labelledby="kyc-tab">
                @include('admin.caseLists.showComponents.kyc')
            </div>
            <div class="tab-pane fade" id="financial" role="tabpanel" aria-labelledby="financial-tab">
                @include('admin.caseLists.showComponents.financial')
            </div>
            <div class="tab-pane fade" id="bankstt" role="tabpanel" aria-labelledby="bankstt-tab">
                @include('admin.caseLists.showComponents.bank-statement')
            </div>
            <div class="tab-pane fade" id="directorCommitment" role="tabpanel" aria-labelledby="directorCommitment-tab">
                @include('admin.caseLists.showComponents.director-commitment')
            </div>
        </div>
    </div>
@endsection

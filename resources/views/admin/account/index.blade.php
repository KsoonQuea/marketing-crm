<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Reimbursemnet Invoice</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Reimbursemnet Invoice</li>
        <x-slot:breadcrumb_action>
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-primary" href="{{ route('admin.account.create') }}">
                        Create
                    </a>
                </div>
            </div>
        </x-slot:breadcrumb_action>
    </x-admin.breadcrumb>
    <div class="card">
        <div class="card-body p-2">
            <div class="search-div">
                <form onsubmit="return false;">
                    <div class="row">
                        <div class="col-12 col-md-9 pe-0">
                            <input type="text" id="search_input" class="form-control form-control-sm" placeholder="Search field here...">
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="float-end">
                                <button class="btn btn-light-blue btn-sm btn-search" id="search-btn" type="button">
                                    <i class="fa fa-search me-2"></i>Search
                                </button>
                                <button class="btn btn-light btn-sm btn-search" type="reset">
                                    <i class="fa fa-undo me-2"></i>Clear
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-bordered ajaxTable datatable datatable-data custom-table table-sm">
                <thead class="thead-bg">
                    <tr>
                        <th>Company Name</th>
                        <th>Invoice No</th>
                        <th>Date</th>
                        <th>&nbsp;Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ABC Sdn Bhd</td>
                        <td>P.Invoice 2200001</td>
                        <td>25/10/2022</td>
                        <th>
                            <a class="btn btn-xs btn-info text-white" href="{{ route('admin.account.edit') }}">
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-admin.app-layout>

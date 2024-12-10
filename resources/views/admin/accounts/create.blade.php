<x-admin.app-layout>
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Create Invoice</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.accounts.index') }}">
                Disbursement Invoice
            </a>
        </li>
        <li class="breadcrumb-item active">Create Invoice</li>
    </x-admin.breadcrumb>
    <style>
        .form-control{
            border:1px solid #2198c3;
            border-radius: 0;
            font-size:12px;
            min-width:250px;
        }
    </style>
    <div class="card">
        <div class="card-body p-3">
            <form method="POST" enctype="multipart/form-data" action="{{ route("admin.accounts.store") }}">
                @csrf
                @include('admin.accounts.components.invoice')
                <div class="form-group mt-5">
                    <button class="btn btn-danger pull-right" type="submit" name="submission" value="0">
                        Save Invoice
                    </button>
                    <button class="btn btn-primary me-2 pull-right" type="submit" name="submission" value="1">
                        Preview as PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin.app-layout>


<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Add New Commission</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item"><a href="{{ route('admin.commission_settings.index') }}">Commission Settings</a></li>
        <li class="breadcrumb-item active">Add New Commission</li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-3">
                <form method="POST" action="{{ route("admin.commission_settings.store") }}" enctype="multipart/form-data" class="form theme-form">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="class">Class</label>
                        <input type="text" class="form-control" id="class" name="class" required/>
                    </div>
                    <div class="form-group">
                        <label class="required" for="monthly_target">Monthly Target</label>
                        <input type="number" class="form-control" id="monthly_target" name="monthly_target" value="0" min="0" step="1"/>
                    </div>
                    <div class="form-group">
                        <label class="required" for="quarterly_target">Quarterly Target</label>
                        <input type="number" class="form-control" id="quarterly_target" name="quarterly_target" value="0" min="0" step="1"/>
                    </div>

                    <!-- Commissions Setting (Able add multiple) -->
                    <h6>Commissions</h6>
                    <div class="row tw-m-1" x-data="addCommissions()">
                        <table class="table table-bordered align-items-center table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Naming</th>
                                    <th>Range</th>
                                    <th>Rate (%)</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(commission_field, commission) in commission_fields" :key="commission">
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" name="range[]" x-model="field.range" placeholder="Range"/>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="range_fee[]" value="0" min="0" step="1" x-model="field.range_fee" placeholder="Range Fee"/>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="rate[]" value="0.0" min="0.0" step="0.1" x-model="field.rate" placeholder="Rate"/>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-small" @click="removeField(commission)">&times;</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary tw-my-3" @click="addField()">Add New Row</button>
                    </div>

                    <div class="form-group mt-3">
                        <button class="btn btn-primary" type="submit">
                            Submit
                        </button>
                        <a href="{{ route('admin.commission_settings.index') }}" class="ms-3 btn btn-light">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
        <script>
            $(".select2").select2();
        </script>
        <script>
            function addCommissions() {
                return {
                    commission_fields: [1],
                    addField() {
                        this.commission_fields.push({
                            range: '',
                            range_fee: '',
                            rate: ''
                        });
                    },
                    removeField(commission) {
                        this.commission_fields.splice(commission, 1);
                    }
                }
            }
        </script>
    @endpush
</x-admin.app-layout>

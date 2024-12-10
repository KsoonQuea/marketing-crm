<form method="POST" action="{{ route("admin.case-lists.store") }}"
      enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="stepwizard m-0">
                <div class="stepwizard-row setup-panel" style="width: 100%">
                    <div class="stepwizard-step" style="width: 25%"><a class="btn {{ $currentStep >= 1 ? 'btn-primary' : 'btn-light' }}" wire:click="updateCurrentStep(1)" >1</a>
                        <p>KYC</p>
                    </div>
                    <div class="stepwizard-step" style="width: 25%"><a class="btn {{ $currentStep >= 2 ? 'btn-primary' : 'btn-light' }}" wire:click="updateCurrentStep(2)">2</a>
                        <p>Financial</p>
                    </div>
                    <div class="stepwizard-step" style="width: 25%"><a class="btn {{ $currentStep >= 3 ? 'btn-primary' : 'btn-light' }}" wire:click="updateCurrentStep(3)">3</a>
                        <p>Bank Statement</p>
                    </div>
                    <div class="stepwizard-step" style="width: 25%"><a class="btn {{ $currentStep >= 4 ? 'btn-primary' : 'btn-light' }}" wire:click="updateCurrentStep(4)">4</a>
                        <p>Directors' Commitment</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
                @if($currentStep == 1)
                    <div class="step-one">
                        <div class="">
                            <div class="">
                                <h6>Basic Information</h6>
                                <hr>

                                <div class="mb-3 table-responsive">
                                    <table class=" table-bordered w-100">
                                        <tr>
                                            <th class="w-50 my-2">Case Code</th>
                                            <td class="p-0 w-50 my-2"><input wire:model="forms.case_code" type="text" class="my-2 border-0" style="width: 100%; height: 100%;"></td>
                                        </tr>
                                        <tr>
                                            <th>Salesman</th>
                                            <td class="p-0">
                                                <select
                                                    class="form-control select2 {{ $errors->has('salesman') ? 'is-invalid' : '' }}"
                                                    name="salesman" id="salesman" onchange="livewireSelect2Func('salesman')">
                                                    @foreach($users as $id => $user)
                                                        <option value="{{ $id }}">
                                                        {{ $user }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <h6 class="m-0 p-0">Customer Information</h6>
                                <hr>

                                <div class="mb-3 table-responsive">
                                    <table class=" table-bordered w-100">
                                        <tr>
                                            <th class="w-50 my-2">Company Name</th>
                                            <td class="p-0 w-50 my-2"><input wire:model="forms.company_name" type="text" class="my-2 border-0" style="width: 100%; height: 100%;"></td>
                                        </tr>
                                        <tr>
                                            <th>Business Incorporation Date</th>
                                            <td class="p-0"><input wire:model="forms.incorporation_date" type="date" class="my-2 border-0" style="width: 100%; height: 100%;"></td>
                                        </tr>
                                        <tr>
                                            <th>Business Industry</th>
                                            <td class="p-0">
                                                <select
                                                    class="p-0 m-0 select2 {{ $errors->has('industry_type') ? 'is-invalid' : '' }}"
                                                    name="industry_type" id="industry_type"  wire:model="forms.industry_type" onchange="livewireSelect2Func('industry_type')">
                                                    @foreach($industry_types as $id => $industry_type)
                                                        <option class="p-0 m-0" value="{{ $id }}"{{ (old('industry_type') === $id) ? 'selected' : '' }}>
                                                            {{ $industry_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Business Activity</th>
                                            <td class="p-0"><input wire:model="forms.business_activity" type="text" class="my-2 border-0" style="width: 100%; height: 100%;"></td>
                                        </tr>
                                        <tr>
                                            <th>Business Operating Address</th>
                                            <td class="p-0">
                                                <textarea class="form-control {{ $errors->has('business_bg') ? 'is-invalid' : '' }}" name="operating_address" id="operating_address" cols="30"
                                                          rows="1" wire:model="forms.operating_address">{{ old('business_bg')??'' }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Type of Application</th>
                                            <td class="p-0">
                                                <select
                                                    class="p-0 m-0 select2 {{ $errors->has('application_type') ? 'is-invalid' : '' }}"
                                                    name="application_type[]" id="application_type" wire:model="forms.application_type" onchange="livewireSelect2Func('application_type')" multiple>
                                                    @foreach($application_types as $id => $application_type)
                                                        <option class="p-0 m-0" value="{{ $id }}"{{ (old('application_type') === $id) ? 'selected' : '' }}>
                                                            {{ $application_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <td class="p-0">
{{--                                                <input wire:model="forms.application_date" type="date" class="my-2 border-0" style="width: 100%; height: 100%;">--}}
                                                <input class="datepicker-here border-0 w-100 my-2 digits" type="text" data-language="en" wire:model="forms.application_date">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>BFE</th>
                                            <td class="p-0"><input wire:model="forms.bfe" type="text" class="my-2 border-0" style="width: 100%; height: 100%;"></td>
                                        </tr>
                                    </table>
                                </div>

                            <h6>Customer Request</h6>
                            <hr>

                            <div class="form-group col-12 col-md-12" x-data="customer_request">
                                <table class="table table-bordered align-items-center table-sm">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Request</th>
                                        <th>Type of facility(ies)</th>
                                        <th>Amount </th>
                                        <th>Specific Concern (If Any)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <template x-for="(field, index) in fields" :key="index">
                                        <tr>
                                            <td class="p-0 text-center"><button type="button" class="btn btn-danger btn-sm" @click="removeField(index)">&times;</button></td>
                                            <td class="p-0">
                                                <select name="requestType[]" id="requestType" class="select2 w-100 height-100 border-0" x-model="field.requestType" wire:model="forms.customer_request.requestType" onchange="livewireSelect2Func2('customer_request', 'requestType', 'index')">
                                                    @foreach($request_types as $request_type_value => $request_type_item)
                                                        <option value="{{ $request_type_value }}">{{ $request_type_item }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="p-0"><input x-model="field.facilityType" type="text" name="facilityType[]" class="w-100 m-0 p-0 border-0"></td>
                                            <td class="p-0"><input x-model="field.requestAmount" type="text" name="requestAmount[]" class="w-100 m-0 p-0 border-0"></td>
                                            <td class="p-0"><input x-model="field.specific_concern" type="text" name="specific_concern[]" class="w-100 m-0 p-0 border-0"></td>
                                        </tr>
                                    </template>
                                    <tr>
                                        <td colspan="5" class="p-0 m-0">
                                            <button type="button" class="btn btn-primary float-end w-100 p-1 m-0" @click="addNewField();">+ Add Row</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h6>Management Team</h6>
                            <hr>

                            <div class="form-group col-12 col-md-12 table-responsive" x-data="mgmt_team">
                                <table class="table-bordered align-items-center table-sm w-100">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="p-0 text-center">#</th>
                                        <th class="p-0 text-center">Name</th>
                                        <th class="p-0 text-center">Age</th>
                                        <th class="p-0 text-center">Phone</th>
                                        <th class="p-0 text-center">Email</th>
                                        <th class="p-0 text-center">Designation</th>
                                        <th class="p-0 text-center">Shareholding (%)</th>
                                        <th class="p-0 text-center">Area of responsibility </th>
                                        <th class="p-0 text-center">Years of experience</th>
                                        <th class="p-0 text-center">Years with company</th>
                                        <th class="p-0 text-center">Relationship between directors/ shareholders</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <template x-for="(field, index) in fields" :key="index">
                                        <tr>
                                            <td class="p-0"><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                                            <td class="p-0"><input x-model="field.mgmt_team_name"               type="text"     name="mgmt_team_name[]"                 class="p-0 m-0 border-0 w-100"></td>
                                            <td class="p-0"><input x-model="field.mgmt_team_age"                type="number"   name="mgmt_team_age[]"                  class="p-0 m-0 border-0 w-100"></td>
                                            <td class="p-0"><input x-model="field.mgmt_team_phone"              type="text"     name="mgmt_team_phone[]"                class="p-0 m-0 border-0 w-100"></td>
                                            <td class="p-0"><input x-model="field.mgmt_team_email"              type="email"    name="mgmt_team_email[]"                class="p-0 m-0 border-0 w-100"></td>
                                            <td class="p-0"><input x-model="field.mgmt_team_designation"        type="text"     name="mgmt_team_designation[]"          class="p-0 m-0 border-0 w-100"></td>
                                            <td class="p-0"><input x-model="field.mgmt_team_shareholding"       type="number"   name="mgmt_team_shareholding[]"         class="p-0 m-0 border-0 w-100"></td>
                                            <td class="p-0"><input x-model="field.mgmt_team_responsibilityArea" type="text"     name="mgmt_team_responsibilityArea[]"   class="p-0 m-0 border-0 w-100"></td>
                                            <td class="p-0"><input x-model="field.mgmt_team_expeienceYear"      type="number"   name="mgmt_team_expeienceYear[]"        class="p-0 m-0 border-0 w-100"></td>
                                            <td class="p-0"><input x-model="field.mgmt_team_companyYear"        type="number"   name="mgmt_team_companyYear[]"          class="p-0 m-0 border-0 w-100"></td>
                                            <td class="p-0"><input x-model="field.mgmt_team_relationship"       type="text"     name="mgmt_team_relationship[]"         class="p-0 m-0 border-0 w-100"></td>
                                        </tr>
                                    </template>
                                    <tr>
                                        <td colspan="11" class="p-0"><button type="button" class="btn btn-primary float-end w-100" @click="addNewField()">+ Add Row</button></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h6>Credit Check</h6>
                            <hr>

                            <div class="form-group col-12 col-md-12" x-data="credit_check">
                                <table class="table-bordered align-items-center table-sm w-100">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Director/Company</th>
                                        <th>Findings</th>
                                        <th>Mitigations</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <template x-for="(field, index) in fields" :key="index">
                                        <tr>
                                            <td class="p-0 text-center"><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                                            <td class="p-0">
                                                <select name="credit_check_type[]" id="credit_check_type" x-model="field.credit_check_type" class="p-0 m-0 w-100 border-0 select2">
                                                    @foreach($case_credit_check_types as $case_credit_check_type_value => $case_credit_check_type)
                                                        <option value="{{ $case_credit_check_type_value }}">{{ $case_credit_check_type }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="p-0">
                                                <select class="p-0 m-0 w-100 border-0 select2" id="director-n-company">
                                                    <option value="0">Please select</option>
                                                    <option value="1">Director</option>
                                                    <option value="2">Company</option>
                                                </select>
                                            </td>
                                            <td class="p-0"><input x-model="field.credit_check_finding" type="text" name="credit_check_finding[]" class="p-0 m-0 w-100 border-0"></td>
                                            <td class="p-0"><input x-model="field.credit_check_mitigation" type="text" name="credit_check_mitigation[]" class="p-0 m-0 w-100 border-0"></td>
                                        </tr>
                                    </template>
                                    <tr>
                                        <td class="p-0" colspan="5"><button type="button" class="btn btn-primary float-end w-100" @click="addNewField()">+ Add Row</button></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="mt-5">Others</h6>
                            <hr>

                            <div class="form-group col-12 col-md-12">
                                <label for="business_bg">{{ trans('cruds.caseList.fields.business_bg') }}</label>
                                <textarea class="form-control {{ $errors->has('business_bg') ? 'is-invalid' : '' }}" name="business_bg" id="business_bg" cols="30"
                                          rows="3">{{ old('business_bg') }}
                                        </textarea>
                                @if($errors->has('business_bg'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('business_bg') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.caseList.fields.business_bg_helper') }}</span>
                            </div>

                            <div class="form-group col-12 col-md-12">
                                <label for="remark">{{ trans('cruds.caseList.fields.remark') }}</label>
                                <textarea name="remark" id="remark" class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" cols="30"
                                          rows="3">{{ old('remark') }}</textarea>
                                @if($errors->has('remark'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('remark') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.caseList.fields.remark_helper') }}</span>
                            </div>

                            <div class="row">

                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                           type="hidden" name="status" id="status" value="0">
                                    @if($errors->has('status'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('status') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.caseList.fields.status_helper') }}</span>
                                </div>
                            </div>
                        </div>
                        </div>

                        @push('scripts')
                            <script>
                                document.addEventListener('alpine:init', () => {
                                        Alpine.data('customer_request', () => ({
                                            fields: @entangle('forms.customer_request'),
                                            addNewField() {
                                                this.fields.push({
                                                });
                                            },
                                            removeField(index) {
                                                this.fields.splice(index, 1);
                                            },
                                            init(){
                                                this.$nextTick(() => { $(".select2").select2() });
                                            },
                                        })),
                                        Alpine.data('mgmt_team', () => ({
                                            fields: @entangle('forms.mgmt_team'),
                                            addNewField() {
                                                this.fields.push({
                                                });
                                            },
                                            removeField(index) {
                                                this.fields.splice(index, 1);
                                            },
                                            init(){
                                                this.$nextTick(() => { $(".select2").select2() });
                                            },
                                        })),
                                        Alpine.data('credit_check', () => ({
                                            fields: @entangle('forms.credit_check'),
                                            addNewField() {
                                                this.fields.push({
                                                });
                                            },
                                            removeField(index) {
                                                this.fields.splice(index, 1);
                                            },
                                            init(){
                                                this.$nextTick(() => { $(".select2").select2() });
                                            },
                                        }))
                                })
                            </script>
                        @endpush

                    </div>
                @endif

                @if($currentStep == 2)
                    <div class="step-two">
                        <div class="card">
                            <div class="card-body">
                                <h4>Financial Year End (FYE)</h4>
                                <hr>

                                <h5><b>Asset</b></h5>

                                <div class="row">
                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="current_asset">{{ trans('cruds.caseFinancial.fields.current_asset') }}</label>
                                        <input class="form-control {{ $errors->has('current_asset') ? 'is-invalid' : '' }}"
                                               type="number" name="current_asset" id="current_asset" value="{{ old('current_asset') }}"
                                               required>
                                        @if($errors->has('current_asset'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('current_asset') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.current_asset_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="non_current_asset">{{ trans('cruds.caseFinancial.fields.non_current_asset') }}</label>
                                        <input class="form-control {{ $errors->has('non_current_asset') ? 'is-invalid' : '' }}"
                                               type="number" name="non_current_asset" id="non_current_asset" value="{{ old('non_current_asset') }}"
                                               required>
                                        @if($errors->has('non_current_asset'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('non_current_asset') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.non_current_asset_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="director_asset">{{ trans('cruds.caseFinancial.fields.director_asset') }}</label>
                                        <input class="form-control {{ $errors->has('director_asset') ? 'is-invalid' : '' }}"
                                               type="number" name="director_asset" id="director_asset" value="{{ old('director_asset') }}"
                                               required>
                                        @if($errors->has('director_asset'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('director_asset') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.director_asset_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="related_customer_asset">{{ trans('cruds.caseFinancial.fields.related_customer_asset') }}</label>
                                        <input class="form-control {{ $errors->has('related_customer_asset') ? 'is-invalid' : '' }}"
                                               type="number" name="related_customer_asset" id="related_customer_asset" value="{{ old('related_customer_asset') }}"
                                               required>
                                        @if($errors->has('related_customer_asset'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('related_customer_asset') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.related_customer_asset_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="related_customer_asset">{{ trans('cruds.caseFinancial.fields.related_customer_asset') }}</label>
                                        <input class="form-control {{ $errors->has('related_customer_asset') ? 'is-invalid' : '' }}"
                                               type="number" name="related_customer_asset" id="related_customer_asset" value="{{ old('related_customer_asset') }}"
                                               required>
                                        @if($errors->has('related_customer_asset'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('related_customer_asset') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.related_customer_asset_helper') }}
                                            </span>
                                    </div>

                                </div>

                                <h5><b>Liability</b></h5>

                                <div class="row">
                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="current_liabilities">{{ trans('cruds.caseFinancial.fields.current_liabilities') }}</label>
                                        <input class="form-control {{ $errors->has('current_liabilities') ? 'is-invalid' : '' }}"
                                               type="number" name="current_liabilities" id="current_liabilities" value="{{ old('current_liabilities') }}"
                                               required>
                                        @if($errors->has('current_liabilities'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('current_liabilities') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.current_liabilities_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="non_current_liabilities">{{ trans('cruds.caseFinancial.fields.non_current_liabilities') }}</label>
                                        <input class="form-control {{ $errors->has('non_current_liabilities') ? 'is-invalid' : '' }}"
                                               type="number" name="non_current_liabilities" id="non_current_liabilities" value="{{ old('non_current_liabilities') }}"
                                               required>
                                        @if($errors->has('non_current_liabilities'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('non_current_liabilities') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.non_current_liabilities_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="director_liabilities">{{ trans('cruds.caseFinancial.fields.director_liabilities') }}</label>
                                        <input class="form-control {{ $errors->has('director_liabilities') ? 'is-invalid' : '' }}"
                                               type="number" name="director_liabilities" id="director_liabilities" value="{{ old('director_liabilities') }}"
                                               required>
                                        @if($errors->has('director_liabilities'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('director_liabilities') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.director_liabilities_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="related_customer_liabilities">{{ trans('cruds.caseFinancial.fields.related_customer_liabilities') }}</label>
                                        <input class="form-control {{ $errors->has('related_customer_liabilities') ? 'is-invalid' : '' }}"
                                               type="number" name="related_customer_liabilities" id="related_customer_liabilities" value="{{ old('related_customer_liabilities') }}"
                                               required>
                                        @if($errors->has('related_customer_liabilities'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('related_customer_liabilities') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.related_customer_liabilities_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="customer_liabilities">{{ trans('cruds.caseFinancial.fields.customer_liabilities') }}</label>
                                        <input class="form-control {{ $errors->has('customer_liabilities') ? 'is-invalid' : '' }}"
                                               type="number" name="customer_liabilities" id="customer_liabilities" value="{{ old('customer_liabilities') }}"
                                               required>
                                        @if($errors->has('customer_liabilities'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('customer_liabilities') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.customer_liabilities_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="loan_n_hp">{{ trans('cruds.caseFinancial.fields.loan_n_hp') }}</label>
                                        <input class="form-control {{ $errors->has('loan_n_hp') ? 'is-invalid' : '' }}"
                                               type="number" name="loan_n_hp" id="loan_n_hp" value="{{ old('loan_n_hp') }}"
                                               required>
                                        @if($errors->has('loan_n_hp'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('loan_n_hp') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.loan_n_hp_helper') }}
                                            </span>
                                    </div>

                                </div>

                                <h5><b>Others</b></h5>

                                <div class="row">
                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="share_capital">{{ trans('cruds.caseFinancial.fields.share_capital') }}</label>
                                        <input class="form-control {{ $errors->has('share_capital') ? 'is-invalid' : '' }}"
                                               type="number" name="share_capital" id="share_capital" value="{{ old('share_capital') }}"
                                               required>
                                        @if($errors->has('share_capital'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('share_capital') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.share_capital_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="revenue">{{ trans('cruds.caseFinancial.fields.revenue') }}</label>
                                        <input class="form-control {{ $errors->has('revenue') ? 'is-invalid' : '' }}"
                                               type="number" name="revenue" id="revenue" value="{{ old('revenue') }}"
                                               required>
                                        @if($errors->has('revenue'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('revenue') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.revenue_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="sales_cost">{{ trans('cruds.caseFinancial.fields.sales_cost') }}</label>
                                        <input class="form-control {{ $errors->has('sales_cost') ? 'is-invalid' : '' }}"
                                               type="number" name="sales_cost" id="sales_cost" value="{{ old('sales_cost') }}"
                                               required>
                                        @if($errors->has('sales_cost'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('sales_cost') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.sales_cost_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="finance_cost">{{ trans('cruds.caseFinancial.fields.finance_cost') }}</label>
                                        <input class="form-control {{ $errors->has('finance_cost') ? 'is-invalid' : '' }}"
                                               type="number" name="finance_cost" id="finance_cost" value="{{ old('finance_cost') }}"
                                               required>
                                        @if($errors->has('finance_cost'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('finance_cost') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.finance_cost_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="depreciation">{{ trans('cruds.caseFinancial.fields.depreciation') }}</label>
                                        <input class="form-control {{ $errors->has('depreciation') ? 'is-invalid' : '' }}"
                                               type="number" name="depreciation" id="depreciation" value="{{ old('depreciation') }}"
                                               required>
                                        @if($errors->has('depreciation'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('depreciation') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.depreciation_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="profit">{{ trans('cruds.caseFinancial.fields.profit') }}</label>
                                        <input class="form-control {{ $errors->has('profit') ? 'is-invalid' : '' }}"
                                               type="number" name="profit" id="profit" value="{{ old('profit') }}"
                                               required>
                                        @if($errors->has('profit'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('profit') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.profit_helper') }}
                                            </span>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="required" for="tax">{{ trans('cruds.caseFinancial.fields.tax') }}</label>
                                        <input class="form-control {{ $errors->has('tax') ? 'is-invalid' : '' }}"
                                               type="number" name="tax" id="tax" value="{{ old('tax') }}"
                                               required>
                                        @if($errors->has('tax'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('tax') }}
                                            </div>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.caseFinancial.fields.tax_helper') }}
                                            </span>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4>Commitment from CCRIS</h4>
                                <hr>

                                <div class="form-group col-12 col-md-12 table-responsive" x-data="case_commitment()">
                                    <button type="button" class="btn btn-primary float-end mb-2" @click="addNewField()">+ Add Row</button>
                                    <table class="table table-bordered align-items-center table-sm">
                                        <thead class="thead-light">
                                        <tr>
                                            {{--                                        <th>#</th>--}}
                                            <th>{{ trans('cruds.caseCommitment.fields.house_loan') }}</th>
                                            <th>{{ trans('cruds.caseCommitment.fields.term_loan') }}</th>
                                            <th>{{ trans('cruds.caseCommitment.fields.hire_purchase') }}</th>
                                            <th>{{ trans('cruds.caseCommitment.fields.credit_card_limit') }}</th>
                                            <th>{{ trans('cruds.caseCommitment.fields.trade_line_limit') }}</th>
                                            <th>Remove</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <template x-for="(field, index) in fields" :key="index">
                                            <tr>
                                                {{--                                            <td x-text="index + 1"></td>--}}
                                                <td><input x-model="field.case_commitment_houseLoan" type="text" name="case_commitment_houseLoan[]" class="form-control"></td>
                                                <td><input x-model="field.case_commitment_termLoan" type="text" name="case_commitment_termLoan[]" class="form-control"></td>
                                                <td><input x-model="field.case_commitment_hirePurchase" type="text" name="case_commitment_hirePurchase[]" class="form-control"></td>
                                                <td><input x-model="field.case_commitment_cc" type="text" name="case_commitment_cc[]" class="form-control"></td>
                                                <td><input x-model="field.case_commitment_trade_line" type="text" name="case_commitment_trade_line[]" class="form-control"></td>
                                                <td><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                                            </tr>
                                        </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4>New Financing Instruments (Loan)</h4>
                                <hr>

                                <div class="form-group col-12 col-md-12 table-responsive">
                                    <table class="table table-bordered align-items-center table-sm">
                                        <thead class="thead-light">
                                        <tr>
                                            {{--                                        <th>#</th>--}}
                                            <th>{{ trans('cruds.financingInstrument.fields.loan_product') }}</th>
                                            <th>{{ trans('cruds.caseFinancingInstrument.fields.proposed_limit') }}</th>
                                            <th>{{ trans('cruds.financingInstrument.fields.interest_rate') }}</th>
                                            <th>{{ trans('cruds.financingInstrument.fields.tenor') }}</th>
                                            <th>{{ trans('cruds.caseFinancingInstrument.fields.commitment') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($financingInstruments_loan as $financingInstrument_value => $financingInstrument_item)

                                            <tr>
                                                <td>{{ checkNULL($financingInstrument_item->loan_product) }}</td>
                                                <td><input type="number" name="financingInstrument_propose_limit_loan[]" id="financingInstrument_propose_limit_loan-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->interest_rate }}, {{ $financingInstrument_item->tenor_number }}, {{ $financingInstrument_item->tenor_month }})" class="form-control financingInstrument_propose_limit_loan"></td>
                                                <td>{{ checkNULL(number_format($financingInstrument_item->interest_rate, '3')) }}</td>
                                                <td>{{ checkNULL($financingInstrument_item->tenor) }}</td>
                                                <td><input type="text" name="financingInstrument_commitment_loan[]" id="financingInstrument_commitment_loan-{{ $financingInstrument_value }}" class="form-control financingInstrument_commitment_loan" value="-" readonly></td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td>Total:</td>
                                            <td><input type="text" name="financingInstrument_total_propose_loan" id="financingInstrument_total_propose_loan" class="form-control" readonly></td>
                                            <td colspan="2"></td>
                                            <td><input type="text" name="financingInstrument_total_commitment_loan" id="financingInstrument_total_commitment_loan" class="form-control" readonly></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4>New Financing Instruments (CAPBOOST)</h4>
                                <hr>

                                <div class="form-group col-12 col-md-12 table-responsive">
                                    <table class="table table-bordered align-items-center table-sm">
                                        <thead class="thead-light">
                                        <tr>
                                            {{--                                        <th>#</th>--}}
                                            <th>{{ trans('cruds.financingInstrument.fields.loan_product') }}</th>
                                            <th>{{ trans('cruds.caseFinancingInstrument.fields.proposed_limit') }}</th>
                                            <th>{{ trans('cruds.financingInstrument.fields.interest_rate') }}</th>
                                            <th>{{ trans('cruds.financingInstrument.fields.tenor') }}</th>
                                            <th>{{ trans('cruds.caseFinancingInstrument.fields.commitment') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($financingInstruments_capboost as $financingInstrument_value => $financingInstrument_item)

                                            <tr>
                                                <td>{{ checkNULL($financingInstrument_item->loan_product) }}</td>
                                                <td><input type="number" name="financingInstrument_propose_limit_capboost[]" id="financingInstrument_propose_limit_capboost-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->interest_rate }}, {{ $financingInstrument_item->tenor_number }}, {{ $financingInstrument_item->tenor_month }})" class="form-control financingInstrument_propose_limit_capboost"></td>
                                                <td>{{ checkNULL(number_format($financingInstrument_item->interest_rate, '3')) }}</td>
                                                <td>{{ checkNULL($financingInstrument_item->tenor) }}</td>
                                                <td><input type="text" name="financingInstrument_commitment_capboost[]" id="financingInstrument_commitment_capboost-{{ $financingInstrument_value }}" class="form-control financingInstrument_commitment_capboost" value="-" readonly></td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td>Total:</td>
                                            <td><input type="text" name="financingInstrument_total_propose_capboost" id="financingInstrument_total_propose_capboost" class="form-control" readonly></td>
                                            <td colspan="2"></td>
                                            <td><input type="text" name="financingInstrument_total_commitment_capboost" id="financingInstrument_total_commitment_capboost" class="form-control" readonly></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($currentStep == 3)
                    <div class="step-three">
                        <h4>Bank Statement</h4>
                        <hr>

                        <div x-data="bank_statement_card()">
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="bank">{{ trans('cruds.bankStatement.fields.bank') }}</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('bank') ? 'is-invalid' : '' }}"
                                        name="bank" id="bank">
                                        @foreach($banks as $id => $bank)
                                            <option value="{{ $id }}" {{ (old('bank') === $id) ? 'selected' : '' }}>
                                                {{ $bank }}</option>
                                        @endforeach
                                    </select>

                                    @if($errors->has('bank'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('bank') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.bankStatement.fields.bank_helper') }}</span>
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="currency">{{ trans('cruds.bankStatement.fields.currency') }}</label>

                                    <input class="form-control {{ $errors->has('currency') ? 'is-invalid' : '' }}"
                                           type="text" name="currency" id="currency"
                                           value="{{ old('currency') }}">

                                    @if($errors->has('currency'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('currency') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.bankStatement.fields.currency_helper') }}</span>
                                </div>
                            </div>

                            <button type="button" class="btn btn-md btn-primary mb-3" @click="addNewFieldbsc()">Add</button>

                            <template x-for="(field, index) in fields" :key="index">
                                <div class="card">
                                    <div class="card-body bg-body">
                                        <div class="row p-0 m-0">
                                            <div class="col-12 col-md-6">
                                                <label for="">{{ trans('cruds.bankStatement.fields.bank') }} :</label>
                                                <span x-text = 'template_bank'></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <button type="button" class="btn btn-close float-end mb-3" @click="removeField(index)"></button>
                                            </div>
                                        </div>
                                        <hr class="p-0 m-0">
                                        <br>

                                        <div x-data="bank_statement_table()">
                                            <button type="button" class="btn btn-primary float-end mb-3" @click="addNewField()">Add New Row</button>

                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Credit transactions</th>
                                                    <th>Debit transactions</th>
                                                    <th>Month end balance</th>
                                                    <th>Function</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <template x-for="(field, index) in fields" :key="index">
                                                    <tr>
                                                        <td><input x-model="field.bank_statement_month" type="date"   name="bank_statement_month[]" class="form-control"></td>
                                                        <td><input x-model="field.bank_statement_credit_transaction" type="number" name="bank_statement_credit_transaction[]" class="form-control"></td>
                                                        <td><input x-model="field.bank_statement_debit_transaction" type="number" name="bank_statement_debit_transaction[]" class="form-control"></td>
                                                        <td><input x-model="field.bank_statement_month_end_balance" type="number" name="bank_statement_month_end_balance[]" class="form-control"></td>
                                                        <td><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                                                    </tr>
                                                </template>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </template>

                        </div>

                        <div class="border">
                            <div class="row px-3 py-2">
                                <div class="col-12 col-md-3">
                                    <b>Credit transactions :</b>
                                </div>
                                <div class="col-12 col-md-3">

                                </div>
                                <div class="col-12 col-md-3">
                                    <b>Debit transactions :</b>
                                </div>
                                <div class="col-12 col-md-3">

                                </div>
                                <div class="col-12 col-md-3">
                                    <b>Month end balance :</b>
                                </div>
                                <div class="col-12 col-md-3">

                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($currentStep == 4)
                    <div class="step-four">
                        <h4>Directors' Commitment</h4>
                        <hr>

                        <div x-data="director_commitment()">
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="director_commitment_director_name">{{ trans('cruds.caseDirectorCommitment.fields.director_name') }}</label>

                                    <input class="form-control {{ $errors->has('director_commitment_director_name') ? 'is-invalid' : '' }}"
                                           type="text" name="director_commitment_director_name" id="director_commitment_director_name"
                                           value="{{ old('director_commitment_director_name') }}">

                                    @if($errors->has('director_commitment_director_name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('director_commitment_director_name') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.caseDirectorCommitment.fields.director_name_helper') }}</span>
                                </div>
                            </div>

                            <button type="button" class="btn btn-md btn-primary mb-3" @click="addNewCard()">Add</button>

                            <template x-for="(directorCommitment, card) in directorCommitments" :key="card">
                                <div class="card">
                                    <div class="card-body bg-body">
                                        <div class="row p-0 m-0">
                                            <div class="col-12 col-md-6">
                                                <label for="">{{ trans('cruds.caseDirectorCommitment.fields.director_name') }} :</label>
                                                <span x-text='directorCommitment.template_director_name'></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <button type="button" class="btn btn-close float-end mb-3" @click="removeCard(card)"></button>
                                            </div>
                                        </div>
                                        <hr class="p-0 m-0">
                                        <br>

                                        <div class="form-group col-12 col-md-12 table-responsive">
                                            <button type="button" class="btn btn-primary float-end mb-3" @click="addNewRow(card)">Add New Row</button>
                                            <table class="table table-bordered align-items-center table-sm">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ trans('cruds.caseDirectorCommitment.fields.house_loan') }}</th>
                                                    <th>{{ trans('cruds.caseDirectorCommitment.fields.personal_loan') }}</th>
                                                    <th>{{ trans('cruds.caseDirectorCommitment.fields.hire_purchase') }}</th>
                                                    <th>{{ trans('cruds.caseDirectorCommitment.fields.credit_card_limit') }}</th>
                                                    <th>Remove</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <template x-for="(record, row) in directorCommitment.records" :key="row">
                                                    <tr>
                                                        <td x-text="row + 1"></td>
                                                        <td><input x-model="record.director_commitment_hl" type="text" name="director_commitment_hl[]" class="form-control"></td>
                                                        <td><input x-model="record.director_commitment_pl" type="text" name="director_commitment_pl[]" class="form-control"></td>
                                                        <td><input x-model="record.director_commitment_hp" type="text" name="director_commitment_hp[]" class="form-control"></td>
                                                        <td><input x-model="record.director_commitment_cc" type="text" name="director_commitment_cc[]" class="form-control"></td>
                                                        <td><button type="button" class="btn btn-danger btn-small" @click="removeRow(card,row)">&times;</button></td>
                                                    </tr>
                                                </template>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th rowspan="2">Total</th>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td class="bg-dark"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="bg-dark"></td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>



                                    </div>
                                </div>
                            </template>
                        </div>

                    </div>
                @endif

        </div>
    </div>

    <div class="form-group mb-4">
        @if ($currentStep == 2 || $currentStep == 3 || $currentStep == 4)
            <button type="button" style="margin-right: 10px" class="btn btn-md btn-secondary" wire:click="decreaseStep()">{{ trans('global.previous') }}</button>
        @endif

        @if ($currentStep == 1 || $currentStep == 2 || $currentStep == 3)
            <button type="button" class="btn btn-md btn-success" wire:click="increaseStep()">{{ trans('global.next') }}</button>
        @endif

        @if ($currentStep == 4)
            <button type="submit" class="btn btn-md btn-primary">{{ trans('global.save') }}</button>
        @endif
    </div>
</form>

@push('scripts')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
    <script>
        $(".datepicker-here").datepicker({
            dateFormat: 'dd-mm-yyyy'
        })

        var test = 1;

        $(".select2").select2();

        $( document ).ready(function() {
            alert('start')
            $(".select2").select2();
        });

        function livewireSelect2Func(naming){
            // alert(test)
            var current_value = $('#'+naming).val()

            @this.set('forms.'+naming, current_value);
            // $('#'+naming).val(current_value).trigger('change');

            if (test == 1){
                test++;
                $('#'+naming).val(current_value).trigger('change'); // Notify any JS components that the value changed
            }

        }

        // $('#salesman').change(){
        //     $('#salesman').val(current_value).trigger('change'); // Notify any JS components that the value changed
        // }

        function livewireSelect2Func2(parent_naming, child_naming, index){
            // alert(index);
            @this.set('forms.'+parent_naming+'.'+child_naming, $('#'+child_naming).val());
        }

        function case_commitment() {
            return {
                fields: [],
                addNewField() {
                    this.fields.push({
                        txt1: '',
                        txt2: '',
                        txt3: '',
                        txt4: '',
                    });
                },
                removeField(index) {
                    this.fields.splice(index, 1);
                }
            }
        }

        function financing_instrument() {
            return {
                fields: [],
                addNewField() {
                    this.fields.push({
                        txt1: '',
                        txt2: '',
                        txt3: '',
                        txt4: '',
                    });
                },
                removeField(index) {
                    this.fields.splice(index, 1);
                }
            }
        }

        function bank_statement_card() {
            return {
                fields: [],
                addNewFieldbsc() {
                    var bank        = $("#bank").find('option:selected').text();
                    var currency    = $("#currency").val()

                    template_bank = bank + '(' + currency + ')'

                    this.fields.push({

                    });

                    $("#bank").val(0).change();
                    $("#currency").val('')
                },
                removeField(index) {
                    this.fields.splice(index, 1);
                }
            }
        }

        function bank_statement_table(){
            return {
                fields: [],
                addNewField() {
                    this.fields.push({
                        txt1: '',
                        txt2: '',
                    });
                },
                removeField(index) {
                    this.fields.splice(index, 1);
                }
            }
        }

        function director_commitment(){
            return {
                directorCommitments: @entangle('forms.directorCommitments'),
                addNewCard() {
                    var name = $("#director_commitment_director_name").val();

                    this.directorCommitments.push({
                        template_director_name: name,
                        records: []
                    });

                    $("#director_commitment_director_name").val('')
                },
                removeCard(card) {
                    this.directorCommitments.splice(card, 1);
                },
                addNewRow(card) {
                    console.log(this.directorCommitments[card]['records']);
                    this.directorCommitments[card]['records'].push({
                        txt1: '',
                        txt2: '',
                    });
                },
                removeRow(card, index) {
                    this.directorCommitments[card]['records'].splice(index, 1);
                }}
        }

        function financingInstrumentCalculateFunc(x, rate, tenor_num, tenor_month){
            var propose_limit = parseInt($("#financingInstrument_propose_limit_loan-"+x).val())
            var total = isNaN(propose_limit) ? '-' : ((( propose_limit * tenor_num * rate/100 ) + propose_limit) / tenor_month).toFixed(2);

            $("#financingInstrument_commitment_loan-"+x).val(total)

            var propose_limit = parseInt($("#financingInstrument_propose_limit_capboost-"+x).val())
            var total = isNaN(propose_limit) ? '-' : ((( propose_limit * tenor_num * rate/100 ) + propose_limit) / tenor_month).toFixed(2);

            $("#financingInstrument_commitment_capboost-"+x).val(total)

            financingInstrumentTotalCalculateFunc()
        }

        function financingInstrumentTotalCalculateFunc(){
            var total_amount = 0

            $(".financingInstrument_propose_limit_loan").each(function () {
                var amount = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val())

                total_amount    += amount;
            })

            $("#financingInstrument_total_propose_loan").val(total_amount.toFixed(2))

            var total_amount = 0

            $(".financingInstrument_commitment_loan").each(function () {
                var amount = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val())

                total_amount    += amount;
            })

            $("#financingInstrument_total_commitment_loan").val(total_amount.toFixed(2))


            var total_amount = 0

            $(".financingInstrument_propose_limit_capboost").each(function () {
                var amount = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val())

                total_amount    += amount;
            })

            $("#financingInstrument_total_propose_capboost").val(total_amount.toFixed(2))

            var total_amount = 0

            $(".financingInstrument_commitment_capboost").each(function () {
                var amount = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val())

                total_amount    += amount;
            })

            $("#financingInstrument_total_commitment_capboost").val(total_amount.toFixed(2))
        }
    </script>
@endpush

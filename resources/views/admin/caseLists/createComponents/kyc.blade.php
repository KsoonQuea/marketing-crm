<!-- step-one -->
<h6 class="card-title">Customer Information</h6>
<div class="mb-3 table-responsive">
    <table class="table-bordered form-table-one">
        <tbody>
            <tr>
                <td>Company Name</td>
                <td class="p-0 {{ $errors->has('company_name') ? 'error-area' : '' }}" >
                    <input name="company_name" type="text" class="{{ $errors->has('company_name') ? 'error-area' : '' }}" placeholder="{{ $errors->has('company_name') ? 'Please insert this field' : '' }}" value="{{ $caseList->company_name }}">
                </td>
            </tr>
            <tr>
                <td>Business Incorporation Date {{$caseList->incorporation_date}}</td>
                <td class="p-0 {{ $errors->has('incorporation_date') ? 'error-area' : '' }}">
                    <input class="datepicker-new text-input-class keyup_datepicker" type="text" data-language="en" placeholder="YYYY-MM-DD" name="incorporation_date" value="{{ ($caseList->incorporation_date) != '' ? date("Y-m-d",strtotime($caseList->incorporation_date)) : '' }}">
{{--                    <input class="digits date-input {{ $errors->has('incorporation_date') ? 'error-area' : '' }}" placeholder="YYYY-MM-DD" type="text" data-language="en" name="incorporation_date" value="{{ $caseList->incorporation_date != null ? date('d-m-Y',strtotime($caseList->incorporation_date)) : '' }}">--}}
                </td>
            </tr>
            <tr>
                <td>Business Industry</td>
                <td class="p-0 {{ $errors->has('company_name') ? 'error-area' : '' }}">
                    <select class="select2 {{ $errors->has('industry_type_id') ? 'error-area' : '' }}" id="industry_type"  name="industry_type_id">
                        @foreach($industry_types as $id => $industry_type)
                        <option value="{{ $id }}"{{ (old('industry_type') === $id) ? 'selected' : '' }} {{ ($caseList->industry_type_id === $id) ? 'selected' : '' }}>
                        {{ $industry_type }}
                        </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>Business Activity</td>
                <td class="p-0 {{ $errors->has('business_activity') ? 'error-area' : '' }}">
                    <input name="business_activity" class="{{ $errors->has('business_activity') ? 'error-area' : '' }}" placeholder="{{ $errors->has('business_activity') ? 'Please insert this field' : '' }}" type="text" value="{{ $caseList->business_activity }}"/>
                </td>
            </tr>
            <tr>
                <td>Business Operating Address</td>
                <td class="p-0 {{ $errors->has('address') ? 'error-area' : '' }}">
                    <textarea class="{{ $errors->has('address') ? 'error-area' : '' }}" name="address" id="address" cols="70" rows="2">{{ old('address')??'' }}{{ $caseList->address }}{{ $errors->has('business_activity') ? 'Please insert this field' : '' }}</textarea>
                </td>
            </tr>
            <tr>
                <td>Type of Application</td>
                <td class="p-0 {{ $errors->has('address') ? 'error-area' : '' }}">
                    <select class="select2 {{ $errors->has('address') ? 'error-area' : '' }}"  name="application_type[]" id="application_type" multiple>
                        @foreach($application_types as $id => $application_type)
                        <option class="p-0 m-0" value="{{ $id }}"{{ (old('application_type') === $id) ? 'selected' : '' }} {{ $caseList->application_types->contains($id) ? 'selected' : '' }}>
                        {{ $application_type }}
                        </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>BFE</td>

                @can('add_other_bfe_access')
                    <td>
                        <select class="select2" name="salesman_id" required>
                            @foreach($salesmen as $uid => $name)
                            <option value="{{ $uid }}" {{ $uid == $caseList->salesman_id ? 'selected' : ($uid == \Illuminate\Support\Facades\Auth::user()->id ? 'selected' : '' ) }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </td>
                @else
                    <td class="disabled-td">
                        <input name="salesman_id" type="hidden" class="my-2 border-0" style="width: 100%; height: 100%;" value="{{ $salesmen_id }}" readonly>
                        <input name="salesman_name" type="text" class="my-2 border-0" style="width: 100%; height: 100%; background-color: #D3D3D3;" value="{{ $salesmen_name }}" readonly>
                    </td>
                @endcan
            </tr>
        </tbody>
    </table>
</div>

<h6 class="card-title">Customer Request</h6>
<div class="form-group" x-data="customer_request">
    <table class="table-bordered form-table-two">
        <thead class="text-center">
            <tr>
                <th width="30">#</th>
                <th width="200">Request</th>
                <th>Type of facility(ies)</th>
                <th>Amount </th>
                <th>Specific Concern (If Any)</th>
            </tr>
        </thead>
        <tbody>
        @if($caseRequest !== null && count($caseRequest) > 0)
            @foreach($caseRequest as $caseRequest_key => $caseRequest_item)
                <tr>
                    <td class="p-0"><button type="button" class="btn btn-danger btn-sm fix-height-btn removeTable"><i class="fa fa-times"></i></button></td>
                    <td>
                        <select name="request[]" class="select2">
                            @foreach($request_types as $request_type_value => $request_type_item)
                                <option value="{{ $request_type_value }}" {{ $request_type_value == $caseRequest_item->request ? 'selected' : '' }} >{{ $request_type_item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <textarea name="facility_type[]" class="wrapper-textarea">{{ $caseRequest_item->facility_type }}</textarea>
                        <input type="text" name="facility_type[]" value="{{ $caseRequest_item->facility_type }}">
                    </td>
                    <td><input type="text" class="number-input" name="amount[]" value="{{ $caseRequest_item->amount }}"></td>
                    <td>
                        <textarea name="specific_concern[]" class="wrapper-textarea">{{ $caseRequest_item->specific_concern }}</textarea>
                        <input type="text" name="specific_concern[]" value="{{ $caseRequest_item->specific_concern }}">
                    </td>
                </tr>
            @endforeach
        @else
            @for($i = 0; $i < 6; $i++)
            <tr>
                <td class="p-0"><button type="button" class="btn btn-info btn-sm fix-height-btn" disabled><i class="fa fa-minus"></i></button></td>
                <td>
                    <select name="request[]" class="select2">
                        @foreach($request_types as $request_type_value => $request_type_item)
                        <option value="{{ $request_type_value }}">{{ $request_type_item }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <textarea name="facility_type[]" class="wrapper-textarea"></textarea>
                </td>
                <td><input type="text" class="number-input" name="amount[]"></td>
                <td>
                    <textarea name="specific_concern[]" class="wrapper-textarea"></textarea>
                </td>
            </tr>
            @endfor
        @endif
            <template x-for="(field, index) in fields" :key="index">
                <tr>
                    <td class="p-0"><button type="button" class="btn btn-danger btn-sm fix-height-btn" @click="removeField(index)"><i class="fa fa-times"></i></button></td>
                    <td>
                        <select name="requestType[]" id="requestType" class="select2" x-model="field.requestType" >
                            @foreach($request_types as $request_type_value => $request_type_item)
                            <option value="{{ $request_type_value }}">{{ $request_type_item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <textarea x-model="field.facilityType" name="facilityType[]" class="wrapper-textarea"></textarea>
                    </td>
                    <td><input x-model="field.requestAmount"    type="text" class="number-input" name="requestAmount[]"></td>
                    <td>
                        <textarea x-model="field.specific_concern" name="specific_concern[]" class="wrapper-textarea"></textarea>
                    </td>
                </tr>
            </template>
            <tr>
                <td colspan="5" class="p-0">
                    <button type="button" class="btn btn-primary float-end w-100 p-1 m-0" @click="addNewField(); $nextTick(() => reformat());">+ Add Row</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<h6 class="card-title">Management Team</h6>
<div class="form-group" x-data="mgmt_team">
    <table class="table-bordered form-table-two">
        <thead class="text-center">
            <tr>
                <th width="30">#</th>
                <th width="200">Name</th>
{{--                <th width="50">Age</th>--}}
                <th width="150">IC</th>
                <th width="250">Phone</th>
                <th width="250">Email</th>
                <th>Designation</th>
                <th>Shareholding (%)</th>
                <th width="250">Area of responsibility </th>
                <th>Years of experience</th>
                <th>Years with company</th>
                <th>Relationship between directors/ shareholders</th>
            </tr>
        </thead>
        <tbody id="mgmt_team_tbody">
        @if($caseMgmtTeam !== null && count($caseMgmtTeam) > 0)
            @foreach($caseMgmtTeam as $caseMgmtTeam_key => $caseMgmtTeam_item)
                <tr class="mgmt_team_tbody_tr">
                    <td class="p-0"><button type="button" class="btn btn-danger btn-sm fix-height-btn removeTable"><i class="fa fa-times"></i></button></td>
                    <td><textarea name="mgmt_team_name[]" class="wrapper-textarea generateDCmmt" onchange="runDirCmmt({{ $caseMgmtTeam_key }})">{{ $caseMgmtTeam_item->name }}</textarea></td>
{{--                    <td><input type="number"   name="mgmt_team_age[]"                   value="{{ $caseMgmtTeam_item->age }}"></td>--}}
                    <td><input type="text"   name="mgmt_team_ic[]" class="only-number ic" value="{{ $caseMgmtTeam_item->ic }}" onchange="runDirCmmt({{ $caseMgmtTeam_key }})"></td>
                    <td><textarea name="mgmt_team_phone[]" class="wrapper-textarea only-number phone" onchange="runDirCmmt({{ $caseMgmtTeam_key }})">{{ $caseMgmtTeam_item->phone }}</textarea></td>
                    <td><textarea name="mgmt_team_email[]" class="wrapper-textarea">{{ $caseMgmtTeam_item->email }}</textarea></td>
                    <td><textarea name="mgmt_team_designation[]" class="wrapper-textarea">{{ $caseMgmtTeam_item->designation }}</textarea></td>
                    <td><input type="number"   name="mgmt_team_shareholding[]"          value="{{ $caseMgmtTeam_item->shareholding }}"></td>
                    <td><textarea name="mgmt_team_responsibilityArea[]" class="wrapper-textarea">{{ $caseMgmtTeam_item->responsible_area }}</textarea></td>
                    <td><input type="text"   name="mgmt_team_expeienceYear[]" class=""         value="{{ $caseMgmtTeam_item->experience_year }}"></td>
                    <td><input type="text"   name="mgmt_team_companyYear[]"           value="{{ $caseMgmtTeam_item->case_year }}"></td>
                    <td><textarea name="mgmt_team_relationship[]" class="wrapper-textarea">{{ $caseMgmtTeam_item->director_relationship }}</textarea></td>
                </tr>
            @endforeach
        @else
        @for($i = 0; $i < 6; $i++)
        <tr class="mgmt_team_tbody_tr">
            <td class="p-0"><button type="button" class="btn btn-info btn-sm fix-height-btn" disabled><i class="fa fa-minus"></i></button></td>
            <td><textarea   name="mgmt_team_name[]" class="wrapper-textarea" onchange="runDirCmmt({{ $i }})"></textarea></td>
{{--            <td><input x-model="field.mgmt_team_age"                type="number"   name="mgmt_team_age[]"                  ></td>--}}
            <td><input      class="only-number ic" type="text" name="mgmt_team_ic[]" onchange="runDirCmmt({{ $i }})"></td>
            <td><textarea   name="mgmt_team_phone[]" class="wrapper-textarea only-number phone" onchange="runDirCmmt({{ $i }})"></textarea></td>
            <td><textarea   name="mgmt_team_email[]" class="wrapper-textarea"></textarea></td>
            <td><textarea   name="mgmt_team_designation[]" class="wrapper-textarea"></textarea></td>
            <td><input      type="number"   name="mgmt_team_shareholding[]"></td>
            <td><textarea   name="mgmt_team_responsibilityArea[]" class="wrapper-textarea"></textarea></td>
            <td><input      type="text"   name="mgmt_team_expeienceYear[]"></td>
            <td><input      type="text"   name="mgmt_team_companyYear[]"></td>
            <td><textarea   name="mgmt_team_relationship[]" class="wrapper-textarea"></textarea></td>
        </tr>
        @endfor
        @endif
        <template x-for="(field, index) in fields" :key="index">
            <tr>
                <td class="p-0"><button type="button" class="btn btn-danger btn-sm fix-height-btn" @click="removeField(index)"><i class="fa fa-times"></i></button></td>
                <td><textarea x-model="field.mgmt_team_name" name="mgmt_team_name[]" class="wrapper-textarea" @change="runDirCmmt(index)"></textarea></td>
{{--                <td><input x-model="field.mgmt_team_age"                type="number"   name="mgmt_team_age[]"                  ></td>--}}
                <td><input x-model="field.mgmt_team_ic" class="only-number ic" type="text" name="mgmt_team_ic[]" @change="runDirCmmt(index)"></td>
                <td><textarea x-model="field.mgmt_team_phone" name="mgmt_team_phone[]" class="wrapper-textarea only-number phone" @change="runDirCmmt(index)"></textarea></td>
                <td><textarea x-model="field.mgmt_team_email" name="mgmt_team_email[]" class="wrapper-textarea"></textarea></td>
                <td><textarea x-model="field.mgmt_team_designation" name="mgmt_team_designation[]" class="wrapper-textarea"></textarea></td>
                <td><input x-model="field.mgmt_team_shareholding"       type="number"   name="mgmt_team_shareholding[]"         ></td>
                <td><textarea x-model="field.mgmt_team_responsibilityArea" name="mgmt_team_responsibilityArea[]" class="wrapper-textarea"></textarea></td>
                <td><input x-model="field.mgmt_team_expeienceYear"      type="text"   name="mgmt_team_expeienceYear[]"        ></td>
                <td><input x-model="field.mgmt_team_companyYear"        type="text"   name="mgmt_team_companyYear[]"          ></td>
                <td><textarea x-model="field.mgmt_team_relationship" name="mgmt_team_relationship[]" class="wrapper-textarea"></textarea></td>
            </tr>
        </template>
        <tr class="mgmt_team_tbody_tr">
            <td colspan="11" class="p-0"><button type="button" class="btn btn-primary float-end w-100" @click="addNewField(); $nextTick(() => reformat());">+ Add Row</button></td>
        </tr>
        </tbody>
    </table>
</div>

<h6 class="card-title">Credit Check</h6>
<div class="form-group" x-data="credit_check">
    <table class="table-bordered form-table-two">
        <thead class="text-center">
            <tr>
                <th width="30">#</th>
                <th>Type</th>
                <th>Director/Company</th>
                <th>Findings</th>
                <th>Mitigations</th>
            </tr>
        </thead>
        <tbody>
        @if($caseCreditCheck !== null && count($caseCreditCheck) > 0)
            @foreach($caseCreditCheck as $caseCreditCheck_key => $caseCreditCheck_item)
                <tr>
                    <td class="p-0"><button type="button" class="btn btn-danger btn-sm fix-height-btn removeTable"><i class="fa fa-times"></i></button></td>
                    <td>
                        <select name="credit_check_type[]" id="credit_check_type" class="select2">
                            @foreach($case_credit_check_types as $case_credit_check_type_value => $case_credit_check_type)
                                <option value="{{ $case_credit_check_type_value }}" {{ $caseCreditCheck_item->credit_check_id == $case_credit_check_type_value ? 'selected' : '' }}>{{ $case_credit_check_type }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="select2" name="director_n_company[]">
                            <option value="0" {{ $caseCreditCheck_item->director_n_company == 0 ? 'selected' : '' }}>Please select</option>
                            <option value="1" {{ $caseCreditCheck_item->director_n_company == 1 ? 'selected' : '' }}>Director</option>
                            <option value="2" {{ $caseCreditCheck_item->director_n_company == 2 ? 'selected' : '' }}>Company</option>
                        </select>
                    </td>
                    <td>
                        <textarea name="credit_check_finding[]" class="wrapper-textarea">{{ $caseCreditCheck_item->finding }}</textarea>
                    </td>
                    <td>
                        <textarea name="credit_check_mitigation[]" class="wrapper-textarea">{{ $caseCreditCheck_item->migration }}</textarea>
                    </td>
                </tr>
            @endforeach
        @else
            @for($i = 0; $i < 6; $i++)
            <tr>
                <td class="p-0"><button type="button" class="btn btn-info btn-sm fix-height-btn" disabled><i class="fa fa-minus"></i></button></td>
                <td>
                    <select name="credit_check_type[]" id="credit_check_type" x-model="field.credit_check_type" class="select2">
                        @foreach($case_credit_check_types as $case_credit_check_type_value => $case_credit_check_type)
                        <option value="{{ $case_credit_check_type_value }}">{{ $case_credit_check_type }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="select2" name="director_n_company[]">
                        <option value="0">Please select</option>
                        <option value="1">Director</option>
                        <option value="2">Company</option>
                    </select>
                </td>
                <td>
                    <textarea x-model="field.credit_check_finding" name="credit_check_finding[]" class="wrapper-textarea"></textarea>
                </td>
                <td>
                    <textarea x-model="field.credit_check_mitigation" name="credit_check_mitigation[]" class="wrapper-textarea"></textarea>
                </td>
            </tr>
            @endfor
        @endif
            <template x-for="(field, index) in fields" :key="index">
                <tr>
                    <td class="p-0"><button type="button" class="btn btn-danger btn-sm fix-height-btn" @click="removeField(index)"><i class="fa fa-times"></i></button></td>
                    <td>
                        <select name="credit_check_type[]" id="credit_check_type" x-model="field.credit_check_type" class="select2">
                            @foreach($case_credit_check_types as $case_credit_check_type_value => $case_credit_check_type)
                            <option value="{{ $case_credit_check_type_value }}">{{ $case_credit_check_type }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="select2" name="director_n_company[]">
                            <option value="0">Please select</option>
                            <option value="1">Director</option>
                            <option value="2">Company</option>
                        </select>
                    </td>
                    <td>
                        <textarea x-model="field.credit_check_finding" name="credit_check_finding[]" class="wrapper-textarea"></textarea>
                    </td>
                    <td>
                        <textarea x-model="field.credit_check_mitigation" name="credit_check_mitigation[]" class="wrapper-textarea"></textarea>
                    </td>
                </tr>
            </template>
            <tr>
                <td class="p-0" colspan="5"><button type="button" class="btn btn-primary float-end w-100" @click="addNewField(); $nextTick(() => reformat());">+ Add Row</button></td>
            </tr>
        </tbody>
    </table>
</div>

<h6 class="card-title">Others</h6>
<div class="form-group">
    <label for="business_bg">{{ trans('cruds.caseList.fields.business_bg') }}</label>
    <textarea class="form-control {{ $errors->has('business_bg') ? 'error-area' : '' }}" name="business_bg" id="business_bg" cols="30" rows="3">{{ old('business_bg') }}{{ $caseList->business_bg }}{{ $errors->has('business_bg') ? 'Please insert this field' : '' }}</textarea>
    @if($errors->has('business_bg'))
    <div class="invalid-feedback">
        {{ $errors->first('business_bg') }}
    </div>
    @endif
    <span class="help-block">{{ trans('cruds.caseList.fields.business_bg_helper') }}</span>
</div>
<div class="form-group">
    <label for="remark">{{ trans('cruds.caseList.fields.remark') }}</label>
    <textarea placeholder="{{ $errors->has('remark') ? 'Please insert this field' : '' }}" name="remark" id="remark" class="form-control {{ $errors->has('remark') ? 'error-area' : '' }}" cols="30" rows="3">{{ old('remark') }}{{ $caseList->remark }}</textarea>
    @if($errors->has('remark'))
    <div class="invalid-feedback">
        {{ $errors->first('remark') }}
    </div>
    @endif
    <span class="help-block">{{ trans('cruds.caseList.fields.remark_helper') }}</span>
</div>
<div class="form-group">
    <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="hidden" name="status" id="status" value="0">
    @if($errors->has('status'))
    <div class="invalid-feedback">
        {{ $errors->first('status') }}
    </div>
    @endif
    <span class="help-block">{{ trans('cruds.caseList.fields.status_helper') }}</span>
</div>

<a id="financial-tab" data-bs-toggle="pill" href="#financial" role="tab" aria-controls="financial" aria-selected="false">
    <button type="button" class="btn btn-primary-light btnNext">
        Next <i class="fa fa-chevron-right" aria-hidden="true"></i>
    </button>
</a>

@push('scripts')
<script>
    $(function() {
        $(".datepicker-new").datepicker({
            dateFormat: 'yyyy-mm-dd'
        });
    });
    document.addEventListener('alpine:init', () => {
        Alpine.data('customer_request', () => ({
            fields: [],
            addNewField() {
                this.fields.push({
                    requestAmount : 0
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            },
            reformat(){
                $(".select2").select2();
                formatter_init();
            },
        })),
        Alpine.data('mgmt_team', () => ({
            fields: [],
            addNewField() {
                this.fields.push({
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            },
            reformat(){
                $(".select2").select2();
                formatter_init();
            },
        })),
        Alpine.data('credit_check', () => ({
            fields: [],
            addNewField() {
                this.fields.push({
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            },
            reformat(){
                $(".select2").select2();
                formatter_init();
            },
        }))
    })
</script>
@endpush

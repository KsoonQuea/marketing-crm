@php $permission_kyc = $permissions['kyc']; @endphp
{{--{{ dd($permissions['kyc']) }}--}}
<form action="{{ route('admin.case-lists.kyc-edit', [$caseList->id]) }}" method="post" id="kyc-form">
    @method('PUT')
    @csrf
    <h5 class="tab-pane-header">Customer Information</h5>
    <div class="mb-3 table-responsive">
        <table class="table-bordered form-table-one">
            <tbody>
                <tr>
                    <td width="250">Company Name</td>
                    <td class="p-0"><input name="company_name" type="text" class="text-input-class {{ $caseType_class }}" value="{{ $caseList->company_name }}"></td>
                </tr>
                <tr>
                    <td>Business Incorporation Date</td>
                    <td class="p-0"><input class="datepicker-here text-input-class digits keyup_datepicker {{ $caseType_class }}" type="text" placeholder="YYYY-MM-DD" data-language="en" name="incorporation_date" value="{{ ($caseList->incorporation_date) != '' ? date("Y-m-d",strtotime($caseList->incorporation_date)) : '' }}"></td>
                </tr>
                <tr>
                    <td>Business Industry</td>
                    <td class="p-0">
                        <select class="select2 text-input-class" name="industry_type" id="industry_type" name="industry_type_id">
                            @foreach ($industry_types as $id => $industry_type)
                                <option class="p-0 m-0" value="{{ $id }}" {{ $caseList->industry_type_id == $id ? 'selected="selected"' : '' }}>
                                    {{ $industry_type }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Business Activity</td>
                    <td class="p-0">
                        <input name="business_activity" type="text" class="text-input-class {{ $caseType_class }}" value="{{ $caseList->business_activity }}">
                    </td>
                </tr>
                <tr>
                    <td>Business Operating Address</td>
                    <td class="p-0">
                        <textarea class="text-input-class {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address" cols="70" rows="3">{{ $caseList->address ?? '' }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>Type of Application</td>
                    <td class="p-0">
                        <select class="select2 text-input-class{{ $errors->has('application_type') ? 'is-invalid' : '' }}"  name="application_type[]" id="application_type" name="application_type" multiple>
                            @foreach($application_types as $id => $application_type)
                                <option class="p-0 m-0" value="{{ $id }}" {{ $caseList->application_types->contains($id) ? 'selected' : '' }}>
                                    {{ $application_type }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td class="p-0 disable-div">
                        <input type="text" data-language="en" name="applicaion_date"  value="{{ $caseList->applicaion_date }}" disabled>
                    </td>
                </tr>
                <tr>
                    <td>BFE</td>
                    <td class="p-0 disable-div">
                        <input type="text" class="text-input-class" value="{{ $caseList->salesman->name }}" disabled/>
{{--                        <select class="select2" name="salesman_id" id="salesman" disabled>--}}
{{--                            @foreach ($users as $id => $user)--}}
{{--                                <option value="{{ $id }}"--}}
{{--                                    {{ $caseList->salesman_id == $id ? 'selected="selected"' : '' }}>--}}
{{--                                    {{ $user }}--}}
{{--                                </option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <h5 class="tab-pane-header">Customer Request</h5>
    @can('case_kyc_edit_2')
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
                                <td class="p-0"><button type="button" class="btn btn-danger btn-sm fix-height-btn removeTable {{ $caseType_class }}"><i class="fa fa-times"></i></button></td>
                                <td>
                                    <select name="request[]" class="select2">
                                        @foreach($request_types as $request_type_value => $request_type_item)
                                            <option value="{{ $request_type_value }}" {{ $request_type_value == $caseRequest_item->request ? 'selected' : '' }} >{{ $request_type_item }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <textarea name="facility_type[]" class="wrapper-textarea">{{ $caseRequest_item->facility_type }}</textarea>
{{--                                    <input type="text" name="facility_type[]" value="{{ $caseRequest_item->facility_type }}"/>--}}
                                </td>
                                <td><input type="text" class="number-input {{ $caseType_class }}" name="amount[]" value="{{ $caseRequest_item->amount }}"/></td>
                                <td>
                                    <textarea name="specific_concern[]" class="wrapper-textarea">{{ $caseRequest_item->specific_concern }}</textarea>
{{--                                    <input type="text" name="specific_concern[]" value="{{ $caseRequest_item->specific_concern }}"/>--}}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @for($i = 0; $i < 6; $i++)
                            <tr>
                                <td class="p-0"><button type="button" class="btn btn-info fix-height-btn btn-sm" disabled><i class="fa fa-minus"></i></button></td>
                                <td>
                                    <select name="request[]" class="select2">
                                        @foreach($request_types as $request_type_value => $request_type_item)
                                            <option value="{{ $request_type_value }}">{{ $request_type_item }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <textarea name="facility_type[]" class="wrapper-textarea"></textarea>
{{--                                    <input type="text" name="facility_type[]"/>--}}
                                </td>
                                <td><input type="text" class="number-input {{ $caseType_class }}" name="amount[]"/></td>
                                <td>
                                    <textarea name="specific_concern[]" class="wrapper-textarea"></textarea>
{{--                                    <input type="text" name="specific_concern[]"/>--}}
                                </td>
                            </tr>
                        @endfor
                    @endif
                    <template x-for="(field, index) in fields" :key="index">
                        <tr>
                            <td class="p-0"><button type="button" class="btn btn-danger fix-height-btn btn-sm {{ $caseType_class }}" @click="removeField(index)"><i class="fa fa-times"></i></button></td>
                            <td>
                                <select name="request[]" id="requestType" class="select2" x-model="field.requestType">
                                    @foreach($request_types as $request_type_value => $request_type_item)
                                        <option value="{{ $request_type_value }}">{{ $request_type_item }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <textarea x-model="field.facilityType" name="facility_type[]" class="wrapper-textarea"></textarea>
{{--                                <input x-model="field.facilityType" type="text" name="facility_type[]"/>--}}
                            </td>
                            <td><input x-model="field.requestAmount" type="text" class="number-input {{ $caseType_class }}" name="amount[]"/></td>
                            <td>
                                <textarea x-model="field.specific_concern" name="specific_concern[]" class="wrapper-textarea"></textarea>
{{--                                <input x-model="field.specific_concern" type="text" name="specific_concern[]"/>--}}
                            </td>
                        </tr>
                    </template>
                    <tr>
                        <td colspan="5" class="p-0">
                            <button type="button" class="btn btn-primary float-end w-100 p-1 m-0 {{ $caseType_class }}" @click="addNewField(); $nextTick(() => reformat());">+ Add Row</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="form-group">
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
                    @forelse ($caseList->request as $request)
                        <tr>
                            <td class="p-0"><button type="button" class="btn btn-info fix-height-btn btn-sm {{ $caseType_class }}"><i class="fa fa-minus"></i></button></td>
                            <td>
                                @if($request->request == 0 || $request->request == NULL)
                                    <input type="text" class="{{ $caseType_class }}" value=""/>
                                @else
                                <select name="request[]" class="select2">
                                    @foreach ($request_types as $request_type_value => $request_type_item)
                                        <option value="{{ $request_type_value }}" {{ $request_type_value == $request->request ? 'selected' : '' }} >
                                            {{ $request_type_item }}
                                        </option>
                                    @endforeach
                                </select>
                                @endif
                            </td>
                            <td>
                                <textarea name="facility_type[]" class="wrapper-textarea">{{ $request->facility_type }}"</textarea>
{{--                                <input type="text" name="facility_type[]" value="{{ $request->facility_type }}">--}}
                            </td>
                            <td><input type="text" class="{{ $caseType_class }}" name="amount[]" value="{{ $request->amount }}"></td>
                            <td>
                                <textarea name="specific_concern[]" class="wrapper-textarea">{{ $request->specific_concern }}"</textarea>
{{--                                <input type="text" name="specific_concern[]" value="{{ $request->specific_concern }}">--}}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No Result Found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endcan

    <h5 class="tab-pane-header">Management Team</h5>
    @can('case_kyc_edit_2')
        <div class="form-group" x-data="mgmt_team">
            <table class="table-bordered form-table-two">
                <thead class="text-center">
                    <tr>
                        <th width="30">#</th>
                        <th width="200">Name</th>
{{--                        <th width="50">Age</th>--}}
                        <th width="150">IC</th>
                        <th width="150">Phone</th>
                        <th width="250">Email</th>
                        <th>Designation</th>
                        <th>Shareholding (%)</th>
                        <th width="250">Area of responsibility </th>
                        <th>Years of experience</th>
                        <th>Years with company</th>
                        <th>Relationship between directors/ shareholders</th>
                    </tr>
                </thead>
                <tbody>
                    @if($caseMgmtTeam !== null && count($caseMgmtTeam) > 0)
                        @foreach($caseMgmtTeam as $caseMgmtTeam_key => $caseMgmtTeam_item)
                            <tr>
                                <td class="p-0"><button type="button" class="btn btn-danger btn-sm fix-height-btn removeTable {{ $caseType_class }}"><i class="fa fa-times"></i></button></td>
                                <td>
                                    <textarea name="mgmt_team_name[]" class="wrapper-textarea">{{ $caseMgmtTeam_item->name }}</textarea>
                                    {{--                        <input type="text"     name="mgmt_team_name[]"                  value="{{ $caseMgmtTeam_item->name }}">--}}
                                </td>
{{--                                <td><input type="number"   name="mgmt_team_age[]"                   value="{{ $caseMgmtTeam_item->age }}"></td>--}}
                                <td><input type="text"  class="only-number ic {{ $caseType_class }}"  name="mgmt_team_ic[]"                   value="{{ $caseMgmtTeam_item->ic }}"></td>
                                <td>
                                    <textarea name="mgmt_team_phone[]" class="wrapper-textarea only-number phone">{{ $caseMgmtTeam_item->phone }}</textarea>
                                    {{--                        <input type="text"     name="mgmt_team_phone[]"                 value="{{ $caseMgmtTeam_item->phone }}">--}}
                                </td>
                                <td>
                                    <textarea name="mgmt_team_email[]" class="wrapper-textarea">{{ $caseMgmtTeam_item->email }}</textarea>
                                    {{--                        <input type="text"    name="mgmt_team_email[]"                 value="{{ $caseMgmtTeam_item->email }}">--}}
                                </td>
                                <td>
                                    <textarea name="mgmt_team_designation[]" class="wrapper-textarea">{{ $caseMgmtTeam_item->designation }}</textarea>
                                    {{--                        <input type="text"     name="mgmt_team_designation[]"           value="{{ $caseMgmtTeam_item->designation }}">--}}
                                </td>
                                <td><input type="number" class="{{ $caseType_class }}"   name="mgmt_team_shareholding[]"          value="{{ $caseMgmtTeam_item->shareholding }}"></td>
                                <td>
                                    <textarea name="mgmt_team_responsibilityArea[]" class="wrapper-textarea">{{ $caseMgmtTeam_item->responsible_area }}</textarea>
                                    {{--                        <input type="text"     name="mgmt_team_responsibilityArea[]"    value="{{ $caseMgmtTeam_item->responsible_area }}">--}}
                                </td>
                                <td><input type="text"  class="{{ $caseType_class }}"  name="mgmt_team_expeienceYear[]"         value="{{ $caseMgmtTeam_item->experience_year }}"></td>
                                <td><input type="text" class="{{ $caseType_class }}"  name="mgmt_team_companyYear[]"           value="{{ $caseMgmtTeam_item->case_year }}"></td>
                                <td>
                                    <textarea name="mgmt_team_relationship[]" class="wrapper-textarea">{{ $caseMgmtTeam_item->director_relationship }}</textarea>
                                    {{--                        <input type="text"     name="mgmt_team_relationship[]"          value="{{ $caseMgmtTeam_item->director_relationship }}">--}}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @for($i = 0; $i < 6; $i++)
                            <tr>
                                <td class="p-0"><button type="button" class="btn btn-info fix-height-btn btn-sm" disabled><i class="fa fa-minus"></i></button></td>
                                <td>
                                    <textarea x-model="field.mgmt_team_name" name="mgmt_team_name[]" class="wrapper-textarea"></textarea>
                                    {{--                <input x-model="field.mgmt_team_name"               type="text"     name="mgmt_team_name[]"                 >--}}
                                </td>
{{--                                <td><input x-model="field.mgmt_team_age"                type="number"   name="mgmt_team_age[]"                  ></td>--}}
                                <td><input x-model="field.mgmt_team_ic"        class="{{ $caseType_class }} ic only-number"        type="text"   name="mgmt_team_ic[]"                  ></td>
                                <td>
                                    <textarea x-model="field.mgmt_team_phone" name="mgmt_team_phone[]" class="wrapper-textarea only-number phone"></textarea>
                                    {{--                <input x-model="field.mgmt_team_phone"              type="text"     name="mgmt_team_phone[]"                >--}}
                                </td>
                                <td>
                                    <textarea x-model="field.mgmt_team_email" name="mgmt_team_email[]" class="wrapper-textarea"></textarea>
                                    {{--                <input x-model="field.mgmt_team_email"              type="text"    name="mgmt_team_email[]"                >--}}
                                </td>
                                <td>
                                    <textarea x-model="field.mgmt_team_designation" name="mgmt_team_designation[]" class="wrapper-textarea"></textarea>
                                    {{--                <input x-model="field.mgmt_team_designation"        type="text"     name="mgmt_team_designation[]"          >--}}
                                </td>
                                <td><input x-model="field.mgmt_team_shareholding"    class="{{ $caseType_class }}"   type="number"   name="mgmt_team_shareholding[]"         ></td>
                                <td>
                                    <textarea x-model="field.mgmt_team_responsibilityArea" name="mgmt_team_responsibilityArea[]" class="wrapper-textarea"></textarea>
                                    {{--                <input x-model="field.mgmt_team_responsibilityArea" type="text"     name="mgmt_team_responsibilityArea[]"   >--}}
                                </td>
                                <td><input x-model="field.mgmt_team_expeienceYear"  class="{{ $caseType_class }}"    type="text"   name="mgmt_team_expeienceYear[]"        ></td>
                                <td><input x-model="field.mgmt_team_companyYear"    class="{{ $caseType_class }}"    type="text"   name="mgmt_team_companyYear[]"          ></td>
                                <td>
                                    <textarea x-model="field.mgmt_team_relationship" name="mgmt_team_relationship[]" class="wrapper-textarea"></textarea>
                                    {{--                <input x-model="field.mgmt_team_relationship"       type="text"     name="mgmt_team_relationship[]"         >--}}
                                </td>
                            </tr>
                        @endfor
                    @endif
                    <template x-for="(field, index) in fields" :key="index">
                        <tr>
                            <td class="p-0"><button type="button" class="btn btn-danger fix-height-btn btn-sm {{ $caseType_class }}" @click="removeField(index)"><i class="fa fa-times"></i></button></td>
                            <td>
                                <textarea x-model="field.mgmt_team_name" name="mgmt_team_name[]" class="wrapper-textarea"></textarea>
                                {{--                    <input x-model="field.mgmt_team_name"               type="text"     name="mgmt_team_name[]"                 >--}}
                            </td>
{{--                            <td><input x-model="field.mgmt_team_age"                type="number"   name="mgmt_team_age[]"                  ></td>--}}
                            <td><input x-model="field.mgmt_team_ic" class="only-number ic" type="text"   name="mgmt_team_ic[]"                  ></td>
                            <td>
                                <textarea x-model="field.mgmt_team_phone" name="mgmt_team_phone[]" class="wrapper-textarea only-number phone"></textarea>
                                {{--                    <input x-model="field.mgmt_team_phone"              type="text"     name="mgmt_team_phone[]"                >--}}
                            </td>
                            <td>
                                <textarea x-model="field.mgmt_team_email" name="mgmt_team_email[]" class="wrapper-textarea"></textarea>
                                {{--                    <input x-model="field.mgmt_team_email"              type="text"    name="mgmt_team_email[]"                >--}}
                            </td>
                            <td>
                                <textarea x-model="field.mgmt_team_designation" name="mgmt_team_designation[]" class="wrapper-textarea"></textarea>
                                {{--                    <input x-model="field.mgmt_team_designation"        type="text"     name="mgmt_team_designation[]"          >--}}
                            </td>
                            <td><input x-model="field.mgmt_team_shareholding"    class="{{ $caseType_class }}"   type="number"   name="mgmt_team_shareholding[]"         ></td>
                            <td>
                                <textarea x-model="field.mgmt_team_responsibilityArea" name="mgmt_team_responsibilityArea[]" class="wrapper-textarea"></textarea>
                                {{--                    <input x-model="field.mgmt_team_responsibilityArea" type="text"     name="mgmt_team_responsibilityArea[]"   >--}}
                            </td>
                            <td><input x-model="field.mgmt_team_expeienceYear"  class="{{ $caseType_class }}"    type="text"   name="mgmt_team_expeienceYear[]"        ></td>
                            <td><input x-model="field.mgmt_team_companyYear"    class="{{ $caseType_class }}"    type="text"   name="mgmt_team_companyYear[]"          ></td>
                            <td>
                                <textarea x-model="field.mgmt_team_relationship" name="mgmt_team_relationship[]" class="wrapper-textarea"></textarea>
                                {{--                    <input x-model="field.mgmt_team_relationship"       type="text"     name="mgmt_team_relationship[]"         >--}}
                            </td>
                        </tr>
                    </template>
                    <tr>
                        <td colspan="11" class="p-0"><button type="button" class="btn btn-primary float-end w-100 {{ $caseType_class }}" @click="addNewField(); $nextTick(() => reformat());">+ Add Row</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="form-group">
            <table class="table-bordered form-table-two">
                <thead class="text-center">
                    <tr>
                        <th width="30">#</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Shareholding (%)</th>
                        <th>Area of responsibility </th>
                        <th>Years of experience</th>
                        <th>Years with company</th>
                        <th>Relationship between directors/ shareholders</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($caseList->management_team as $management_team)
                    <tr>
                        <td class="p-0"><button type="button" class="btn btn-info btn-sm fix-height-btn {{ $caseType_class }}"><i class="fa fa-minus"></i></button></td>
                        <td><input type="text" name="mgmt_team_name[]" class="{{ $caseType_class }}" value="{{ $management_team->name }}"></td>
{{--                        <td><input type="number" name="mgmt_team_age[]" value="{{ $management_team->age }}"></td>--}}
                        <td><input type="text" name="mgmt_team_ic[]" class="only-number ic {{ $caseType_class }}" value="{{ $management_team->ic }}"></td>
                        <td><input type="text" name="mgmt_team_phone[]" class="only-number phone {{ $caseType_class }}" value="{{ $management_team->phone }}"></td>
                        <td><input type="email" name="mgmt_team_email[]" class="{{ $caseType_class }}" value="{{ $management_team->email }}"></td>
                        <td><input type="text" name="mgmt_team_designation[]" class="{{ $caseType_class }}" value="{{ $management_team->designation }}"></td>
                        <td><input type="number" name="mgmt_team_shareholding[]" class="{{ $caseType_class }}" value="{{ $management_team->shareholding }}"></td>
                        <td><input type="text" name="mgmt_team_responsibilityArea[]" class="{{ $caseType_class }}" value="{{ $management_team->responsible_area }}"></td>
                        <td><input type="number" name="mgmt_team_experienceYear[]" class="{{ $caseType_class }}" value="{{ $management_team->experience_year }}"></td>
                        <td><input type="number" name="mgmt_team_companyYear[]" class="{{ $caseType_class }}" value="{{ $management_team->case_year }}"></td>
                        <td><input type="text" name="mgmt_team_relationship[]" class="{{ $caseType_class }}" value="{{ $management_team->director_relationship }}"></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11">No Result Found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endcan

    <h5 class="tab-pane-header">Credit Check</h5>
    @can('case_kyc_edit_2')
        <div class="form-group" x-data="credit_check">
            <table class="table-bordered form-table-two">
                <thead class="text-center">
                    <tr>
                        <th width="30">#</th>
                        <th width="200">Type</th>
                        <th width="200">Director/Company</th>
                        <th>Findings</th>
                        <th>Mitigations</th>
                    </tr>
                </thead>
                <tbody>
                    @if($caseCreditCheck !== null && count($caseCreditCheck) > 0)
                        @foreach($caseCreditCheck as $caseCreditCheck_key => $caseCreditCheck_item)
                            <tr>
                                <td class="p-0"><button type="button" class="btn btn-danger btn-sm fix-height-btn removeTable {{ $caseType_class }}"><i class="fa fa-times"></i></button></td>
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
{{--                                    <input type="text" name="credit_check_finding[]" class="wrapper-input" value="{{ $caseCreditCheck_item->finding }}">--}}
                                </td>
                                <td>
                                    <textarea name="credit_check_mitigation[]" class="wrapper-textarea">{{ $caseCreditCheck_item->migration }}</textarea>
{{--                                    <input type="text" name="credit_check_mitigation[]" class="wrapper-input" value="{{ $caseCreditCheck_item->migration }}">--}}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @for($i = 0; $i < 3; $i++)
                            <tr>
                                <td class="p-0"><button type="button" class="btn btn-info btn-sm fix-height-btn {{ $caseType_class }}" disabled><i class="fa fa-minus"></i></button></td>
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
{{--                                    <input x-model="field.credit_check_finding" type="text" class="wrapper-input" name="credit_check_finding[]">--}}
                                </td>
                                <td>
                                    <textarea x-model="field.credit_check_mitigation" name="credit_check_mitigation[]" class="wrapper-textarea"></textarea>
{{--                                    <input x-model="field.credit_check_mitigation" type="text" class="wrapper-input" name="credit_check_mitigation[]">--}}
                                </td>
                            </tr>
                        @endfor
                    @endif
                    <template x-for="(field, index) in fields" :key="index">
                        <tr>
                            <td class="p-0"><button type="button" class="btn btn-danger btn-sm fix-height-btn {{ $caseType_class }}" @click="removeField(index)"><i class="fa fa-times"></i></button></td>
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
{{--                                <input x-model="field.credit_check_finding" type="text" class="wrapper-input" name="credit_check_finding[]">--}}
                            </td>
                            <td>
                                <textarea x-model="field.credit_check_mitigation" name="credit_check_mitigation[]" class="wrapper-textarea"></textarea>
{{--                                <input x-model="field.credit_check_mitigation" type="text" class="wrapper-input" name="credit_check_mitigation[]">--}}
                            </td>
                        </tr>
                    </template>
                    <tr>
                        <td class="p-0" colspan="5"><button type="button" class="btn btn-primary float-end w-100 {{ $caseType_class }}" @click="addNewField(); $nextTick(() => reformat());">+ Add Row</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="form-group col-12 col-md-12">
            <table class="table-bordered form-table-two">
                <thead class="text-center">
                    <tr>
                        <th width="30">#</th>
                        <th width="200">Type</th>
                        <th width="200">Director/Company</th>
                        <th>Findings</th>
                        <th>Mitigations</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($caseList->credit_check as $credit_check)
                        <tr>
                            <td class="p-0"><button type="button" class="btn btn-info btn-sm fix-height-btn {{ $caseType_class }}"><i class="fa fa-minus"></i></button></td>
                            <td>
                                @if($credit_check->credit_check_id == 0 || $credit_check->credit_check_id == NULL)
                                    <input type="text" class="{{ $caseType_class }}" value=""/>
                                @else
                                <select name="credit_check_type[]" id="credit_check_type" class="select2">
                                    @foreach ($case_credit_check_types as $case_credit_check_type_value => $case_credit_check_type)
                                        <option {{ $credit_check->credit_check_id == $case_credit_check_type_value ? 'selected' : '' }} value="{{ $case_credit_check_type_value }}">
                                            {{ $case_credit_check_type }}
                                        </option>
                                    @endforeach
                                </select>
                                @endif
                            </td>
                            <td>
                                @if($credit_check->director_n_company == 0 || $credit_check->director_n_company == NULL)
                                <input type="text" class="{{ $caseType_class }}" value=""/>
                                @else
                                <select class="select2" name="director_n_company[]">
                                    <option value="0"></option>
                                    <option value="1" {{ $credit_check->director_n_company == 1 ? 'selected' : '' }}>Director</option>
                                    <option value="2" {{ $credit_check->director_n_company == 2 ? 'selected' : '' }}>Company</option>
                                </select>
                                @endif
                            </td>
                            <td>
                                <textarea name="credit_check_finding[]" class="wrapper-textarea">{{ $credit_check->finding }}</textarea>
{{--                                <input type="text" name="credit_check_finding[]" value="{{ $credit_check->finding }}">--}}
                            </td>
                            <td>
                                <textarea name="credit_check_mitigation[]" class="wrapper-textarea">{{ $credit_check->migration }}</textarea>
{{--                                <input type="text" name="credit_check_mitigation[]" value="{{ $credit_check->migration }}">--}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No Result Found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endcan

    <h5 class="tab-pane-header">Others</h5>
    <div class="form-group">
        <label for="business_bg" style="font-weight: 400;">{{ trans('cruds.caseList.fields.business_bg') }}</label>
        <textarea class="form-control {{ $errors->has('business_bg') ? 'is-invalid' : '' }}" name="business_bg" id="business_bg" cols="30" rows="3">{{ $caseList->business_bg }}</textarea>
        @if ($errors->has('business_bg'))
            <div class="invalid-feedback">
                {{ $errors->first('business_bg') }}
            </div>
        @endif
        <span class="help-block">{{ trans('cruds.caseList.fields.business_bg_helper') }}</span>
    </div>
    <div class="form-group">
        <label for="remark" style="font-weight: 400;">{{ trans('cruds.caseList.fields.remark') }}</label>
        <textarea name="remark" id="remark" class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" cols="30" rows="3">{{ $caseList->remark }}</textarea>
        @if ($errors->has('remark'))
            <div class="invalid-feedback">
                {{ $errors->first('remark') }}
            </div>
        @endif
        <span class="help-block">{{ trans('cruds.caseList.fields.remark_helper') }}</span>
    </div>

    <div class="row">
        <div class="form-group col-12 col-md-6">
            <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="hidden" name="status" id="status" value="0">
            @if ($errors->has('status'))
                <div class="invalid-feedback">
                    {{ $errors->first('status') }}
                </div>
            @endif
            <span class="help-block">{{ trans('cruds.caseList.fields.status_helper') }}</span>
        </div>
    </div>

    @if($caseType_num != 2 && $caseType_num != 3)
    @can('case_kyc_edit_2')
        <div>
            <button type="submit" class="btn btn-primary btn-sm {{ $caseType_class }}">
                <i class="fa fa-edit me-2"></i>
                Save & Update
            </button>
        </div>
    @endcan
    @endif

    @push('scripts')
        <script>
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

            $(function (e) {
                @cannot('case_kyc_edit_2')
                $("#kyc-form input, #kyc-form select, #kyc-form textarea").each(function(){
                    var input = $(this);
                    $(this).parent().find('td:not(.td-label)').addClass("disable-div"); // disabled class to parent td
                    input.prop('disabled',true);
                    $('.add-row-btn').hide();
                });
                @endcannot
            });
        </script>
    @endpush
</form>

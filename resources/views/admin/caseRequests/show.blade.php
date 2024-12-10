@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.caseRequest.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-requests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.caseRequest.fields.case') }}
                        </th>
                        <td>
                            {{ $caseRequest->case->case_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseRequest.fields.request') }}
                        </th>
                        <td>
                            {{ $caseRequest->request }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseRequest.fields.request_type') }}
                        </th>
                        <td>
                            {{ $caseRequest->request_type->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseRequest.fields.facility_type') }}
                        </th>
                        <td>
                            {{ $caseRequest->facility_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseRequest.fields.amount') }}
                        </th>
                        <td>
                            {{ $caseRequest->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseRequest.fields.specific_concern') }}
                        </th>
                        <td>
                            {{ $caseRequest->specific_concern }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-requests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.caseDirectorCommitment.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-director-commitments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.caseDirectorCommitment.fields.case') }}
                        </th>
                        <td>
                            {{ $caseDirectorCommitment->case->case_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseDirectorCommitment.fields.director_name') }}
                        </th>
                        <td>
                            {{ $caseDirectorCommitment->director_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseDirectorCommitment.fields.house_loan') }}
                        </th>
                        <td>
                            {{ $caseDirectorCommitment->house_loan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseDirectorCommitment.fields.personal_loan') }}
                        </th>
                        <td>
                            {{ $caseDirectorCommitment->personal_loan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseDirectorCommitment.fields.hire_purchase') }}
                        </th>
                        <td>
                            {{ $caseDirectorCommitment->hire_purchase }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseDirectorCommitment.fields.credit_card_limit') }}
                        </th>
                        <td>
                            {{ $caseDirectorCommitment->credit_card_limit }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-director-commitments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
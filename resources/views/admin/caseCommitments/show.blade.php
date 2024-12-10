@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.caseCommitment.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-commitments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCommitment.fields.case') }}
                        </th>
                        <td>
                            {{ $caseCommitment->case->case_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCommitment.fields.house_loan') }}
                        </th>
                        <td>
                            {{ $caseCommitment->house_loan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCommitment.fields.term_loan') }}
                        </th>
                        <td>
                            {{ $caseCommitment->term_loan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCommitment.fields.hire_purchase') }}
                        </th>
                        <td>
                            {{ $caseCommitment->hire_purchase }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCommitment.fields.credit_card_limit') }}
                        </th>
                        <td>
                            {{ $caseCommitment->credit_card_limit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCommitment.fields.trade_line_limit') }}
                        </th>
                        <td>
                            {{ $caseCommitment->trade_line_limit }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-commitments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.caseDsr.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-dsrs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.caseDsr.fields.case') }}
                        </th>
                        <td>
                            {{ $caseDsr->case->case_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseDsr.fields.ebitda') }}
                        </th>
                        <td>
                            {{ $caseDsr->ebitda }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseDsr.fields.ccris_commitment') }}
                        </th>
                        <td>
                            {{ $caseDsr->ccris_commitment }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseDsr.fields.bank_statement_commitment') }}
                        </th>
                        <td>
                            {{ $caseDsr->bank_statement_commitment }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseDsr.fields.new_financing_commitment') }}
                        </th>
                        <td>
                            {{ $caseDsr->new_financing_commitment }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseDsr.fields.dsr') }}
                        </th>
                        <td>
                            {{ $caseDsr->dsr }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-dsrs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
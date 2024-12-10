<?php

namespace App\Http\Requests;

use App\Models\CaseCashflowMonCommit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCaseCashflowMonCommitRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('case_cashflow_mon_commit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => [
                'required',
                'array',
            ],
            'ids.*' => [
                'exists:case_cashflow_mon_commits,id',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\CaseCashflowMonCommit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StoreCaseCashflowMonCommitRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_cashflow_mon_commit_create');
    }

    public function rules()
    {
        return [
            'income_factor' => [
                'numeric',
            ],
            'dsr' => [
                'numeric',
            ],
        ];
    }
}

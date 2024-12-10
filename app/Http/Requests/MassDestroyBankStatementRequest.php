<?php

namespace App\Http\Requests;

use App\Models\BankStatement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBankStatementRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('bank_statement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'exists:bank_statements,id',
            ],
        ];
    }
}

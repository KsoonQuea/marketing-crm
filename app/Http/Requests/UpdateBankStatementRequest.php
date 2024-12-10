<?php

namespace App\Http\Requests;

use App\Models\BankStatement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateBankStatementRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('bank_statement_edit');
    }

    public function rules()
    {
        return [
            'bank_owner' => [
                'string',
                'nullable',
            ],
            'bank_account' => [
                'string',
                'nullable',
            ],
            'credit' => [
                'numeric',
            ],
            'debit' => [
                'numeric',
            ],
            'month_end_balance' => [
                'numeric',
            ],
        ];
    }
}

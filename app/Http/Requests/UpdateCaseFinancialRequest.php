<?php

namespace App\Http\Requests;

use App\Models\CaseFinancial;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateCaseFinancialRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_financial_edit');
    }

    public function rules()
    {
        return [
            'financial_date' => [
                'date_format:'.config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}

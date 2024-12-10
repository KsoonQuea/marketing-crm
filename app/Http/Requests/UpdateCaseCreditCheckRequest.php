<?php

namespace App\Http\Requests;

use App\Models\CaseCreditCheck;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateCaseCreditCheckRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_credit_check_edit');
    }

    public function rules()
    {
        return [
            'finding' => [
                'string',
                'nullable',
            ],
            'migration' => [
                'string',
                'nullable',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\CaseCreditCheckType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateCaseCreditCheckTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_credit_check_type_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}

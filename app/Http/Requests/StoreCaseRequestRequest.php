<?php

namespace App\Http\Requests;

use App\Models\CaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StoreCaseRequestRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_request_create');
    }

    public function rules()
    {
        return [
            'request' => [
                'string',
                'nullable',
            ],
            'facility_type' => [
                'string',
                'nullable',
            ],
            'amount' => [
                'numeric',
            ],
            'specific_concern' => [
                'string',
                'nullable',
            ],
        ];
    }
}

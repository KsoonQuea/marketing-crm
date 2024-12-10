<?php

namespace App\Http\Requests;

use App\Models\CaseList;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateCaseListRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_list_edit');
    }

    public function rules()
    {
        return [
            'case_code' => [
                'string',
                'nullable',
            ],
            'company_name' => [
                'string',
                'nullable',
            ],
            'incorporation_date' => [
                'date:',
                'nullable',
            ],
            'directors.*' => [
                'integer',
            ],
            'directors' => [
                'array',
            ],
            'application_types.*' => [
                'integer',
            ],
            'application_types' => [
                'array',
            ],
            'bfe' => [
                'string',
                'nullable',
            ],
            'applicaion_date' => [
                'date_format:'.config('panel.date_format'),
                'nullable',
            ],
            'remark' => [
                'string',
                'nullable',
            ],
            'address_1' => [
                'string',
                'nullable',
            ],
            'address_2' => [
                'string',
                'nullable',
            ],
            'postcode' => [
                'string',
                'nullable',
            ],
        ];
    }
}

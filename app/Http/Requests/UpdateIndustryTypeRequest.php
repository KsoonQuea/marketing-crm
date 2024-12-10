<?php

namespace App\Http\Requests;

use App\Models\IndustryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateIndustryTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('industry_type_edit');
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

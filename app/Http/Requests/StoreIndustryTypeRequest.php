<?php

namespace App\Http\Requests;

use App\Models\IndustryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StoreIndustryTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('industry_type_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\CaseGearing;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StoreCaseGearingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_gearing_create');
    }

    public function rules()
    {
        return [
            'borrow_item' => [
                'string',
                'nullable',
            ],
            'date' => [
                'date_format:'.config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
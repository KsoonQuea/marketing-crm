<?php

namespace App\Http\Requests;

use App\Models\ApplicationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StoreApplicationTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('application_type_create');
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

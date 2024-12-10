<?php

namespace App\Http\Requests;

use App\Models\ApplicationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyApplicationTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('application_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => [
                'required',
                'array',
            ],
            'ids.*' => [
                'exists:application_types,id',
            ],
        ];
    }
}

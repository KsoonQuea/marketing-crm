<?php

namespace App\Http\Requests;

use App\Models\FinancingInstrument;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFinancingInstrumentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('financing_instrument_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'exists:financing_instruments,id',
            ],
        ];
    }
}

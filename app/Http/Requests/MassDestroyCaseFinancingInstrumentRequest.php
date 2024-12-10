<?php

namespace App\Http\Requests;

use App\Models\CaseFinancingInstrument;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCaseFinancingInstrumentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('case_financing_instrument_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'exists:case_financing_instruments,id',
            ],
        ];
    }
}

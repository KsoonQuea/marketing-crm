<?php

namespace App\Http\Requests;

use App\Models\FinancingInstrument;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateFinancingInstrumentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('financing_instrument_edit');
    }

    public function rules()
    {
        return [
            'loan_product' => [
                'string',
                'nullable',
            ],
            'interest_rate' => [
                'numeric',
            ],
            'tenor' => [
                'string',
                'nullable',
            ],
        ];
    }
}

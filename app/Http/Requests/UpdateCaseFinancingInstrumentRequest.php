<?php

namespace App\Http\Requests;

use App\Models\CaseFinancingInstrument;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateCaseFinancingInstrumentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_financing_instrument_edit');
    }

    public function rules()
    {
        return [];
    }
}

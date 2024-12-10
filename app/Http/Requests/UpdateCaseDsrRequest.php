<?php

namespace App\Http\Requests;

use App\Models\CaseDsr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateCaseDsrRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_dsr_edit');
    }

    public function rules()
    {
        return [
            'dsr' => [
                'numeric',
            ],
        ];
    }
}

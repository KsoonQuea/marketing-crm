<?php

namespace App\Http\Requests;

use App\Models\CaseCallLog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateCaseCallLogRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_call_log_edit');
    }

    public function rules()
    {
        return [
            'datetime' => [
                'date_format:'.config('panel.date_format').' '.config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}

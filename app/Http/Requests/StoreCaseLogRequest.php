<?php

namespace App\Http\Requests;

use App\Models\CaseLog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StoreCaseLogRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_log_create');
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

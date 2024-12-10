<?php

namespace App\Http\Requests;

use App\Models\CaseCallLog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCaseCallLogRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('case_call_log_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'exists:case_call_logs,id',
            ],
        ];
    }
}

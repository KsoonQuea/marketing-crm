<?php

namespace App\Http\Requests;

use App\Models\UserCaseLog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyUserCaseLogRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_case_log_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'exists:user_case_logs,id',
            ],
        ];
    }
}

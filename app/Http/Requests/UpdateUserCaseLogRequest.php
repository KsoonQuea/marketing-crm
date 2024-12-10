<?php

namespace App\Http\Requests;

use App\Models\UserCaseLog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateUserCaseLogRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_case_log_edit');
    }

    public function rules()
    {
        return [
            'case_stage' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'action_status' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'action_remark' => [
                'string',
                'nullable',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\CaseManagementTeam;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StoreCaseManagementTeamRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_management_team_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'age' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'phone' => [
                'string',
                'nullable',
            ],
            'email' => [
                'string',
                'nullable',
            ],
            'designation' => [
                'string',
                'nullable',
            ],
            'shareholding' => [
                'numeric',
            ],
            'responsible_area' => [
                'string',
                'nullable',
            ],
            'experience_year' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'case_year' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'director_relationship' => [
                'string',
                'nullable',
            ],
        ];
    }
}

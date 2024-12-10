<?php

namespace App\Http\Requests;

use App\Models\UserTeam;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateUserTeamRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_team_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'team_members.*' => [
                'integer',
            ],
            'team_members' => [
                'array',
            ],
        ];
    }
}

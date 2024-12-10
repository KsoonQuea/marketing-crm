<?php

namespace App\Http\Requests;

use App\Models\UserTeam;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyUserTeamRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'exists:user_teams,id',
            ],
        ];
    }
}

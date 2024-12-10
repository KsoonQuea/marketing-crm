<?php

namespace App\Http\Requests;

use App\Models\CaseDirectorCommitment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateCaseDirectorCommitmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_director_commitment_edit');
    }

    public function rules()
    {
        return [
            'director_name' => [
                'string',
                'nullable',
            ],
        ];
    }
}

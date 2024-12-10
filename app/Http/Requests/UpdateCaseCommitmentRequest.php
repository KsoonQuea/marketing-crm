<?php

namespace App\Http\Requests;

use App\Models\CaseCommitment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateCaseCommitmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_commitment_edit');
    }

    public function rules()
    {
        return [];
    }
}

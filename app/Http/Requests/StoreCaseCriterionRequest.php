<?php

namespace App\Http\Requests;

use App\Models\CaseCriterion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StoreCaseCriterionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_criterion_create');
    }

    public function rules()
    {
        return [];
    }
}

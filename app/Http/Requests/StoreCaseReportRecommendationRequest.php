<?php

namespace App\Http\Requests;

use App\Models\CaseReportRecommendation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StoreCaseReportRecommendationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_report_recommendation_create');
    }

    public function rules()
    {
        return [];
    }
}

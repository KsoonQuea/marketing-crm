<?php

namespace App\Http\Requests;

use App\Models\CaseReportRecommendation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateCaseReportRecommendationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_report_recommendation_edit');
    }

    public function rules()
    {
        return [];
    }
}

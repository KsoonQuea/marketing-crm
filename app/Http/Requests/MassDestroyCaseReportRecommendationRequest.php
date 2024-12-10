<?php

namespace App\Http\Requests;

use App\Models\CaseReportRecommendation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCaseReportRecommendationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('case_report_recommendation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'exists:case_report_recommendations,id',
            ],
        ];
    }
}

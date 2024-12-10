<?php

namespace App\Http\Requests;

use App\Models\CaseDocument;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StoreCaseDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('case_document_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'nullable',
            ],
            'file' => [
                'array',
            ],
            'remark' => [
                'string',
                'nullable',
            ],
        ];
    }
}

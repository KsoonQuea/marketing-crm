<?php

namespace App\Http\Requests\Traits;

use Illuminate\Foundation\Http\FormRequest;

class ParseCsvImportCsvImportTraitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['csv_file' => [
            'mimes:csv,txt',
        ]];
    }
}

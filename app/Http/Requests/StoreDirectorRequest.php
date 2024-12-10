<?php

namespace App\Http\Requests;

use App\Models\Director;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StoreDirectorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('director_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'ic' => [
                'string',
                'required',
            ],
            'email' => [
                'string',
                'required',
            ],
            'phone' => [
                'string',
                'required',
            ],
            'address_1' => [
                'string',
                'required',
            ],
            'address_2' => [
                'string',
                'required',
            ],
            'postcode' => [
                'string',
                'required',
            ],
            'city' => [
                'string',
                'required',
            ],
            'gender' => [
                'string',
                'required',
            ],
            'marital_status' => [
                'string',
                'required',
            ],
            'country' => [
                'string',
                'required',
            ],
            'state' => [
                'string',
                'required',
            ],
        ];
    }
}

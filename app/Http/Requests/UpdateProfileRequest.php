<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('profile_password_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // dd(old->value);
        return [
            'name' => [
                'string',
                'required',
            ],
            'username' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:users,email,'.auth()->id(),
            ],
            'ic' => [
                'string',
                'required',
            ],
            'phone' => [
                'string',
                'required',
            ],
//            'address_1' => [
//                'string',
//                'required',
//            ],
//            'address_2' => [
//                'string',
//                'required',
//            ],
//            'postcode' => [
//                'string',
//                'required',
//            ],
//            'bank_owner' => [
//                'string',
//                'required',
//            ],
//            'bank_account' => [
//                'string',
//                'required',
//            ],
        ];
    }
}

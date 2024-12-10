<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
//            'username' => [
//                'string',
//                'required',
//            ],
            'email' => [
                'required',
                'unique:users,email,'.request()->route('user')->id,
            ],
            'roles.*' => [
                'integer',
                'required',
            ],
            'roles' => [
                'required',
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
//            'city' => [
//                'string',
//                'required',
//            ],
            'gender' => [
                'string',
                'required',
            ],
            'roles' => [
                'string',
                'required',
            ],
//            'country' => [
//                'string',
//                'required',
//            ],
//            'state' => [
//                'string',
//                'required',
//            ],
        ];
    }
}

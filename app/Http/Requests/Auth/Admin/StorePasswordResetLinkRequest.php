<?php

namespace App\Http\Requests\Auth\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePasswordResetLinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
'email' => [
'required',
'email',
],
];
    }
}

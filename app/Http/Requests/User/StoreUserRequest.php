<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'max:50', Rule::unique('users', 'username')],
            'password' => ['required', 'string', 'confirmed'],
            'name' => ['required', 'max:100'],
            'email' => ['required', 'max:100',  Rule::unique('users', 'email')],
        ];
    }
}

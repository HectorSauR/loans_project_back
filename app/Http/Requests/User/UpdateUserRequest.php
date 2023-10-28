<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user')['id'];

        return [
            'user' => [
                'sometimes',
                'max:100',
                Rule::unique('users', 'user')->ignore($userId),
            ],
            'password' => 'sometimes|max:20',
            'name' => 'sometimes',
            'email' => [
                'sometimes',
                Rule::unique('users', 'email')->ignore($userId),
            ],
        ];
    }
}

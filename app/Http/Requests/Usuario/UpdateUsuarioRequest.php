<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
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
        $userId = $this->route('usuario')['id'];

        return [
            'usuario' => [
                'sometimes',
                'max:100',
                Rule::unique('usuarios', 'usuario')->ignore($userId),
            ],
            'password' => 'sometimes|max:20',
            'nombre' => 'sometimes',
            'email' => [
                'sometimes',
                Rule::unique('usuarios', 'email')->ignore($userId),
            ],
        ];
    }
}

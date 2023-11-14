<?php

namespace App\Http\Requests\Debtor;

use App\Rules\UniqueTogether;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDebtorRequest extends FormRequest
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
        $debtorId = $this->route('debtor');
        return [
            "name" => ["sometimes", "string", "max:100", new UniqueTogether(
                'debtors',
                ['name', 'user_id'],
                'El nombre seleccionado ya fue tomado',
                $debtorId
            )],
            "address" => "sometimes|string|max:150",
            "max_active_loans" => "sometimes|integer"
        ];
    }
}

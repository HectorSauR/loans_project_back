<?php

namespace App\Http\Requests\Investor;

use App\Rules\DecimalRule;
use App\Rules\UniqueTogether;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvestorRequest extends FormRequest
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
            'name' => ['required', new UniqueTogether(
                'investors',
                ['name', 'user_id'],
                'El nombre seleccionado ya fue tomado'
            )],
            'available' => ['sometimes', new DecimalRule(10, 2)]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->userId,
        ]);
    }
}

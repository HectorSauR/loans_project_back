<?php

namespace App\Http\Requests\Invest;

use App\Rules\DecimalRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvestRequest extends FormRequest
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
        $user = $this->user();

        return [
            'total' => ['sometimes', new DecimalRule(10, 2)],
            'details' => ['sometimes', 'string'],
            'kind' => ['sometimes', Rule::in(['in', 'out'])],
            'investor_id' => [
                'required',
                'integer',
                Rule::exists('investors', 'id')->where('user_id', $user->id)
            ]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'investor_id' => $this->investorId,
        ]);
    }
}

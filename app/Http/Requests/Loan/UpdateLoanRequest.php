<?php

namespace App\Http\Requests\Loan;

use App\Rules\DecimalRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLoanRequest extends FormRequest
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
            'total' => ['sometimes', new DecimalRule(10, 2)],
            'interest' => ['sometimes', new DecimalRule(10, 2)],
            'deadline' => ['sometimes', Rule::in(['week', 'month'])],
            'guarantee' => ['sometimes'],
            'kind' => ['sometimes', Rule::in(['cash', 'card'])],
            'investor_id' => ['sometimes', 'exists:investors,id'],
            'debtor_id' =>['sometimes', 'exists:debtors,id']
        ];
    }
}

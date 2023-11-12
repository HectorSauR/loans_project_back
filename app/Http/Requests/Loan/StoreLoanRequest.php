<?php

namespace App\Http\Requests\Loan;

use App\Rules\DecimalRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLoanRequest extends FormRequest
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
            'total' => ['required', new DecimalRule(10, 2)],
            'interest' => ['required', new DecimalRule(10, 2)],
            'deadline' => ['required', Rule::in(['week', 'month'])],
            'guarantee' => ['required'],
            'kind' => ['required', Rule::in(['cash', 'card'])],
            'investor_id' => ['required', 'exists:investors,id'],
            'debtor_id' =>['required', 'exists:debtors,id']
        ];
    }
}

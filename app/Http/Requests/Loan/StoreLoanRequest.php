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
        $user = $this->user();

        return [
            'total' => ['required', new DecimalRule(10, 2)],
            'interest' => ['sometimes', new DecimalRule(10, 2)],
            'deadline' => ['sometimes', Rule::in(['week', 'month'])],
            'guarantee' => ['required'],
            'kind' => ['sometimes', Rule::in(['cash', 'card'])],
            'investor_id' => [
                'required',
                Rule::exists('investors', 'id')->where('user_id', $user->id)
            ],
            'debtor_id' => [
                'required',
                Rule::exists('debtors', 'id')->where('user_id', $user->id)
            ],
            'estimated_end_date' => ['required', 'date']
        ];
    }
}

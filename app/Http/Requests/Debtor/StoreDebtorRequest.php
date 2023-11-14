<?php

namespace App\Http\Requests\Debtor;

use App\Http\Requests\Loan\StoreLoanRequest;
use App\Models\User;
use App\Rules\DecimalRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDebtorRequest extends FormRequest
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
        // $user = $this->user();
        return [
            "name" => "required|string|max:100",
            "address" => "required|string|max:150",
            //loan data
            'loan.total' => ['required', new DecimalRule(10, 2)],
            'loan.interest' => ['sometimes', new DecimalRule(10, 2)],
            'loan.deadline' => ['sometimes', Rule::in(['week', 'month'])],
            'loan.guarantee' => ['required'],
            'loan.kind' => ['sometimes', Rule::in(['cash', 'card'])],
            'loan.investor_id' => [
                'required',
                Rule::exists('investors', 'id')->where('user_id', 1)
            ],
            'loan.estimated_end_date' => ['required', 'date']
        ];
    }
}

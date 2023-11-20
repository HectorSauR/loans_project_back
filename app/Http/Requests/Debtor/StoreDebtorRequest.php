<?php

namespace App\Http\Requests\Debtor;

use App\Http\Requests\Loan\StoreLoanRequest;
use App\Models\User;
use App\Rules\DecimalRule;
use App\Rules\UniqueTogether;
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
        $user = auth()->user();
        return [
            "name" => ["required", "string", "max:100", new UniqueTogether(
                'debtors',
                ['name', 'user_id'],
                'El nombre seleccionado ya fue tomado'
            )],
            "address" => "required|string|max:150",
            "max_active_loans" => "sometimes|integer",
            //loan data
            'loan.total' => ['required', new DecimalRule(10, 2)],
            'loan.interest' => ['sometimes', new DecimalRule(10, 2)],
            'loan.deadline' => ['sometimes', Rule::in(['week', 'month'])],
            'loan.guarantee' => ['required'],
            'loan.kind' => ['sometimes', Rule::in(['cash', 'card'])],
            'loan.investor_id' => [
                'required',
                Rule::exists('investors', 'id')->where('user_id', $user->id)
            ],
            'loan.estimated_end_date' => ['required', 'date']
        ];
    }
}

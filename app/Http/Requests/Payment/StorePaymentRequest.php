<?php

namespace App\Http\Requests\Payment;

use App\Rules\DecimalRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
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
            "total" => [new DecimalRule(10, 2), 'required'],
            'kind' => ['sometimes', Rule::in(['cash', 'card'])],
            'debtor_id' => [
                'required',
                Rule::exists('debtors', 'id')->where('user_id', $user->id)
            ]
        ];
    }
}

<?php

namespace App\Http\Requests\Investor;

use App\Rules\UniqueTogether;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateInvestorRequest extends FormRequest
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
        $investorId = $this->route('investor');

        return [
            'name' => ['required', 'max:100', new UniqueTogether(
                'investors',
                ['name', 'user_id'],
                'El nombre seleccionado ya fue tomado',
                $investorId
            )],
        ];
    }
}

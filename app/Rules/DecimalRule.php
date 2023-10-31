<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class DecimalRule implements ValidationRule
{
    /**
     * La precisión decimal requerida.
     *
     * @var int
     */
    private $max;
    private $decimals;
    private $is_negative;

    /**
     * Crea una nueva instancia de la regla de validación DecimalRule.
     *
     * @param int $precision
     */
    public function __construct(int $maxInteger, int $decimals, bool $is_negative = false)
    {
        $this->max = $maxInteger;
        $this->decimals = $decimals;
        $this->is_negative = $is_negative;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = "";
        if (!$this->is_negative) {
            $pattern = "/^\d{1,{$this->max}}(\.\d{{$this->decimals},{$this->decimals}})?$/";
        } else {
            $pattern = "/^-?\d{1,{$this->max}}(\.\d{{$this->decimals},{$this->decimals}})?$/";
        }
        $value = number_format($value, 2, ".", "");

        if (!preg_match($pattern, $value)) {
            $fail("El campo " . $attribute . " debe tener " . $this->decimals . " decimales y un máximo de " . $this->max . " dígitos en la parte entera." . ($this->is_negative ? "" : " No puede haber valores negativos"));
        }
    }
}

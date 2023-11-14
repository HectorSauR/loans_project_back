<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UniqueTogether implements ValidationRule
{
    protected $table;
    protected $columns;
    protected $excludeId;
    protected $message;
    protected $excludeName;

    public function __construct($table, array $columns, $message, $excludeId = null, $excludeName = 'id')
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->excludeId = $excludeId;
        $this->message = $message;
        $this->excludeName = $excludeName;
    }

    protected $columns_json = [
        'ejemplo_id' => 'ejemploId',
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = DB::table($this->table)->where(function ($query) {
            foreach ($this->columns as $column) {

                if (array_key_exists($column, $this->columns_json)) {
                    $value = request($this->columns_json[$column]);
                } else {
                    $value = request($column);
                }

                $query->where($column, $value);
            }
        });

        if ($this->excludeId) {
            $query->where($this->excludeName, '!=', $this->excludeId);
        }

        if(!($query->count() != 0)){
            $fail($this->message);
        }
    }
}
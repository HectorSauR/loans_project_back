<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserScoped implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Obtén el usuario autenticado o el usuario de alguna otra manera
        $user = auth()->user();

        // Si hay un usuario autenticado, aplica el ámbito
        if ($user) {
            $builder->where('user_id', $user->id);
        }
    }
}

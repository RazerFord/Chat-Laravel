<?php

namespace App\Models\Filters\User;

use App\Services\Filter\Filterable;
use Illuminate\Database\Eloquent\Builder;

class Name implements Filterable
{
    /**
     * Apply filter.
     * 
     * @param Builder
     * @param mixed
     * @return Builder
     */
    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->where('name', 'ilike', "%$value%");
    }

    /**
     * Rules validate filter.
     * 
     * @return string
     */
    public static function rules(): string
    {
        return 'required|string|max:255';
    }
}

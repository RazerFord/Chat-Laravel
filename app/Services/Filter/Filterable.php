<?php

namespace App\Services\Filter;

use Illuminate\Database\Eloquent\Builder;

interface Filterable
{
    /**
     * Apply filter.
     * 
     * @param Builder $request
     * @param mixed $value
     */
    public static function apply(Builder $builder, $value);

    /**
     * Rules validate filter.
     * 
     * @return string
     */
    public static function rules(): string;
}

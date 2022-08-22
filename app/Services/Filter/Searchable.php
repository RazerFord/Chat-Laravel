<?php

namespace App\Services\Filter;

use Illuminate\Http\Request;

interface Searchable
{
    /**
     * Call filter.
     * 
     * @param Request $request
     */
    public function apply(Request $request);
}
<?php

namespace App\Models\Filters\User;

use App\Models\User;
use App\Services\Filter\Searchable;
use App\Services\Filter\BaseSearch;

class UserFilter implements Searchable
{
    const MODEL = User::class;

    use BaseSearch {
        applyObjectsFromRequest as private applyObjectsFromRequestTrait;
    }
}

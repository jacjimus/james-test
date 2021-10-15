<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Companies extends AbstractModel
{
    use SoftDeletes;

    public function employees(): HasMany
    {
        return $this->HasMany(Employees::class, 'company_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employees extends AbstractModel
{
    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Companies::class)->withDefault();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Office extends Model
{
    use HasFactory;

    /**
     * Get the colleagues associated with the office.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function colleagues(): HasMany
    {
        return $this->hasMany(Colleague::class);
    }
}

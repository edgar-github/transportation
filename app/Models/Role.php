<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const ADMIN = 1;

    const DRIVER = 2;

    const CUSTOMER = 3;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function Users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }
}
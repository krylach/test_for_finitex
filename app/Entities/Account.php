<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}

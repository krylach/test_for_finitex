<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['currency_id', 'number', 'amount', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}

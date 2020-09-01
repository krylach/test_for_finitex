<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Account extends Model
{
    protected $fillable = ['currency_id', 'number', 'amount', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

    public function belongs($account)
    {
        return count(Auth::user()->accounts()->where('number', $account)->get()) > 0;
    }
}

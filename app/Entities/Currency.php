<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fields;

    public function accounts()
    {
        return $this->hasMany(Entities\Account::class, 'currency_id', 'id');
    }
}

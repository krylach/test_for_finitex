<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Currency extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    
    public static function ratio($currency_code)
    {
        return Http::get("https://bank.gov.ua/NBUStatService/v1/statdirectory/exchangenew?json&valcode={$currency_code}")
            ->json();
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Entities\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = ['USD', 'EUR', 'UAH'];
        DB::transaction(function () use ($currencies) {
            if ($currencies) {
                foreach ($currencies as $currency) {
                    Currency::create(['title' => $currency]);
                }
            }
        });
    }
}

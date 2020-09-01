<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Entities\Account;
use App\Entities\Currency;
use Faker\Provider\Payment;

class AccountController extends \App\Http\Controllers\Controller
{
    public function create(Request $request, Account $account)
    {
        $validator = Validator::make($request->only('currency'), [
            'currency' => 'required|exists:currencies,id'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        DB::transaction(function () use ($request, $account) {
            $account->create([
                'currency_id' => $request->currency,
                'user_id' => Auth::user()->id,
                'number' => Payment::creditCardNumber(),
                'amount' => mt_rand(100, 1000)
            ]); 
        });

        return redirect()->back();
    }

    public function transaction(Request $request, Account $account)
    {
        $validator = Validator::make($request->only('from', 'to', 'sum'), [
            'from'  => 'required|string|exists:accounts,number',
            'to'    => 'required|string|exists:accounts,number',
            'sum'   => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        if (!$account->belongs($request->from)) {
            return back()->withErros(['from' => ['Такого счёта не существует!']]);
        }

        if (!$this->enoughAmount($request->from, $request->sum)) {
            return back()->withErros(['sum' => ['Недостаточно средств на счету!']]);
        }

        $accountFrom    = $account->where('number', $request->from)->first();
        $accountTo      = $account->where('number', $request->to)->first();
        
        $accountFrom->amount = (float)$accountFrom->amount - (float)$request->sum;
        $accountTo->amount = (float)$accountTo->amount + $this->converse(
            $request->sum,
            $request->to,
            $request->from
        );

        $accountFrom->save();
        $accountTo->save();

        return redirect()->back();
    }

    /*
     *  For transaction
     */
    private function converse($sum, $to, $from)
    {
        return (float)($sum *
            $this->getRate(
                Account::where('number', $to)->first()->currency->title
            )
            /
            $this->getRate(
                Account::where('number', $from)->first()->currency->title
            ));
    }

    private function enoughAmount($account, $checkingSum)
    {
        return (float)Account::where('number', $account)->first()->amount >= (float)$checkingSum;
    }

    private function getRate($currency) 
    {
        $currencyValue = 1;
        if (isset(Currency::ratio($currency)[0])) {
            if ($rate = 1 / Currency::ratio($currency)[0]['rate']) {
                $currencyValue = $rate;
            }
        }

        return $currencyValue;
    }
}

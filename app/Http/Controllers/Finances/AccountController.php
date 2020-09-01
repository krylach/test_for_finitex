<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Entities\Account;
use Faker\Provider\Payment;

class AccountController extends \App\Http\Controllers\Controller
{
    public function create(Request $request, Account $account)
    {
        $validator = Validator::make($request->only('currency'), [
            'currency' => 'required|exists:currencies,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
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
}

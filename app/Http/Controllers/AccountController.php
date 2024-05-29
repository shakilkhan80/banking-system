<?php
// app/Http/Controllers/AccountController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;

class AccountController extends Controller
{
    public function index()
    {
        $account = Account::first();
        return view('account.index', compact('account'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $account          = Account::first();
        $account->balance += $request->amount;
        $account->save();

        Transaction::create([
            'account_id' => $account->id,
            'amount'     => $request->amount,
            'type'       => 'deposit',
        ]);

        return back()->with('success', 'Deposit successful!');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $account = Account::first();
        $amount  = $request->amount;
        $fee     = 0;

        if ($amount > 1000) {
            $fee = $amount * 0.02;
        } elseif ($amount >= 500) {
            $fee = $amount * 0.01;
        }

        $totalAmount = $amount + $fee;

        $todayWithdrawals = Transaction::where('account_id', $account->id)
            ->where('type', 'withdraw')
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        $monthlyWithdrawals = Transaction::where('account_id', $account->id)
            ->where('type', 'withdraw')
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        if ($totalAmount > $account->balance) {
            return back()->withErrors(['amount' => 'Insufficient balance.']);
        }

        if ($todayWithdrawals + $amount > 3000) {
            return back()->withErrors(['amount' => 'Daily withdrawal limit exceeded.']);
        }

        if ($monthlyWithdrawals >= 3) {
            $totalAmount += 5;
        }

        $account->balance -= $totalAmount;
        $account->save();

        Transaction::create([
            'account_id' => $account->id,
            'amount'     => $amount,
            'type'       => 'withdraw',
        ]);

        return back()->with('success', 'Withdrawal successful!');
    }
}

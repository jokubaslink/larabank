<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Stocks;
use App\Models\Transactions;
use App\Models\User;
use App\Models\Verifications;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function verify()
    {
        return view('profile.verify');
    }

    public function kyc()
    {
        return view('profile.identity');
    }

    public function verifyIdentity(Request $request)
    {

        $email = $request->email;
        $psw = $request->psw;

        $birthday = $request->birthdate;
        $age = Carbon::createFromFormat('Y-m-d', $birthday)->age;

        if ($email !== Auth::user()->email || !Hash::check($psw, Auth::user()->password)) {
            return redirect('/kyc')->with('error', 'Your email or password is incorrect');
        }

        if (Auth::user()->user_verified_at) {
            return redirect('/dashboard')->with('error', 'Your account is already verified');
        }

        if ($age < 18) {
            return redirect('/kyc')->with('error', 'You are too young to use our services');
        }

        if ($request->hasFile('id_picture')) {
            $imagePath = $request->file('id_picture')->store('verifyPics', 'public');

            Verifications::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'email' => $email,
                'birthday' => $birthday,
                'id_picture' => $imagePath,
            ]);

            return redirect('/dashboard')->with('success', 'Your identification has been submitted for review.');
        }
    }

    public function showCreditCard()
    {
        $user = Auth::user();
        $name = $user->name;
        $expiryDate = Carbon::createFromDate($user->user_verified_at)->addYears(4)->format('Y-m-d');
        $cardString = str_split($user->credit_card, 4);
        $creditCard = $cardString[0] . " " . $cardString[1] . " " . $cardString[2] . " " . $cardString[3];

        return view('profile.credit-card', ['name' => $name, 'credit_card' => $creditCard, 'expiryDate' => $expiryDate]);
    }

    public function showTransactions()
    {
        $transactions = Transactions::where('from_id', Auth::user()->credit_card)->orWhere('to_id', Auth::user()->credit_card)->get();

        return view('profile.transactions', compact('transactions'));
    }

    public function showTransaction()
    {
        return view('profile.transaction');
    }

    public function makeTransaction(Request $request)
    {

        $from_id = Auth::user()->credit_card;
        $to_id = $request->receive_id;

        if ($from_id === $to_id) {
            return redirect('/dashboard/transaction')->with('message', "You cannot send money to yourself");
        }

        $title = $request->title;
        $description = $request->description;
        $amount = (int) $request->amount;

        if (Auth::user()->balance < $amount) {
            return redirect('/dashboard/transaction')->with('message', "Not enough money");
        }

        Transactions::create([
            'from_id' => $from_id,
            'to_id' => $to_id,
            'title' => $title,
            'description' => $description,
            'amount' => $amount
        ]);

        $from_balance = User::where('credit_card', $from_id)->first()->balance;
        $to_balance = User::where('credit_card', $to_id)->first()->balance;

        User::where('credit_card', $from_id)->first()->update(['balance' => $from_balance - $amount]);
        User::where('credit_card', $to_id)->first()->update(['balance' => $to_balance + $amount]);

        return redirect('/dashboard/transaction')->with('message', 'The transaction has been succesful!');
    }

    public function showStocks()
    {
        $stocks = [
            ['key' => 'AAPL', 'price' => "172.92"],
            ['key' => 'TSLA', 'price' => "170.56"],
            ['key' => 'NVDA', 'price' => "935.69"],
            ['key' => 'INTC', 'price' => "42.40"],
            ['key' => 'AMZN', 'price' => "178.77"]
        ];
        /*         $yesterdayDate = Carbon::yesterday()->format('Y-m-d');
        // AAPL TSLA NVDA INTC AMZN 

        $aapl = Http::get('https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=AAPL&outputsize=full&apikey=U2O0B22OHQB4VAC7');
        $aaplPrice = $aapl["Time Series (Daily)"][$yesterdayDate]["4. close"];

        $stocks = [['key' => 'AAPL', 'price' => $aaplPrice]];
        $tsla = Http::get('https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=TSLA&outputsize=full&apikey=U2O0B22OHQB4VAC7');
        $tslaPrice = $tsla["Time Series (Daily)"][$yesterdayDate]["4. close"];

        $nvda = Http::get('https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=NVDA&outputsize=full&apikey=U2O0B22OHQB4VAC7');
        $nvdaPrice = $nvda["Time Series (Daily)"][$yesterdayDate]["4. close"];

        $intc = Http::get('https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=INTC&outputsize=full&apikey=U2O0B22OHQB4VAC7');
        $intcPrice = $intc["Time Series (Daily)"][$yesterdayDate]["4. close"];

        $amzn = Http::get('https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=AMZN&outputsize=full&apikey=U2O0B22OHQB4VAC7');
        $amznPrice = $amzn["Time Series (Daily)"][$yesterdayDate]["4. close"];

        $stocks = [
            ['key' => 'AAPL', 'price' => $aaplPrice],
            ['key' => 'TSLA', 'price' => $tslaPrice],
            ['key' => 'NVDA', 'price' => $nvdaPrice],
            ['key' => 'INTC', 'price' => $intcPrice],
            ['key' => 'AMZN', 'price' => $amznPrice]
        ]; */

        return view('profile.stocks', compact('stocks'));
    }

    public function buyStock(Request $request)
    {
        $user = Auth::user();
        $share_name = $request->share_name;
        $share_price = (float) $request->share_price;
        $share_amount = (float) $request->share_amount;
        $shares_sum = $share_amount * $share_price;

        $user_balance = (float) $user->balance - $shares_sum;

        if ($shares_sum > $user->balance) {
            return redirect('/dashboard/stocks')->with('message', 'You do not have enough money to buy ' . $share_amount . " shares of " . $share_name . " stock");
        }

        Stocks::create([
            'holder_id' => $user->id,
            'share_name' => $share_name,
            'share_amount' => $share_amount,
            'share_worth' => $shares_sum,
        ]);

        User::where('id', $user->id)->first()->update(['balance' => $user_balance]);

        return redirect('/dashboard/stocks')->with('message', 'Bought ' . $share_amount . " shares of " . $share_name . " stock for " . $shares_sum . ' $');
    }

    public function showPortfolio()
    {
        $stocks = [
            ['key' => 'AAPL', 'price' => "170.92"],
            ['key' => 'TSLA', 'price' => "175.56"],
            ['key' => 'NVDA', 'price' => "934.69"],
            ['key' => 'INTC', 'price' => "45.40"],
            ['key' => 'AMZN', 'price' => "179.77"]
        ];

        $user = Auth::user();
        $portfolio = Stocks::where('holder_id', $user->id)->get();

        return view('profile.portfolio', compact('portfolio', 'stocks'));
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Verifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function kycDashboard()
    {
        $haveSubmitted = Verifications::get();

        return view('admin.kyc', compact('haveSubmitted'));
    }

    public function kycVerify($user_id)
    {
        $user = User::where('id', $user_id)->first();
        $user_submitted = Verifications::where('user_id', $user_id)->first();

        if ($user->user_verified_at) {
            Verifications::where('user_id', $user_id)->delete();
            return redirect()->route('admin.kyc')->with('message', 'User was already verified');
        }

        $balance = 0;
        $credit_card = str_shuffle('0123456789013456789');

        $verifyDate = date('Y-m-d');

        $birthday = $user_submitted->birthday;

        User::find(auth()->user()->id)->update([
            'user_verified_at' => $verifyDate,
            'credit_card' => $credit_card,
            'birthday' => $birthday,
            'balance' => $balance
        ]);

        Verifications::where('user_id', $user_id)->delete();

        return redirect('/admin/dashboard/kyc')->with('message', 'User ' . $user->name . " has been verified!");
    }

    public function chat()
    {
        return view('admin.chat');
    }
}

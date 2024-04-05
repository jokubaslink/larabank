<?php

use App\Events\PusherEvent;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GPTController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\ChatMessages;
use App\Models\User;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    $user = Auth::user();

    return view('dashboard', compact('user'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->middleware(['auth', 'verified'])->name('admin.dashboard');
Route::get('/admin/dashboard/kyc', [AdminController::class, 'kycDashboard'])->middleware(['auth', 'verified'])->name('admin.kyc');
Route::post('/admin/dashboard/kyc/{user_id}', [AdminController::class, 'kycVerify'])->middleware(['auth', 'verified'])->name('admin.kycVerify');
Route::get('/admin/chat', [AdminController::class, 'chat'])->middleware(['auth', 'verified'])->name('admin.chat');

Route::get('/admin/chat/{id}', [AdminController::class, 'chatWindow'])->middleware(['auth', 'verified'])->name('admin.chatWindow');

Route::post('/admin/chat/send', function (Request $request) {
    $user_ids = User::pluck('id')->toArray();
    $admin_id = User::where('name', "admin")->first()->id;

    $ids = array_diff($user_ids, [$admin_id]);

    $count = count($ids);

    $message = $request->get('message');

    $id = $request->get('id');

    broadcast(new PusherEvent($message))->toOthers();

    ChatMessages::create([
        'from_id' => $message['from_id'],
        'to_id' => $message['to_id'],
        'text' => $message['text'],
    ]);

    return view('admin.chat', compact('id', 'message', 'ids', 'count'));
});
Route::post('/admin/chat/receive', function (Request $request) {
    $user_ids = User::pluck('id')->toArray();
    $admin_id = User::where('name', "admin")->first()->id;

    $ids = array_diff($user_ids, [$admin_id]);

    $count = count($ids);

    $message = $request->get('message');

    return view('admin.chat', compact(/* 'message',  */'ids', 'count'));
});

Route::get('/chat/fetch', function (Request $request) {
    $fromUser =  $request->get('from_id');
    $toUser =  $request->get('to_id');
    
    $userSentMessages = ChatMessages::where('from_id', $fromUser)->where('to_id', $toUser)->get()->toArray();
    $userReceivedMessages = ChatMessages::where('from_id', $toUser)->where('to_id', $fromUser)->get()->toArray();

    $chatMessages = array_merge($userSentMessages, $userReceivedMessages);

    return response()->json($chatMessages);
});
/* ADMIN  */

Route::get('/dashboard/advice', [ProfileController::class, 'showAdvice'])->middleware(['auth', 'verified'])->name('show.advice');
Route::get('/dashboard/stocks', [ProfileController::class, 'showStocks'])->middleware(['auth', 'verified'])->name('show.stocks');
Route::post('/dashboard/stocks', [ProfileController::class, 'buyStock'])->middleware(['auth', 'verified'])->name('stock.buy');
Route::get('/dashboard/portfolio', [ProfileController::class, 'showPortfolio'])->middleware(['auth', 'verified'])->name('portfolio.show');
Route::get('/dashboard/transactions', [ProfileController::class, 'showTransactions'])->middleware(['auth', 'verified'])->name('profile.transactions');
Route::get('/dashboard/credit-card', [ProfileController::class, 'showCreditCard'])->middleware(['auth', 'verified'])->name('profile.credit-card');
Route::get('/dashboard/transaction', [ProfileController::class, 'showTransaction'])->middleware(['auth', 'verified'])->name('reg.transaction');
Route::post('/dashboard/transaction', [ProfileController::class, 'makeTransaction'])->middleware(['auth', 'verified'])->name('make.transaction');

Route::get('/dashboard/advice', [GPTController::class, 'showAdvice'])->middleware(['auth', 'verified'])->name('profile.advice');
Route::post('/dashboard/get-advice', [GPTController::class, 'getAdvice'])->middleware(['auth', 'verified'])->name('profile.getAdvice');


Route::get('/about-us', function () {
    return view('about-us');
});

Route::get('/contact-us', function () {
    return view('contact-us');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/kyc', [ProfileController::class, 'kyc'])->name('profile.identity');
Route::post('/verifyIdentity', [ProfileController::class, 'verifyIdentity'])->name('kyc.verify');

Route::get('/verify', [ProfileController::class, 'verify'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

require __DIR__ . '/auth.php';

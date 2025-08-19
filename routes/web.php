<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
//
//Route::get('/register-page', function () {
//    return view('register');
//});
Route::get('/{any}', function () {
    return view('register');
})->where('any', '.*');
Route::get('/test-mail', function () {
    Mail::raw('code:1234', function ($message) {
        $message->to('mirshod@example.com')
            ->subject('Code:');
    });

    return 'Xabar yuborildi!';
});

<?php

use App\Http\Controllers\InfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(InfoController::class)
->name('user.')
->prefix('discord')
->middleware('apikey')
->group(function(){
    Route::post('incomming', 'todayCalendar')->name('todayCalendar');
    Route::post('whois','TeamInfo')->name('checkvar');

});

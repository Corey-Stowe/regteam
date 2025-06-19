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
Route::controller(InfoController::class)
->name('user.')
->prefix('discord')

->group(function(){
    Route::get('lastestmatch/{puuid}', 'RiotGetLastMatch')->name('TFTLastMatch');
    Route::get('lastestmatch/{id}', 'RiotGetLastMatchById')->name('TFTLastMatchById');
    Route::get('singlematchdetails/{id}/{discordID}', 'RiotGetMatchDetails')->name('TFTGetMatchDetails');
    Route::get('roundcompare/{matchid1}/{matchid2}/{discordid}', 'RiotGetRoundCompare')->name('TFTGetRoundCompare');
    Route::get('matchcompare/{calendarid1}/{calendarid2}/{discordid}', 'RiotGetMatchCompare')->name('TFTGetMatchCompare');

});

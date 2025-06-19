<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscordAuthController;
use App\Http\Controllers\DonnatController;
use App\Http\Controllers\JoinTeamController;
use App\Http\Controllers\MadeTeamController;
use App\Http\Controllers\TeamchoiesController;
use App\Http\Controllers\TeamLeaderController;
use App\Http\Controllers\tftController;

Route::controller(DiscordAuthController::class)
->group(function(){
    Route::get('/auth', 'AuthDiscorDetail');
});
Route::get('/', [MadeTeamController::class, 'index'])->name('selecthub')->middleware('login_check');
Route::get('/login', [MadeTeamController::class, 'login'])->name('login');
// route::get('/rules', [MadeTeamController::class, 'rules'])->name('rules');

Route::controller(MadeTeamController::class)
->name('reg.')
->prefix('register')
->middleware('login_check')
->group(function(){
    route::get('new_member','registertft')->name('new_member');
    Route::get('select', 'index')->name('select');
    Route::post('submit_tft', 'createRegistraion')->name('createRegistraion');
    // Route::get('new_team', 'newTeam')->name('new_team');
    // Route::post('create_team', 'create')->name('create_team');
    // Route::get('success/{id}', 'success')->name('success');
});

Route::controller(tftController::class)
->name('tft.')
->prefix('tft')
->middleware('login_check')
->group(function(){
    route::get('/', 'index')->name('index');
    route::post('unregister', 'unregister')->name('unregister');
    route::post('confirm\{id}', 'confirm')->name('confirm');
});

// Route::controller(JoinTeamController::class)
// ->name('join.')
// ->prefix('join')
// ->middleware('login_check')
// ->group(function(){
//    route::get('join-team', 'index')->name('join_team');
//    route::post('join-team', 'jointeam_code')->name('join_team_detail');
//    route::get('invite/{code}', 'invite')->name('invite');
//    route::post('join', 'Jointeam')->name('accept');
//    route::get('listteam', 'listteam')->name('listteam');
//    route::get('search', 'search')->name('search');


// });

// Route::controller(TeamLeaderController::class)
// ->name('leader.')
// ->prefix('leader')
// ->middleware(['login_check', 'team_leader'])
// ->group(function(){
//     route::get('dashboard', 'index')->name('dashboard');
//     route::post('delete-team', 'DeleteTeam')->name('delteam');
//     route::post('delete-member', 'DeleteMember')->name('delete_member');
//     route::post('approve-member', 'ApproveMember')->name('approve_member');
//     route::post('reject-member', 'RejectMember')->name('reject_member');
//     route::post('leave-team', 'LeaveTeam')->name('leave_team');
//     route::post('update-team', 'updateTeam')->name('updateTeam');
// });


Route::controller(DonnatController::class)
->name('donate.')
->prefix('donate')
->middleware(['login_check', 'team_leader'])
->group(function(){
    route::get('/', 'index')->name('donate');

});


Route::controller(AdminController::class)
->name('admin.')
->prefix('admin')
->middleware(['login_check', 'admin'])
->group(function(){
    route::get('/', 'index')->name('dash');
    route::post('add-donate', 'AddDonate')->name('add_donate');
    route::get('delete-donate', 'DeleteDonate')->name('delete_donate');
    route::post('add-calendar', 'AddCalendar')->name('add_calendar');
    route::get('team_detail/{team_id}', 'teamDetail')->name('team_detail');
    route::post('update-team', 'updateTeam')->name('updateTeam');
    route::get('randomTeam', 'randomTeamCalendar')->name('randomTeam');
    Route::Post('addCalendar','addCalendar')->name('addCalendar');
    Route::get('editCalendar/{id}','editCalendar')->name('editCalendar');
    Route::post('finduser','findUser')->name('findUser');
    Route::post('addUser','addUser')->name('joinGroup');
    Route::post('updateCalendar','updateCalendar')->name('updateCalendar');
    Route::get('deleteCalendar/{id}','deleteCalendar')->name('deleteCalendar');
    Route::post('addstrike','addStrike')->name('addStrike');
    Route::get('deleteStrike/{id}','deleteStrike')->name('deleteStrike');
    Route::Post('manualCalendar','manualCalendar')->name('manualCalendar');
    Route::Post('findUserGroup','findGroup')->name('findUserGroup');
    Route::get('MatchReport/{id}','MatchReport')->name('MatchReport');
    Route::get('addTftCalendar','addTftCalendar')->name('addTftCalendar');
    Route::post('addTftCalendar','storeTftCalendar')->name('store_calendar');
    Route::get('editTftCalendar/{id}','liveTftCalendar')->name('editTftCalendar');
    Route::post('updateTftCalendar','updateTftCalendar')->name('updateTftCalendar');
    Route::get('deleteTftCalendar/{id}','deleteTftCalendar')->name('deleteTftCalendar');
    Route::get('userDetail/{id}','userTftDetail')->name('userTftDetail');
    Route::get('userActivity/{id}','compareMatch')->name('userTftActivity');

});

// Route::controller(TeamchoiesController::class)
// ->name('vote.')
// ->prefix('vote')
// ->middleware(['login_check'])
// ->group(function () {
//     route::get('/', 'index')->name('index');
//     route::post('up-vote', 'vote')->name('vote');
// });

// Route::controller(TeamchoiesController::class)
// ->name('admin.vote.')
// ->prefix('admin/vote')

// ->middleware(['login_check', 'admin'])
// ->group(function () {
//     route::get('/', 'listVote')->name('listVote');
//     route::post('update', 'updadateVote')->name('update');

// });

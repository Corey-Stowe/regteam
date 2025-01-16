<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscordAuthController;
use App\Http\Controllers\JoinTeamController;
use App\Http\Controllers\MadeTeamController;
use App\Http\Controllers\TeamLeaderController;

Route::controller(DiscordAuthController::class)
->group(function(){
    Route::get('/auth', 'AuthDiscorDetail');
});
Route::get('/', [MadeTeamController::class, 'index'])->name('selecthub')->middleware('login_check');
Route::get('/login', [MadeTeamController::class, 'login'])->name('login');

Route::controller(MadeTeamController::class)
->name('reg.')
->prefix('register')
->middleware('login_check')
->group(function(){
    Route::get('select', 'index')->name('select');
    Route::get('new_team', 'newTeam')->name('new_team');
    Route::post('create_team', 'create')->name('create_team');
    Route::get('success/{id}', 'success')->name('success');
});

Route::controller(JoinTeamController::class)
->name('join.')
->prefix('join')
->middleware('login_check')
->group(function(){
   route::get('join-team', 'index')->name('join_team');
   route::post('join-team', 'jointeam_code')->name('join_team_detail');
   route::get('invite/{code}', 'invite')->name('invite');
   route::post('join', 'Jointeam')->name('accept');

});

Route::controller(TeamLeaderController::class)
->name('leader.')
->prefix('leader')
->middleware(['login_check', 'team_leader'])
->group(function(){
    route::get('dashboard', 'index')->name('dashboard');
    route::post('delete-team', 'DeleteTeam')->name('delteam');
    route::post('delete-member', 'DeleteMember')->name('delete_member');
    route::post('approve-member', 'ApproveMember')->name('approve_member');
    route::post('reject-member', 'RejectMember')->name('reject_member');
    route::post('leave-team', 'LeaveTeam')->name('leave_team');
});



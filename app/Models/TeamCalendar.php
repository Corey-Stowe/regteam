<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamCalendar extends Model
{
    protected $table = 'team_fight_calendar';

    protected $fillable = [
        'team_id_self',
        'team_id_opponent',
        'team_id_winner',
        'team_id_loser',
        'team_fight_date',
        'team_fight_status',
        'team_fight_note'
    ];



    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }

    public function listCalendarByTeam($team_id)
    {
        return $this->join('teams', 'team_fight_calendar.team_id_self', '=', 'teams.team_code')
        ->join('teams as opponent', 'team_fight_calendar.team_id_opponent', '=', 'opponent.team_code')
        ->join('users as opponent_leader', 'opponent.team_leader_discord_uid', '=', 'opponent_leader.discord_id')
        ->join('users', 'teams.team_leader_discord_uid', '=', 'users.discord_id')
        ->select(
            'team_fight_calendar.*',
            'teams.team_name as self_team_name',
            'teams.team_code as self_team_code',
            'opponent.team_name as opponent_team_name',
            'opponent.team_leader_name as opponent_team_leader_name',
           'users.name as self_team_leader_name',
           'opponent_leader.name as opponent_team_leader_name'
        )
        ->where('team_id_self', $team_id)->orWhere('team_id_opponent', $team_id)
        ->get();
    }
    public function listCalendarByTeamLast($team_id)
    {
        return $this->where('team_id_self', $team_id)->orWhere('team_id_opponent', $team_id)
        ->join('teams', 'team_fight_calendar.team_id_opponent', '=', 'teams.team_code')
        ->where('team_fight_date', '>', now())
        ->first();
    }


    public function addCalendar($data){
       return $this->create($data);
    }

    public function editCalendar($data, $id){
        return $this->where('id', $id)->update($data);
    }
    public function deleteCalendar($id){
        return $this->where('id', $id)->delete();
    }

    public function ListALLCalendar(){
        return $this->join('teams', 'team_fight_calendar.team_id_self', '=', 'teams.team_code')
            ->join('teams as opponent', 'team_fight_calendar.team_id_opponent', '=', 'opponent.team_code')
            ->join('users as opponent_leader', 'opponent.team_leader_discord_uid', '=', 'opponent_leader.discord_id')
            ->join('users', 'teams.team_leader_discord_uid', '=', 'users.discord_id')
            ->select(
                'team_fight_calendar.*',
                'teams.team_name as self_team_name',
                'teams.team_code as self_team_code',
                'opponent.team_name as opponent_team_name',
                'opponent.team_leader_name as opponent_team_leader_name',
               'users.name as self_team_leader_name',
               'opponent_leader.name as opponent_team_leader_name'
            )
            ->get();
    }
    public function getCalendarById($id){
        return $this->where('id', $id)->first();
    }
}

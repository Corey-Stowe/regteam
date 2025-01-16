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
        return $this->where('team_id_self', $team_id)->orWhere('team_id_opponent', $team_id)
        ->join('teams', 'team_fight_calendar.team_id_opponent', '=', 'teams.team_code')
        ->get();
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
}

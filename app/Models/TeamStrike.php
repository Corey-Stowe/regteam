<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamStrike extends Model
{
    protected $table = 'team_strike';
    protected $fillable = [
        'team_id',
        'strike_reason',
        'strike_note'
    ];



    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function listStrikeByTeam($team_id)
    {
        return $this->where('team_id', $team_id)->get();
    }

    public function addStrike($team_id, $strike_reason, $strike_note)
    {
        $this->team_id = $team_id;
        $this->strike_reason = $strike_reason;
        $this->strike_note = $strike_note;
        $this->save();
    }

    public function removeStrike($team_id, $strike_id)
    {
        $this->where('team_id', $team_id)->where('id', $strike_id)->delete();
    }
}

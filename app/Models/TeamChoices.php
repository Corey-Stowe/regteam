<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamChoices extends Model
{
    protected $table = "vote_win_team";
    protected $fillable = [
        "discord_id",
        "team_pepapig",
        "team_vuon_hoa",
        "created_at",
        "updated_at"
    ];



    public function addVote($discord_id, $team_pepapig, $team_vuon_hoa)
    {


            return $this->create([
                'discord_id' => $discord_id,
                'team_pepapig' => $team_pepapig,
                'team_vuon_hoa' => $team_vuon_hoa
            ]);

    }

    public function checkVote($discord_id)
    {
        return $this->where('discord_id', $discord_id)->first();
    }

    public function findWinner($team_pepapig,$team_vuon_hoa){
        return $this->where('team_pepapig', $team_pepapig)
        ->where('team_vuon_hoa', $team_vuon_hoa)
        ->orderBy('created_at', 'asc')
        ->get();
    }

    public function listVote(){
        return $this->join('users', 'users.discord_id', '=', 'vote_win_team.discord_id')
        ->select('vote_win_team.*', 'users.name')
        ->orderBy('created_at', 'asc')
        ->get();
    }
}

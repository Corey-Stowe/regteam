<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = [
        'team_name',
        'team_leader_name',
        'team_leader_email',
        'team_leader_phone',
        'team_leader_discord_uid',
        'tos_agreement',
        'team_status',
        'team_code',
        'visibility'
    ];

    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class);
    }

    public function createTeam($data)
    {
        return $this->create($data);
    }
    public function updateTeam($teamId, $data)
    {
        return $this->where('team_code', $teamId)->update($data);
    }

    public function checkVaildTeamCode($teamCode)
    {
        return $this->where('team_code', $teamCode)->count();
    }
    public function getTeamByCode($teamCode)
    {
        return $this->where('team_code', $teamCode)
        ->join('users', 'teams.team_leader_discord_uid', '=', 'users.discord_id')
        ->select('teams.*', 'users.discord_username', 'users.discord_id', 'users.avatar', 'users.name')
        ->first();
    }

    public function getTeamById($teamId)
    {
        return $this->where('id', $teamId)->first();
    }

    public function setRejectedTeam($teamId)
    {
        return $this->where('id', $teamId)->update(['team_status' => 'rejected']);
    }

    public function setApprovedTeam($teamId)
    {
        return $this->where('id', $teamId)->update(['team_status' => 'approved']);
    }
    public function checkHasCreatedTeam($discordId)
    {
        return $this->where('team_leader_discord_uid', $discordId)->count();
    }
    public function deleteTeam($teamId)
    {
        return $this->where('team_code', $teamId)->delete();
    }

    public function countToalTeams()
    {
        return $this->count();
    }

    Public function listTeams()
    {
        return $this->join('users', 'teams.team_leader_discord_uid', '=', 'users.discord_id')
        ->select('teams.*', 'users.name')
        ->withCount('teamMembers')
        ->get();
    }

    public function TeamDetails($team_code)
    {
        return $this->where('teams.team_code', $team_code)
        ->join('users', 'teams.team_leader_discord_uid', '=', 'users.discord_id')
        ->select('teams.*', 'users.discord_username')
        ->first();
    }
    public function editTeam($teamId, $data)
    {
        return $this->where('id', $teamId)->update($data);
    }
    public function listFullTeams(){
        //include count toal members
        return $this->join('users', 'teams.team_leader_discord_uid', '=', 'users.discord_id')
        ->select('teams.*', 'users.name')
        ->withCount('teamMembers')
        ->paginate(15);
    }

    public function searchTeam($search)
    {
        return $this->join('users', 'teams.team_leader_discord_uid', '=', 'users.discord_id')
        ->select('teams.*', 'users.name')
        ->where('teams.team_name', 'like', '%'.$search.'%')
        ->orWhere('teams.team_code', 'like', '%'.$search.'%')
        ->withCount('teamMembers')
        ->first();
    }

}

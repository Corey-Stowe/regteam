<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = 'team_members';

    protected $fillable = [
        'team_id',
        'discord_uid',
        'is_leader',
        'status',
        'team_code',
    ];


    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function createTeamMember($data)
    {
        return $this->create($data);
    }
    public function deleteMember($teamId, $discordId)
    {
        return $this->where('team_code', $teamId)->where('discord_uid', $discordId)->delete();
    }
    public function getTeamMembers($teamId)
    {
        return $this->where('team_code', $teamId)
        ->join('users', 'team_members.discord_uid', '=', 'users.discord_id')
        ->orderBy('team_members.created_at', 'asc')
        ->get();
    }
    public function SetAprovedMember($teamId, $discordId)
    {
        return $this->where('team_code', $teamId)->where('discord_uid', $discordId)->update(['status' => 'accepted']);
    }
    public function SetRejectedMember($teamId, $discordId)
    {
        return $this->where('team_code', $teamId)->where('discord_uid', $discordId)->update(['status' => 'rejected']);
    }
    public function countTeamMembers($teamId)
    {
        return $this->where('team_code', $teamId)->count();
    }
    public function checkAlreadyMember($teamId, $discordId)
    {
        return $this->where('team_code', $teamId)->where('discord_uid', $discordId)->count();
    }
    public function checkJoinedTeam($discordId)
    {
        return $this->where('discord_uid', $discordId)->count();
    }
    public function getTeamCodebyDiscordId($discordId)
    {
        return $this->where('discord_uid', $discordId)->first();
    }

    public function getTeamLeaderInfo($teamId)
    {
        return $this->where('team_code', $teamId)->where('is_leader', 1)
        ->join('users', 'team_members.discord_uid', '=', 'users.discord_id')
        ->first();
    }
    public function hasJoinedTeam($discordId)
    {
        return $this->where('discord_uid', $discordId)->count();
    }

    public function leaveTeam($discordId, $teamId)
    {
        return $this->where('discord_uid', $discordId)->where('team_code', $teamId)->delete();
    }

    public function isLeader($discordId)
    {
        return $this->where('discord_uid', $discordId)->where('is_leader', 1)->count();
    }
}

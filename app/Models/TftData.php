<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TftData extends Model
{
    protected $table = 'tft_data';
    protected $primaryKey = 'data_id';
    public $timestamps = true;

    protected $fillable = [
        'discord_id',
        'calendar_id',
        'tft_rank',
        'tft_points',
        'tft_division',
        'api_placement',
        'api_level',
        'api_gold_left',
        'api_last_round',
        'api_total_damage',
        'api_players_eliminated',
        'api_game_length',
        'api_game_datetime',
        'api_traits',
        'api_units'
    ];


    public function addTftData($data)
    {
       return $this->insert($data);
    }
    public function getTftDataByDiscordId($discordId)
    {
        return self::where('discord_id', $discordId)->first();
    }
    public function updateTftData($discordId, $tftRank, $tftPoints, $tftDivision)
    {
        $tftData = self::where('discord_id', $discordId)->first();
        if ($tftData) {
            $tftData->update([
                'tft_rank' => $tftRank,
                'tft_points' => $tftPoints,
                'tft_division' => $tftDivision,
            ]);
            return $tftData;
        }
        return null;
    }
    public function deleteTftData($discordId)
    {
        $tftData = self::where('discord_id', $discordId)->first();
        if ($tftData) {
            $tftData->delete();
            return true;
        }
        return false;
    }
    public function getAllTftData()
    {
        return self::all();
    }
    public function getTftDataByCalendarId($calendarId)
    {
        return self::where('calendar_id', $calendarId)->first();
    }

    public function getHistoryByDiscordId($discordId)
    {
        return self::where('discord_id', $discordId)->get();
    }
    public function getMatchListByDiscordId($discordId)
    {
        return $this->where('discord_id', $discordId)
            ->select('api_placement', 'api_level', 'api_gold_left', 'api_last_round', 'api_total_damage', 'api_players_eliminated', 'api_game_length', 'api_game_datetime')
            ->get();
    }

 public function getEventDatabyDiscordId($discordId)
{
    return $this->where('discord_id', $discordId)
        ->whereNotNull('tft_calendar.calendar_id')
        ->join('tft_calendar', 'tft_data.calendar_id', '=', 'tft_calendar.calendar_id')
        ->select(
            'tft_data.*',
            'tft_calendar.event_name',
            'tft_calendar.event_date',
            'tft_calendar.event_location',
            'tft_calendar.event_description'
        )
        ->orderBy('tft_data.created_at', 'desc')
        ->get()
        ->unique('calendar_id') // lọc sau khi lấy
        ->values(); // reset lại chỉ số
}
public function getMatchResluts($id, $discordId)
    {
        return $this->where('data_id', $id)
            ->where('discord_id', $discordId)
            ->first();
    }



public function getRoundCompare($matchId1, $matchId2, $discordId){
        return $this->where('discord_id', $discordId)
            ->whereIn('data_id', [$matchId1, $matchId2])
            ->get();
}

public function getMatchCompare($calendarId1, $calendarId2, $discordId)
    {
        return $this->where('discord_id', $discordId)
            ->whereIn('calendar_id', [$calendarId1, $calendarId2])
            ->get();
    }
public function getListToalPoint(){
    return $this->select('discord_id', 'tft_points')
        ->groupBy('discord_id')
        ->orderBy('tft_points', 'desc')
        ->get();

 }
}

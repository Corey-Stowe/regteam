<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TFTCalenderDetails extends Model
{
    protected $table = 'tft_calendar_details';
    protected $primaryKey = 'calendar_details_id';
    public $incrementing = true;

    protected $fillable = [
        'calendar_id',
        'discord_id',
        'is_confirmed',
    ];

    public function calendar()
    {
        return $this->belongsTo(TFTCalender::class, 'calendar_id', 'calendar_id');
    }

    public function getCalenderDetailsByDiscordId($discord_id)
    {
        return $this->where('discord_id', $discord_id)
        ->join('tft_calendar', 'tft_calendar_details.calendar_id', '=', 'tft_calendar.calendar_id')
        ->get();
    }
    public function createCalenderDetails($data)
    {
        return $this->create($data);
    }


    public function getMember($calendar_id)
    {
        return $this->where('calendar_id', $calendar_id)->join('tft_register', 'tft_calendar_details.discord_id', '=', 'tft_register.discord_id')
        ->select('tft_register.*', 'tft_calendar_details.is_confirmed')
        ->get();
    }
}

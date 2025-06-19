<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tft;

class TFTCalender extends Model
{
    protected $table = 'tft_calendar';
    protected $primaryKey = 'calendar_id';

    protected $fillable = [
        'event_name',
        'event_date',
        'event_location',
        'event_description',
        'is_confirmed',
        'is_cancelled'
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'is_confirmed' => 'boolean',
        'is_cancelled' => 'boolean'
    ];


    public function getCalenderUser($discord_id)
    {
        return $this->where('discord_id', $discord_id)->get();
    }
    public function createEvent($data)
    {
        return $this->create($data);
    }
    public function updateEvent($calendar_id, $data)
    {
        return $this->where('calendar_id', $calendar_id)->update($data);
    }
    public function deleteEvent($calendar_id)
    {
        return $this->where('calendar_id', $calendar_id)->delete();
    }
    public function getEventById($calendar_id)
    {
        return $this->where('calendar_id', $calendar_id)->first();
    }
    public function listEvents()
    {
        return $this->orderBy('event_date', 'asc')->get();
    }
    public function getLastEventID()
    {
        return $this->orderBy('calendar_id', 'desc')->first();
    }
    public function getCalendaterDetails($calendar)
    {
        return $this->where('calendar_id', $calendar)->get();
    }
    public function confirmedEvnts($calendar_id)
    {
        return $this->where('calendar_id', $calendar_id)->where('is_cancelled', true)->get();
    }



}

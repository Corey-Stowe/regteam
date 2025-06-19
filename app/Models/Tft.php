<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tft extends Model
{
    protected $table = "tft_register";
    protected $fillable = [
        "discord_id",
        "riotname_id",
        "riotname_tag",
        "puuid",
        "join_type",
        "fullname",
        "phonenumber",
        "DoB",
        "id_number",
        "register_date",
        "bank_account_number",
        "bank_account_name",
        "bank_name",
        "is_in_calendar",
        "is_excluded",
        "tos_accepted"
    ];

    public function registerTft($data)
    {
        return $this->create($data);
    }

    public function checkRegistration($discord_id)
    {
        return $this->where('discord_id', $discord_id)->first();
    }
    public function updateRegistration($discord_id, $data)
    {
        return $this->where('discord_id', $discord_id)->update($data);
    }
    public function deleteRegistration($discord_id)
    {
        return $this->where('discord_id', $discord_id)->delete();
    }
    public function listRegistrations()
    {
        return $this->orderBy('register_date', 'desc')
        ->join('users', 'tft_register.discord_id', '=', 'users.discord_id')
        ->select('tft_register.*', 'users.email', 'users.name', 'users.avatar')
        ->where('tft_register.is_in_calendar', false)
        ->where('tft_register.is_excluded', false)
        ->get();
    }
    public function findByRiotName($riotname_id)
    {
        return $this->where('riotname_id', $riotname_id)->first();
    }
    public function getRegisterInfo($discord_id)
    {
        return $this->where('tft_register.discord_id', $discord_id)->join('users', 'tft_register.discord_id', '=', 'users.discord_id')
            ->select('tft_register.*', 'users.email', 'users.avatar')
        ->first();
    }

    public function setIsInCalendar($discord_id, $isInCalendar)
    {
        return $this->where('discord_id', $discord_id)->update(['is_in_calendar' => $isInCalendar]);
    }
    public function setIsExcluded($discord_id, $isExcluded)
    {
        return $this->where('discord_id', $discord_id)->update(['is_excluded' => $isExcluded]);
    }
}

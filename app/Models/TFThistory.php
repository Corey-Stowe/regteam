<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tft;
class TFThistory extends Model
{
    protected $table = 'tft_data';
    protected $primaryKey = 'data_id';

    protected $fillable = [
        'discord_id',
        'register_id',
        'calendar_id',
        'tft_rank',
        'tft_points',
        'tft_division'
    ];

    protected $casts = [
        'tft_points' => 'integer'
    ];

    public function register()
    {
        return $this->belongsTo(Tft::class, 'register_id', 'register_id');
    }

    public function calendar()
    {
        return $this->belongsTo(TFTCalender::class, 'calendar_id', 'calendar_id');
    }

    public function getToalPointsByDiscordId($discord_id)
    {
        return $this->where('discord_id', $discord_id)
            ->sum('tft_points');
    }
    public function getHistoryByDiscordId($discord_id)
    {
        return $this->where('discord_id', $discord_id)
            ->with(['register', 'calendar'])
            ->orderBy('data_id', 'desc')
            ->get();
    }

    public function getTotalPointsByAllPlayers()
    {
        return $this->join('users', 'tft_data.discord_id', '=', 'users.discord_id')
            ->selectRaw('tft_data.discord_id, SUM(tft_points) as total_points, users.name, users.avatar')
            ->groupBy('tft_data.discord_id', 'users.name', 'users.avatar')
            ->orderBy('total_points', 'desc')
            ->get();
    }

}

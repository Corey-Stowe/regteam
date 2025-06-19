<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TftMatchResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'data_id' => $this->data_id,
            'discord_id' => $this->discord_id,
            'calendar_id' => $this->calendar_id,
            'tft_rank' => $this->tft_rank,
            'tft_points' => $this->tft_points,
            'tft_division' => $this->tft_division,
            'api_placement' => $this->api_placement,
            'api_level' => $this->api_level,
            'api_gold_left' => $this->api_gold_left,
            'api_last_round' => $this->api_last_round,
            'api_total_damage' => $this->api_total_damage,
            'api_players_eliminated' => $this->api_players_eliminated,
            'api_game_length' => $this->api_game_length,
            'api_game_datetime' => $this->api_game_datetime,
            'api_traits' => is_string($this->api_traits) ? json_decode($this->api_traits, true) : $this->api_traits,
            'api_units' => is_string($this->api_units) ? json_decode($this->api_units, true) : $this->api_units,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

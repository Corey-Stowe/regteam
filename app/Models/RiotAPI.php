<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiotAPI extends Model
{

    public function __construct()
    {
        $this->apiKey = env('RIOT_DEVELOPER_KEY');
        $this->baseUrl = env('RIOT_API_BASE_URL', 'https://asia.api.riotgames.com');
        $this->matchBaseUrl = env('RIOT_MATCH_API_BASE_URL', 'https://sea.api.riotgames.com');


    }



    public function getPuuid($nametag, $tagline)
    {
        $ch = curl_init();
           $encodedNametag = rawurlencode($nametag);
        $encodedTagline = rawurlencode($tagline);
        $url = $this->baseUrl . '/riot/account/v1/accounts/by-riot-id/' . $encodedNametag . '/' . $encodedTagline . '?api_key=' . $this->apiKey;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        if (isset($data['puuid'])) {
            return $data['puuid'];
        } else {
            return null; // or handle the error as needed
        }
    }

    public function getLastedMatchIDByPuuid($puuid)
    {
        $ch = curl_init();
        $url = $this->matchBaseUrl . '/tft/match/v1/matches/by-puuid/' . $puuid . '/ids?count=1&api_key=' . $this->apiKey;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CAINFO, storage_path('cacert.pem'));
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        return $data[0] ?? null;
    }
    public function getMatchDetails($matchId)
    {
        $ch = curl_init();
        $url = $this->matchBaseUrl . '/tft/match/v1/matches/' . $matchId . '?api_key=' . $this->apiKey;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CAINFO, storage_path('cacert.pem'));
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}

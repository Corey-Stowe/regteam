<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class tftController extends Controller
{
    private $tftplayer;
    private $tftcalender;
    private $tftcalenderdetails;
    private $tftdata;
    private $session;
    private $matchHistory;
    public function __construct()
    {
        $this->tftplayer = new \App\Models\Tft();
        $this->tftcalender = new \App\Models\TFTCalender();
        $this->tftdata = new \App\Models\TFThistory();
        $this->tftcalenderdetails = new \App\Models\TFTCalenderDetails();
        $this->matchHistory = new \App\Models\TftData();
        $this->session = Auth::user();
    }
    public function index()
    {
        $playerinfo = $this->tftplayer->getRegisterInfo($this->session->discord_id);
        if (!$playerinfo) {
            return redirect()->route('reg.new_member')->with('error', 'Bạn chưa đăng ký sự kiện.');
        }
        $calender = $this->tftcalenderdetails->getCalenderDetailsByDiscordId($this->session->discord_id);
        $tftdata = $this->tftdata->getHistoryByDiscordId($this->session->discord_id);
        $toalPoints = $this->tftdata->getToalPointsByDiscordId($this->session->discord_id);
        $matchplayerHistory = $this->matchHistory->getHistoryByDiscordId($this->session->discord_id);
        return view('tft.index', [
            'playerinfo' => $playerinfo,
            'calender' => $calender,
            'tftdata' => $tftdata,
            'toalPoints' => $toalPoints
            , 'matchplayerHistory' => $matchplayerHistory
        ]);
    }
    public function unregister(Request $request)
    {
        $this->tftplayer->where('discord_id', $this->session->discord_id)->delete();
        return redirect()->route('reg.select')->with('success', 'Bạn đã hủy đăng ký thành công.');
    }
}

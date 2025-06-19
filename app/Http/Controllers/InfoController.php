<?php

namespace App\Http\Controllers;
use App\Models\TeamCalendar;
use App\Models\TeamMember;
use App\Models\Team;
use App\Models\TeamStrike;
use App\Models\TftData;
use Illuminate\Http\Request;
use App\Models\RiotAPI;
use App\Models\TFTCalender;
use App\Http\Resources\TftMatchResource;
class InfoController extends Controller
{

    protected $riotAPI;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $tftData;
    protected $tftCalendar;
    public function __construct()
    {
        $this->riotAPI = new RiotAPI();
        $this->tftData = new TftData();
        $this->tftCalendar = new TFTCalender();
    }


    /**
     * Display a listing of the resource.
     */
    public function todayCalendar(Request $request)
    {
        $discord_id = $request->discord_id;
        $team_members = new TeamMember();
        $Team = new Team();
        $team_code = $team_members->getTeamCodebyDiscordId($discord_id);

        if(!$team_code){
            return response()->json(['message' => 'Bạn chưa tham gia nhóm hoặc chưa đăng ký sự kiện'], 404);
        }

        $teamCalendar = new TeamCalendar();
        $team_calendar = $teamCalendar->listCalendarByTeamLast($team_code->team_code);
        if(!$team_calendar){
            return response()->json([
                'message' => 'Bạn chưa có lịch thi đấu !'
            ],200);
        }
        $calendar_data = $teamCalendar->getCalendarById($team_calendar->first()->id);
        $opponent = $Team->getTeamByCode($calendar_data->team_id_opponent);
        $self = $Team->getTeamByCode($calendar_data->team_id_self);
        return response()->json(
            [
                'calendar_info' => $calendar_data,
                'opponent' => $opponent,
                'self' => $self
            ]
         );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function TeamInfo(Request $request)
    {
        $keyword = $request->keywrd;
        $team = new Team();
        $team_data = $team->searchTeam($keyword);
        if(!$team_data){
            return response()->json(['
            message' => 'Không có kết quả'
        ],404);
        }
        return response()->json($team_data);
    }

    public function RiotGetLastMatch($puuid)
    {
        $last_match_id = $this->riotAPI->getLastedMatchIDByPuuid($puuid);
        if(!$last_match_id){
            return response()->json(['message' => 'Không tìm thấy trận đấu gần nhất'], 404);
        }
        $match_details = $this->riotAPI->getMatchDetails($last_match_id);
        if(!$match_details){
            return response()->json(['message' => 'Không tìm thấy thông tin trận đấu'], 404);
        }
        return response()->json($match_details);
    }
public function RiotGetMatchDetails($id, $discordID)
{
    $match_details = $this->tftData->getMatchResluts($id, $discordID);

    if (!$match_details) {
        return response()->json(['message' => 'Không tìm thấy dữ liệu trận đấu'], 404);
    }
        if (is_array($match_details) || $match_details instanceof \Illuminate\Support\Collection) {
        return TftMatchResource::collection($match_details);
    }

    // Handle single record
    return new TftMatchResource($match_details);


}
public function RiotGetRoundCompare($matchid1, $matchid2, $discordid)
{
    $round_compare = $this->tftData->getRoundCompare($matchid1, $matchid2, $discordid);

    if (!$round_compare) {
        return response()->json(['message' => 'Không tìm thấy dữ liệu so sánh vòng đấu'], 404);
    }

    // Handle collection of records
    if (is_array($round_compare) || $round_compare instanceof \Illuminate\Support\Collection) {
        return TftMatchResource::collection($round_compare);
    }

    // Handle single record
    return new TftMatchResource($round_compare);
}


public function RiotGetMatchCompare($calendarid1, $calendarid2, $discordid)
{
    $match_compare = $this->tftData->getMatchCompare($calendarid1, $calendarid2, $discordid);

    if (!$match_compare) {
        return response()->json(['message' => 'Không tìm thấy dữ liệu so sánh trận đấu'], 404);
    }

    // Handle collection of records
    if (is_array($match_compare) || $match_compare instanceof \Illuminate\Support\Collection) {
        return TftMatchResource::collection($match_compare);
    }

    // Handle single record
    return new TftMatchResource($match_compare);
}
}

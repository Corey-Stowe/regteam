<?php

namespace App\Http\Controllers;
use App\Models\TeamCalendar;
use App\Models\TeamMember;
use App\Models\Team;
use App\Models\TeamStrike;
use Illuminate\Http\Request;


class InfoController extends Controller
{
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



}

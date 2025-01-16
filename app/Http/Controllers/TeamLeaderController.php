<?php

namespace App\Http\Controllers;

use App\Models\TeamCalendar;
use App\Models\TeamMember;
use App\Models\Team;
use App\Models\TeamStrike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamLeaderController extends Controller
{
    public function index()
    {
        $team_members = new TeamMember();
        $isleader = $team_members->isLeader(Auth::user()->discord_id);
        // dd($isleader);
        $team_code = $team_members->getTeamCodebyDiscordId(Auth::user()->discord_id);
        $team_members = $team_members->getTeamMembers($team_code->team_code);

        $team = new Team();
        $team_info = $team->getTeamByCode($team_code->team_code);

        $teamStrike =  new TeamStrike();
        $team_strikes = $teamStrike->listStrikeByTeam($team_info->id);

        $teamCalendar = new TeamCalendar();
        $team_calendar = $teamCalendar->listCalendarByTeam($team_code->team_code);

        if($isleader){
            return view('teamManger.list', compact('team_members','team_info','team_strikes','team_calendar'));
        } else {
            return view('teamManger.memberList', compact('team_members','team_info','team_strikes','team_calendar'));
        }
    }


    public function DeleteTeam(Request $request)
    {
        $team = new Team();
        $team->deleteTeam($request->team_id);
        return redirect()->route('selecthub')->with('success', 'Đã xóa nhóm');
    }

    public function DeleteMember(Request $request)
    {
       //dd($request->all());
        $teamMember = new TeamMember();
        $teamMember->deleteMember($request->team_id, $request->discord_id);
        return redirect()->route('leader.dashboard')->with('success', 'Đã xóa thành viên');
    }

    public function ApproveMember(Request $request)
    {
        $teamMember = new TeamMember();
       //dd($request->all());
        $teamMember->SetAprovedMember($request->team_id, $request->discord_id);
        return redirect()->route('leader.dashboard')->with('success', 'Đã chấp nhận thành viên');
    }

    public function RejectMember(Request $request)
    {
        $teamMember = new TeamMember();
        $teamMember->SetRejectedMember($request->team_id, $request->discord_id);
        return redirect()->route('leader.dashboard')->with('success', 'Đã từ chối thành viên');
    }

    public function LeaveTeam(Request $request)
    {
        $teamMember = new TeamMember();
        try{
            $teamMember->leaveTeam( Auth::user()->discord_id,$request->team_id);
        } catch (\Exception $e) {
           dd($e->getMessage());
        }
         return redirect()->route('selecthub')->with('success', 'Đã rời nhóm');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JoinTeamController extends Controller
{
    public function invite($code)
    {
        $team = new Team();
        $team_member = new TeamMember();
        $is_valid = $team->checkVaildTeamCode($code);

        if ($is_valid == 0) {
            return redirect()->route('join.join_team')->with('error', 'Mã nhóm không hợp lệ');
        }
        $team_count = $team_member->countTeamMembers($code);
        if ($team_count >= 5) {
            return redirect()->route('join.join_team')->with('error', 'Nhóm đã đủ thành viên');
        }
        $arlredy_joined_team = $team_member->checkAlreadyMember($code, Auth::user()->discord_id);
        if ($arlredy_joined_team == 1) {
            return redirect()->route('join.join_team')->with('error', 'Bạn đã tham gia nhóm này');
        }
        $arlredy_joined = $team_member->checkJoinedTeam(Auth::user()->discord_id);
        if ($arlredy_joined == 1) {
            return redirect()->route('join.join_team')->with('error', 'Bạn đã tham gia nhóm khác');
        }

        $team_data = $team->getTeamByCode($code);
        return view('join.tos', compact('team_data'));
    }

    public function index ()
    {
        return view('join.code');
    }

    public function jointeam_code(Request $request)
    {
        $request->validate([
            'team_code' => 'required|string|max:255',
        ], [
            'team_code.required' => 'Vui lòng nhập mã nhóm',
            'team_code.string' => 'Mã nhóm phải là chuỗi',
            'team_code.max' => 'Mã nhóm không được vượt quá 255 ký tự',
        ]);

        $team_code = $request->team_code;
        $team = new Team();
        $team_member = new TeamMember();
        $is_valid = $team->checkVaildTeamCode($team_code);

        if ($is_valid == 0) {
            return redirect()->route('join.join_team')->with('error', 'Mã nhóm không hợp lệ');
        }
        $team_count = $team_member->countTeamMembers($team_code);
        //dd($team_count);
        if ($team_count >= 5) {
            return redirect()->route('join.join_team')->with('error', 'Nhóm đã đủ thành viên');
        }
        $arlredy_joined_team = $team_member->checkAlreadyMember( $team_code, Auth::user()->discord_id);
        if ($arlredy_joined_team == 1) {
            return redirect()->route('join.join_team')->with('error', 'Bạn đã tham gia nhóm này');
        }
        $arlredy_joined = $team_member->checkJoinedTeam(Auth::user()->discord_id);
        if ($arlredy_joined == 1) {
            return redirect()->route('join.join_team')->with('error', 'Bạn đã tham gia nhóm khác');
        }

        $team_data = $team->getTeamByCode($team_code);
        return view('join.tos', compact('team_data'));
    }


    public function Jointeam(Request $request){
        $team_member = new TeamMember();
        $team_lead = new Team();
        $array_member = [
            'team_id' =>  $team_lead->where('team_code', $request->team_id)->first()->id,
            'discord_uid' => Auth::user()->discord_id,
            'is_leader' => '0',
            'status' => 'pending',
            'team_code' => $request->team_id,
        ];
        //dd($array_member);
        $team_member->createTeamMember($array_member);
        return redirect()->route('selecthub')->with('success', 'Tham gia nhóm thành công');
    }
}

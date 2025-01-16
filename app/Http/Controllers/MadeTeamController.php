<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MadeTeamController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function login()
    {
        return view('login');
    }
    public function newTeam()
    {
        return view('register.newteam');
    }
    public function create(Request $request){
        $request->validate([
            'team_name' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:10',
            'DoB' => 'required|date',
        ], [
            'team_name.required' => 'Vui lòng nhập tên nhóm',
            'team_name.string' => 'Tên nhóm phải là chuỗi',
            'team_name.max' => 'Tên nhóm không được vượt quá 255 ký tự',
            'fullname.required' => 'Vui lòng nhập họ và tên',
            'fullname.string' => 'Họ và tên phải là chuỗi',
            'fullname.max' => 'Họ và tên không được vượt quá 255 ký tự',
            'phonenumber.required' => 'Vui lòng nhập số điện thoại',
            'phonenumber.string' => 'Số điện thoại phải là chuỗi',
            'phonenumber.max' => 'Số điện thoại không được vượt quá 10 ký tự',
            'DoB.required' => 'Vui lòng nhập ngày sinh',
            'DoB.date' => 'Ngày sinh phải là ngày',
        ]);

        $team_lead = new Team();
        $if_exist = $team_lead->checkHasCreatedTeam($request->UID);
        if($if_exist){
            return redirect()->back()->with('error', 'Bạn đã tạo nhóm rồi');
        }
        $teamMember = new TeamMember();
        $if_joined = $teamMember->checkJoinedTeam($request->UID);

        if($if_joined){
            return redirect()->back()->with('error', 'Bạn đã tham gia nhóm rồi');
        }

        if(!filled($request->formRadios)){
            return redirect()->back()->with('error', 'Vui lòng chấp nhận điều khoản và điều kiện');
        }
        //16 tuổi mới được làm team leader
        $date = date('Y-m-d', strtotime($request->DoB));
        $diff = date_diff(date_create($date), date_create('today'))->y;
        if($diff < 16){
            return redirect()->back()->with('error', 'Bạn chưa đủ tuổi để làm team leader, yêu cầu 16 tuổi trở lên');
        }
        $crc_code = crc32($request->team_name);
        $count = $team_lead->checkVaildTeamCode($crc_code);
        if($count == 0){
            $array = [
                'team_name' => $request->team_name,
                'team_leader_name' => $request->fullname,
                'team_leader_email' => $request->email,
                'team_leader_phone' => $request->phonenumber,
                'team_leader_discord_uid' => $request->UID,
                'tos_agreement' => 'true',
                'team_status' => 'pending',
                'team_code' => $crc_code
            ];
            $team_lead->createTeam($array);
            $team_member = new TeamMember();

            $array_member = [
                'team_id' => $team_lead->where('team_code', $crc_code)->first()->id,
                'discord_uid' => $request->UID,
                'is_leader' => '1',
                'status' => 'appected',
                'team_code' => $crc_code
            ];
            $team_member->createTeamMember($array_member);
            return redirect()->route('reg.success', ['id' => $crc_code]);
        } else {
           return redirect()->back()->with('error', 'Tên nhóm đã tồn tại');
        }

    }
    public function success($id)
    {
        $team = new Team();
        $team_data = $team->getTeamByCode($id);
        if(!$team_data){
            return redirect()->route('reg.new_team');
        }
        return view('register.sharecode', ['team' => $team_data]);
    }
}

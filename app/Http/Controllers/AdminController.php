<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Donate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\TeamCalendar;
use App\Models\TeamMember;
use App\Models\TeamStrike;
class AdminController extends Controller
{
    public function index()
    {
        $team = new Team();
        $team_data = $team->listFullTeams();
        $donate = new Donate();
        $user = new User();
        $donate_data = $donate->ListAllDoantion();
        $sum_donate = $donate->ListAllDonateSum();
        $toal_team = $team->count();
        $total_user = $user->count();
        $calendar = new TeamCalendar();
        $calendar_data = $calendar->ListALLCalendar();
        return view('admin.dash', compact('team_data', 'donate_data', 'sum_donate', 'toal_team', 'total_user', 'calendar_data'));
    }

    public function AddDonate(Request $request)
    {
        $donate = new Donate();
        $donate->addDonate($request->trx_name, $request->amount);
        return redirect()->back()->with('success', 'Đã thêm thành công');
    }
    public function DeleteDonate(Request $request)
    {
        $donate = new Donate();
        $donate->deleteDonate($request->id);
        return redirect()->back()->with('success', 'Đã xóa thành công');
    }

    public function teamDetail($team_id)
    {
        $team_members = new TeamMember();

        $team_members = $team_members->getTeamMembers($team_id);

        $team = new Team();
        $team_info = $team->getTeamByCode($team_id);

        $teamStrike =  new TeamStrike();
        $team_strikes = $teamStrike->listStrikeByTeam($team_info->id);

        $teamCalendar = new TeamCalendar();
        $team_calendar = $teamCalendar->listCalendarByTeam($team_id);


        return view('admin.teamdetail', compact('team_members','team_info','team_strikes','team_calendar'));


    }

    public function updateTeam(Request $request)
    {
        if($request->team_id == null){
            return redirect()->route('leader.dashboard')->with('error', 'Không tìm thấy nhóm');
        }
        if($request->team_name == null){
            return redirect()->route('leader.dashboard')->with('error', 'Vui lòng nhập tên nhóm');
        }
        if($request->public == "on"){
           $visibility = 1;
        } else {
            $visibility = 0;
        }
        $array = [
            'team_name' => $request->team_name,
            'visibility' => $visibility,
            'team_status' => $request->team_status,
            'team_desc' => $request->team_desc
        ];
        $team = new Team();
        $team->updateTeam($request->team_id, $array);
        return back()->with('success', 'Đã cập nhật nhóm');
    }

    public function randomTeamCalendar()
{
    // Lấy danh sách đội
    $team_members = new Team();
    $team_member = $team_members->listTeams();

    // Lọc các đội đủ người (team_status = "full")
    $pass_team = [];
    foreach($team_member as $team){
        if($team->team_status == "full"){
            array_push($pass_team, $team->team_code);
        }
    }
    shuffle($pass_team);
    // Kiểm tra số lượng đội sau khi lọc
    $team_count = count($pass_team);

    // Nếu số đội lẻ, thêm một đội giả định vào để tạo thành cặp đối đầu
    $team_thua = null;
    if ($team_count % 2 != 0) {
        $team_thua = 'Không có đội !';  // Tạo một đội giả định hoặc đội thừa
        array_push($pass_team, $team_thua);  // Thêm đội giả định vào danh sách
        $team_count++;  // Cập nhật lại số lượng đội
    }

    // Tạo lịch thi đấu: chia đội thành các cặp đối đầu
    $matches = [];
    for ($i = 0; $i < $team_count; $i += 2) {
        // Tạo các cặp đối đầu
        $team1 = $pass_team[$i];
        $team2 = $pass_team[$i + 1];
        //lấy thông tin đội
        $team1 = $team_members->getTeamByCode($team1);
        $team2 = $team_members->getTeamByCode($team2);
        $matches[] = [$team1, $team2];
    }

   return view('admin.randomteam', compact('matches'));
}

public function addCalendar(Request $request)
{
    if($request->team_id_self == $request->team_id_opponent){
        return back()->with('error', 'Không thể tự thi đấu');
    }
    if($request->team_fight_date == null){
        return back()->with('error', 'Vui lòng chọn ngày thi đấu');
    }
    if($request->team_fight_date < now()){
        return back()->with('error', 'Không thể chọn ngày đã qua');
    }
    $Calendar = new TeamCalendar();
    $calendar_info = [
        'team_id_self' => $request->team_id_self,
        'team_id_opponent' => $request->team_id_opponent,
        'team_fight_date' => $request->team_fight_date,
        'team_fight_status' => 'scheduled',
        'team_id_winner' => 0,
        'team_id_loser' => 0,
        'team_fight_note' => 'Đã Xếp lịch Vui lòng đến đúng giờ thi đấu'
    ];
    $Calendar->addCalendar($calendar_info);
    return redirect()->route('admin.dash')->with('success', 'Đã thêm lịch thi đấu');


}

public function addUser(Request $request)
{
        $team_code = $request->team_code;
        $team = new Team();
        $team_member = new TeamMember();
        $is_valid = $team->checkVaildTeamCode($team_code);

        if ($is_valid == 0) {
            return back()->with('error', 'Mã nhóm không hợp lệ');
        }
        $team_count = $team_member->countTeamMembers($team_code);
        //dd($team_count);
        if ($team_count >= 5) {
            return back()->with('error', 'Nhóm đã đủ thành viên');
        }
        $arlredy_joined_team = $team_member->checkAlreadyMember( $team_code, Auth::user()->discord_id);
        if ($arlredy_joined_team == 1) {
            return back()->with('error', 'Bạn đã tham gia nhóm này');
        }
        $arlredy_joined = $team_member->checkJoinedTeam($request->discord_uid);
        if ($arlredy_joined == 1) {
            return back()->with('error', 'Bạn đã tham gia nhóm khác');
        }
        $team_member = new TeamMember();
        $team_lead = new Team();

        $array_member = [
            'team_id' =>  $team_lead->where('team_code', $request->team_code)->first()->id,
            'discord_uid' => $request->discord_uid,
            'is_leader' => '0',
            'status' => 'accepted',
            'team_code' => $request->team_code,
        ];
        $team_member->createTeamMember($array_member);
        return back()->with('success', 'Đã thêm thành viên');
}
public function findUser(Request $request)
{
    $user = new User();
    $user_data = $user->getUserByDiscordId($request->search);
    if($user_data == null){
        return response()->json(['error' => 'No user']);
    }
    return response()->json($user_data);
}
public function findGroup(Request $request)
{
    $user = new User();
    $user_data = $user->getUserV2($request->search);
    if($user_data == null){
        return response()->json(['error' => 'No user']);
    }
    return response()->json($user_data);
}

public function editCalendar($id)
{
    $calendar = new TeamCalendar();
    $calendar_data = $calendar->getCalendarById($id);
    $Team = new Team();
    $opponent = $Team->getTeamByCode($calendar_data->team_id_opponent);
    $self = $Team->getTeamByCode($calendar_data->team_id_self);
    $strikes = new TeamStrike();

    $strike_data_self = $strikes->listStrikeByTeam($self->id);
    $strike_data_opponent = $strikes->listStrikeByTeam( $opponent->id);
    return view('admin.calendar', compact('calendar_data', 'opponent', 'self', 'strike_data_self', 'strike_data_opponent'));

}

public function addStrike(Request $request){
    $team = Team::where('team_code', $request->team_id)->first();

    if (!$team) {
        return back()->with('error', 'Team ID không tồn tại.');
    }
    $strike = new TeamStrike();
    $strike->addStrike($team->id, $request->strike_reason, $request->strike_note);

    return back()->with('success', 'Đã thêm thành công');
}

public function deleteCalendar($id)
{
    $calendar = new TeamCalendar();
    $calendar->deleteCalendar($id);
    return redirect()->route('admin.dash')->with('success', 'Đã xóa thành công');
}

public function updateCalendar(Request $request)
{
    $calendar = new TeamCalendar();
    if($request->team_fight_date == null){
        return back()->with('error', 'Vui lòng chọn ngày thi đấu');
    }
    if($request->team_fight_date < now()){
        return back()->with('error', 'Không thể chọn ngày đã qua');
    }
    if($request->team_id == 0){
        $array = [
            'team_fight_date' => $request->team_fight_date,
            'team_fight_status' => $request->team_fight_status,
            'team_id_winner' => '0',
            'team_id_loser' =>'0',
            'team_fight_note' => $request->team_fight_note
        ];
    } else {
        $array = [
            'team_fight_date' => $request->team_fight_date,
            'team_fight_status' => $request->team_fight_status,
            'team_id_winner' => $request->team_id,
            'team_id_loser' =>'0',
            'team_fight_note' => $request->team_fight_note
        ];
    }
    $calendar->editCalendar($array, $request->calendar_id);
    return back()->with('success', 'Đã cập nhật lịch thi đấu');
}

public function deleteStrike($id)
{
    $strike = new TeamStrike();
    $strike->removeStrike($id);
    return redirect()->route('admin.dash')->with('success', 'Đã xóa thành công');

}

public function manualCalendar (Request $request)
{
    $team = new Team();
    if($request->team1 == $request->team2){
        return back()->with('error', 'Không thể tự thi đấu');
    }
    if($request->team_fight_date == null){
        return back()->with('error', 'Vui lòng chọn ngày thi đấu');
    }
    if($request->team_fight_date < now()){
        return back()->with('error', 'Không thể chọn ngày đã qua');
    }
    if($request->team_fight_note == null){
       $team_fight_note = 'Đã Xếp lịch Vui lòng đến đúng giờ thi đấu';
    } else {
        $team_fight_note = $request->team_fight_note;
    }
    $calendar = new TeamCalendar();
    $calendar_info = [
        'team_id_self' => $request->team1,
        'team_id_opponent' => $request->team2,
        'team_fight_date' => $request->team_fight_date,
        'team_fight_status' => $request->team_fight_status,
        'team_id_winner' => 0,
        'team_id_loser' => 0,
        'team_fight_note' => $team_fight_note
    ];

    $calendar->addCalendar($calendar_info);
    return redirect()->route('admin.dash')->with('success', 'Đã thêm lịch thi đấu');
}

public function MatchReport($id)
{
    $calendar = new TeamCalendar();
    $calendar_data = $calendar->getCalendarById($id);
    $Team = new Team();
    $opponent = $Team->getTeamByCode($calendar_data->team_id_opponent);
    $self = $Team->getTeamByCode($calendar_data->team_id_self);
    $team_member = new TeamMember();
    $opponent_member = $team_member->getTeamMembers($calendar_data->team_id_opponent);
    $self_member = $team_member->getTeamMembers($calendar_data->team_id_self);
    $strikes = new TeamStrike();
    $strike_data_self = $strikes->listStrikeByTeam($self->id);
    $strike_data_opponent = $strikes->listStrikeByTeam( $opponent->id);

   return view('admin.matchreport', compact('calendar_data', 'opponent', 'self', 'opponent_member', 'self_member', 'strike_data_self', 'strike_data_opponent'));
    // return view('admin.matchreport');

}
}

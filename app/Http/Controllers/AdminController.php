<?php

namespace App\Http\Controllers;

use App\Models\TFTCalender;
use App\Models\TftData;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Donate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\TeamCalendar;
use App\Models\TeamMember;
use App\Models\TeamStrike;
use App\Models\Tft;
use App\Models\TFTCalenderDetails;
use App\Models\RiotAPI;


class AdminController extends Controller
{
        private $tftplayer;
    private $tftcalender;
    private $tftcalenderdetails;
    private $tftdata;
    private $session;
    private $matchHistory;
    public function __construct()
    {
        $this->tftplayer = new Tft();
        $this->tftcalender = new TFTCalender();
          $this->tftdata = new \App\Models\TFThistory();
        $this->tftcalenderdetails = new TFTCalenderDetails();
        $this->matchHistory = new TftData();
    }
    public function index()
    {
        $donate = new Donate();
        $user = new User();
        $tft = new Tft();
        $tftCalendar = new TFTCalender();
        $donate_data = $donate->ListAllDoantion();
        $sum_donate = $donate->ListAllDonateSum();
        $total_user = $user->count();
        $list_user_registered = $tft->listRegistrations();
        $tft_calendar = $tftCalendar->listEvents();
        $toalpoint_all_player = $this->tftdata->getTotalPointsByAllPlayers();
        $toaltfteam = Tft::count();
        $data = [
            'donate_data' => $donate_data,
            'sum_donate' => $sum_donate,
            'total_user' => $total_user,
            'list_user_registered' => $list_user_registered,
            'tft_calendar' => $tft_calendar,
            'toal_registered' => $toaltfteam,
            'toalpoint_all_player' => $toalpoint_all_player,
        ];
        return view('admin.dash', $data);
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

public function storeTftCalendar(Request $request)
{
    $tftCalendar = new TFTCalender();
    $tftCalendardetails = new TFTCalenderDetails();

    if($request->event_date == null){
        return back()->with('error', 'Vui lòng chọn ngày thi đấu');
    }
    if($request->event_date < now()){
        return back()->with('error', 'Không thể chọn ngày đã qua');
    }

    // Check if players are selected
    if(!$request->has('selected_players') || empty($request->selected_players)){
        return back()->with('error', 'Vui lòng chọn ít nhất một người chơi');
    }

    //1. add Event info
    $event_info = [
        'event_name' => $request->event_name,
        'event_date' => $request->event_date,
        'event_description' => $request->event_description,
        'event_location' => $request->event_location
    ];
    $tftCalendar->createEvent($event_info);

    //2. Get the last inserted event id
    $last_event = $tftCalendar->getLastEventID();
    $last_event_id = $last_event->calendar_id;

    //3. add member details
    foreach($request->selected_players as $player){
        $details_info = [
            'calendar_id' => $last_event_id,
            'discord_id' => $player,
            'is_confirmed' => 0 // Default is not confirmed
        ];
           $tftCalendardetails->createCalenderDetails($details_info);
    }

    return redirect()->route('admin.addTftCalendar')->with('success', 'Đã tạo lịch thi đấu thành công với ' . count($request->selected_players) . ' người chơi');
}

public function addTftCalendar()
{
    $tftRegister = new Tft();
    $registerData = $tftRegister->listRegistrations();
    $tftCalendar = new TFTCalender();
    $tft_calendar = $tftCalendar->listEvents();

    return view('admin.tft.addcalendar', compact('tft_calendar', 'registerData'));
}

public function deleteTftCalendar($id)
{
    $tftCalendar = new TFTCalender();
    $tftCalendar->deleteEvent($id);
    return redirect()->route('admin.addTftCalendar')->with('success', 'Đã xóa lịch thi đấu thành công');
}

public function liveTftCalendar($id)
{
    $tftCalendar = new TFTCalender();
    $tftCalendardetails = new TFTCalenderDetails();
    $calendar_data = $tftCalendar->getCalendaterDetails($id);
    $member_details = $tftCalendardetails->getMember($id);
    return view('admin.tft.livematch', compact('calendar_data', 'member_details'));

}


public function updateTftCalendar(Request $request)
{

   $match_id = $request->match_code;
   $player_rank = $request->player_rank;
   $player_score = $request->player_score;
   $player_result = $request->player_result;
   $action = $request->action;
   $event_id = $request->event_id;
   $tft_division = $request->event_description;
   $selected_players = $request->selected_players;
   $player_puuid = $request->player_ids;
    $tftCalendar = new TFTCalender();
    $calendar_data = $tftCalendar->getCalendaterDetails( $event_id);
    if($calendar_data->first()->is_cancelled == 1) {
        return redirect()->route('admin.dash')->with('error', 'Lịch thi đấu đã bị hủy hoặc đã hoàn thành khoảng thời gian này không thể cập nhật dữ liệu.');
    }
   //1. tft_data collection
   //1.1 create tft_data array
   $tft_data = [];
   //1.2 foreach get player discord id and add to tft_data with corresponding rank, score, result
   foreach($selected_players as $key => $discord_id){
       $tft_data[] = [
           'discord_id' => $discord_id,
           'puuid' => $player_puuid[$key],
           'calendar_id' => $event_id,
           'tft_rank' => $player_rank[$discord_id],
           'tft_points' => $player_score[$discord_id],
           'tft_result' => $player_result[$discord_id],
           'tft_division' => $tft_division,
           'event_id' => $event_id,
           'match_id' => $match_id,
           'action' => $action
       ];
   }

   //2. Fetch API data
   $riotAPI = new RiotAPI();
   $match_details = $riotAPI->getMatchDetails($match_id);

   //3. Merge API data with existing tft_data
   if($match_details && isset($match_details['info']['participants'])) {
       foreach($tft_data as $key => &$player_data) {
           // Find matching participant in API data by puuid
           foreach($match_details['info']['participants'] as $participant) {
               if($participant['puuid'] === $player_data['puuid']) {
                   // Merge API data into existing player data
                   $tft_data[$key] = array_merge($player_data, [
                       'api_placement' => $participant['placement'],
                       'api_level' => $participant['level'],
                       'api_gold_left' => $participant['gold_left'],
                       'api_last_round' => $participant['last_round'],
                       'api_total_damage' => $participant['total_damage_to_players'],
                       'api_players_eliminated' => $participant['players_eliminated'],
                       'api_game_length' => $match_details['info']['game_length'],
                       'api_game_datetime' => $match_details['info']['game_datetime'],
                       'api_traits' => json_encode($participant['traits']),
                       'api_units' => json_encode($participant['units'])
                   ]);
                   break;
               }
           }
       }
   }

   //4. Save or process the merged data
   $tftData = new TftData();
   foreach($tft_data as $data) {
       $tftData->create($data);
   }
   //5. set calendar status to completed
try {
    $tftCalendar = new TFTCalender();
    $tftCalendar->updateEvent($event_id, ['is_cancelled' => 1]);
} catch (\Exception $e) {
    return back()->with('error', 'Đã xảy ra lỗi khi cập nhật lịch thi đấu: ' . $e->getMessage());


}
  return back()->with('success', 'Đã cập nhật dữ liệu TFT thành công với ' . count($tft_data) . ' người chơi');
}

public function userTftDetail($discord_id)
{
     $playerinfo = $this->tftplayer->getRegisterInfo($discord_id);
    $calender = $this->tftcalenderdetails->getCalenderDetailsByDiscordId($discord_id);
        $tftdata = $this->tftdata->getHistoryByDiscordId($discord_id);
        $toalPoints = $this->tftdata->getToalPointsByDiscordId($discord_id);
        $matchplayerHistory = $this->matchHistory->getHistoryByDiscordId($discord_id);
        return view('admin.tft.usercompare', [
            'playerinfo' => $playerinfo,
            'calender' => $calender,
            'tftdata' => $tftdata,
            'toalPoints' => $toalPoints
            , 'matchplayerHistory' => $matchplayerHistory
        ]);

}
public function compareMatch($discord_id)
{

    $tftData = new TftData();
    $match_data = $tftData->getHistoryByDiscordId($discord_id);
    $calendar = new TFTCalender();
    $calendar_data = $tftData-> getEventDatabyDiscordId($discord_id);
    if(!$match_data){
        return back()->with('error', 'Không tìm thấy dữ liệu trận đấu');
    }
    return view('admin.tft.comparematch', compact('match_data', 'calendar_data', 'discord_id'));
}
}

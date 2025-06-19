<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tft;
use App\Models\RiotAPI;

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
        return view('tft.register');
    }
    public function create(Request $request)
    {

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
        if ($if_exist) {
            return redirect()->back()->with('error', 'Bạn đã tạo nhóm rồi');
        }
        $teamMember = new TeamMember();
        $if_joined = $teamMember->checkJoinedTeam($request->UID);

        if ($if_joined) {
            return redirect()->back()->with('error', 'Bạn đã tham gia nhóm rồi');
        }

        if (!filled($request->formRadios)) {
            return redirect()->back()->with('error', 'Vui lòng chấp nhận điều khoản và điều kiện');
        }
        //16 tuổi mới được làm team leader
        $date = date('Y-m-d', strtotime($request->DoB));
        $diff = date_diff(date_create($date), date_create('today'))->y;
        if ($diff < 16) {
            return redirect()->back()->with('error', 'Bạn chưa đủ tuổi để làm team leader, yêu cầu 16 tuổi trở lên');
        }
        $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
        $data = [
            'secret' => '0x4AAAAAAA51oAjVVMRqq3NWjNfGRL0nt1A',
            'response' => $request->input('cf-turnstile-response'),
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        $response = json_decode($result);
        if ($response->success) {
            $crc_code = crc32($request->team_name);
            $count = $team_lead->checkVaildTeamCode($crc_code);
            if ($request->public == "on") {
                $visibility = 1;
            } else {
                $visibility = 0;
            }
            if ($count == 0) {
                $array = [
                    'team_name' => $request->team_name,
                    'visibility' => $visibility,
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
                    'status' => 'accepted',
                    'team_code' => $crc_code
                ];
                $team_member->createTeamMember($array_member);
                return redirect()->route('reg.success', ['id' => $crc_code]);
            } else {
                return redirect()->back()->with('error', 'Tên nhóm đã tồn tại');
            }
        } else {
            return redirect()->back()->with('error', 'Vui lòng xác minh bạn không phải là robot');
        }
    }

    public function registertft()
    {
        //check if user has registered
        $tft = new Tft();
        $if_exist = $tft->checkRegistration(Auth::user()->discord_id);
        if ($if_exist) {
            return redirect()->route('tft.index')->with('error', 'Bạn đã đăng ký rồi');
        }
        return view('tft.register');
    }

    public function createRegistraion(Request $request)
    {
        $request->validate([
            'riotname' => 'required|string|max:50',
            'riottag' => 'required|string|max:10',
            'riot_nametag' => 'required|string|max:255',
            'jointype' => 'required|in:set14,set10,all',
            'fullname' => 'required|string|max:255',
            'phonenumber' => 'required|string|regex:/^[0-9]{10,11}$/',
            'DoB' => 'required|date|before_or_equal:' . now()->subYears(16)->format('Y-m-d'),
            'CCCD' => 'required|string|regex:/^[0-9]{9,12}$/',
            'issuedate' => 'required|date|before_or_equal:today|after:' . $request->DoB,
            'bank_account_number' => 'required|string|min:6|max:20',
            'bank_account_name' => 'required|string|max:255',
            'bank_name' => 'required|string',
            'formRadios' => 'required|accepted',
        ], [
            'riotname.required' => 'Vui lòng nhập Riot Name',
            'riottag.required' => 'Vui lòng nhập Riot Tag ID',
            'riot_nametag.required' => 'Vui lòng nhập Riot Name và Tag ID',
            'jointype.required' => 'Vui lòng chọn mục đăng ký',
            'jointype.in' => 'Mục đăng ký không hợp lệ',
            'fullname.required' => 'Vui lòng nhập họ và tên',
            'fullname.max' => 'Họ và tên không được vượt quá 255 ký tự',
            'phonenumber.required' => 'Vui lòng nhập số điện thoại',
            'phonenumber.regex' => 'Số điện thoại phải có 10-11 chữ số',
            'DoB.required' => 'Vui lòng chọn ngày sinh',
            'DoB.before_or_equal' => 'Bạn phải đủ 16 tuổi để tham gia',
            'CCCD.required' => 'Vui lòng nhập số CCCD',
            'CCCD.regex' => 'Số CCCD phải có 9-12 chữ số',
            'issuedate.required' => 'Vui lòng chọn ngày cấp CCCD',
            'issuedate.before_or_equal' => 'Ngày cấp không được sau ngày hôm nay',
            'issuedate.after' => 'Ngày cấp CCCD phải sau ngày sinh',
            'bank_account_number.required' => 'Vui lòng nhập số tài khoản',
            'bank_account_number.min' => 'Số tài khoản phải có ít nhất 6 ký tự',
            'bank_account_number.max' => 'Số tài khoản không được vượt quá 20 ký tự',
            'bank_account_name.required' => 'Vui lòng nhập tên chủ tài khoản',
            'bank_account_name.max' => 'Tên chủ tài khoản không được vượt quá 255 ký tự',
            'bank_name.required' => 'Vui lòng chọn ngân hàng',
            'formRadios.required' => 'Vui lòng đồng ý với nội quy tham gia',
            'formRadios.accepted' => 'Bạn phải đồng ý với nội quy để có thể đăng ký tham gia',
        ]);

        $post_array = [
            'riotname_id' => $request->riot_nametag,
            'riotname_tag' => $request->riottag,
            'join_type' => $request->jointype,
            'fullname' => $request->fullname,
            'phonenumber' => $request->phonenumber,
            'DoB' => $request->DoB,
            'id_number' => $request->CCCD,
            'id_issue_date' => $request->issuedate,
            'discord_id' => $request->UID,
            'register_date' => now(),
            'bank_account_number' => $request->bank_account_number,
            'bank_account_name' => $request->bank_account_name,
            'bank_name' => $request->bank_name,
            'tos_accepted' => true
        ];
        $tft = new Tft();
        $if_exist = $tft->checkRegistration($request->UID);
        if ($if_exist) {
            return redirect()->back()->with('error', 'Bạn đã đăng ký rồi');
        }
        $if_joined = $tft->findByRiotName($request->riot_nametag);
        if ($if_joined) {
            return redirect()->back()->with('error', 'Bạn đã đăng ký Riot Name tag này rồi');
        }
        $riotAPI = new RiotAPI();
        $puuid = $riotAPI->getPuuid($request->riotname, $request->riottag);
        if ($puuid === null) {
            return redirect()->back()->with('error', 'Riot Name#Tag ID không hợp lệ hoặc không tồn tại')->withInput();
        }
        $post_array['puuid'] = $puuid;
        // dd($post_array);
        try {
            $new_registration = $tft->registerTft($post_array);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        if ($new_registration) {
            return redirect()->route('reg.select')->with('success', 'Đăng ký thành công');
        } else {
            return redirect()->back()->with('error', 'Đăng ký thất bại, vui lòng thử lại sau');
        }
        // dd($request->all());
        //     $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
        //     $data = [
        //         'secret' => '0x4AAAAAAA51oAjVVMRqq3NWjNfGRL0nt1A',
        //         'response' => $request->input('cf-turnstile-response'),
        //     ];

        //     $options = [
        //         'http' => [
        //             'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        //             'method'  => 'POST',
        //             'content' => http_build_query($data),
        //         ],
        //     ];

        //     $context  = stream_context_create($options);
        //    $result = file_get_contents($url, false, $context);

        //    $response = json_decode($result);

    }
    public function success($id)
    {
        $team = new Team();
        $team_data = $team->getTeamByCode($id);
        if (!$team_data) {
            return redirect()->route('reg.new_team');
        }
        return view('register.sharecode', ['team' => $team_data]);
    }
    public function rules()
    {
        return view('rule');
    }
}

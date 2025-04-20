<?php

namespace App\Http\Controllers;

use App\Models\DisordAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Session;

class DiscordAuthController extends Controller
{
    public function AuthDiscorDetail(Request $request) {
        $token = $request->input('code');
        $auth = new DisordAuth();
        $data = $auth->Authuser($token);
        $checkGuild = $auth->getGuildList();
        // dd($checkGuild);

        if (!is_object($data) || $data->id == null) {
            return redirect()->route('login')->with('error', 'Đăng nhập thất bại');
        }

        $id = $data->id;
        $user = User::where('discord_id', $id)->first();
        $isInGuild = false;

        foreach ($checkGuild as $value) {
            if ($value->id == 911440419257188352) {
                $isInGuild = true;
                break;
            }
        }

        if ($isInGuild) {
            try {
                if ($user) {
                    Auth::login($user);
                    $team = new TeamMember();
                    $isHaveTeam = $team->checkJoinedTeam($id);
                    return redirect()->intended(route('reg.select')); // Nếu không có URL trước đó, mặc định về trang chủ
                } else {
                    return redirect()->route('login')->with('error', 'Người dùng không tồn tại.');
                }
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        } else {
            return redirect()->route('login')->with('error', 'Người ngoài tham gia vào sự kiện, vui lòng tham gia server discord sau đó đăng nhập lại');
        }
    }
}

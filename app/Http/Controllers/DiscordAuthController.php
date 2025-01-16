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
    public function AuthDiscorDetail(Request $request){
        $token = $request->input('code');
        $auth = new DisordAuth();
        $data = $auth->Authuser($token);
        $id = $data->id;
        $user = User::where('discord_id', $id)->first();
        try {
            if ($user) {
                Auth::login($user);
                $team = new TeamMember();
                $isHaveTeam = $team->checkJoinedTeam($id);
               if($isHaveTeam){
                session(['haveTeam' => $isHaveTeam]);
               }
                return redirect()->route('reg.select');
            } else {

            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

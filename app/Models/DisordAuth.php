<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class DisordAuth extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Authuser($token){

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, env('DISCORD_API_ENDPOINT'). '/oauth2/token');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, 'client_id=' . env('DISCORD_CLIENT_ID') . '&client_secret=' . env('DISCORD_CLIENT_SECRET') . '&grant_type=authorization_code&code=' . $token . '&redirect_uri='. env('DISCORD_REDIRECT').'');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $data_out = curl_exec($ch);
            // dd($data_out);
                curl_close($ch);
                $data = json_decode($data_out);
            //    dd($data);
                if(isset($data->access_token)){
                   setcookie('access_token', $data->access_token, time() + 86400, '/');

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, env('DISCORD_API_ENDPOINT'). '/users/@me');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $data->access_token));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $data_out = curl_exec($ch);
                    curl_close($ch);
                    $data = json_decode($data_out);
                    $user = new User();
                 $count =   $user->check_user($data->id);
                  if($count == 0){
                    $array = array(
                        'discord_id' => $data->id,
                        'avatar' => $data->avatar,
                        'name' => $data->username,
                        'discord_username' => $data->global_name,
                        'email' => $data->email,
                        'password' => bcrypt($data->id),
                    );
                    $user->create_user($array);
                    return $data;
                    } else{
                        $array = array(
                            'discord_id' => $data->id,
                            'avatar' => $data->avatar,
                            'name' => $data->username,
                            'discord_username' => $data->global_name,
                            'email' => $data->email,
                            'password' => bcrypt($data->id),
                        );
                        $user->update_user($array, $data->id);
                        return $data;
                    }
                } else {
                    return "Token not found";
                }

    }
    public function getGuildList(){
       if(isset($_COOKIE['access_token'])){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, env('DISCORD_API_ENDPOINT'). '/users/@me/guilds');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_COOKIE['access_token']));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data_out = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($data_out);
            return $data;
        } else {
            return "Token not found";
        }
    }
    // public function joinGuildList($guild_id){
    //     if(isset($_COOKIE['access_token'])){
    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, env('DISCORD_API_ENDPOINT'). '/guilds/'.$guild_id.'/members/'.env('DISCORD_CLIENT_ID'));
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bot ' . env('DISCORD_BOT_TOKEN')));
    //         curl_setopt($ch, CURLOPT_POST, 1);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, 'access_token=' . $_COOKIE['access_token']);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         $data_out = curl_exec($ch);
    //         curl_close($ch);
    //         $data = json_decode($data_out);
    //         return $data;
    //     } else {
    //         return "Token not found";
    //     }
    // }
}

<?php

namespace App\Http\Controllers;

use App\Models\TeamChoices;
use App\Models\VoteTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
class TeamchoiesController extends Controller
{


    public function index(){
        $vote = new TeamChoices();
        $check_voted = $vote->checkVote(Auth::user()->discord_id);
        $vote_option = new VoteTime();
        $vote_data = $vote_option->getdate();
        if($vote_data->end_date > date('Y-m-d H:i:s') && $vote_data->start_date < date('Y-m-d H:i:s')){
            return redirect()->route('selecthub')->with("error","Chưa đến thời gian dự đoán");
        }
        if($vote_data->end_date < date('Y-m-d H:i:s')){
            return redirect()->route('selecthub')->with("error","Đã hết thời gian dự đoán");
        }
        if($check_voted){
             return redirect()->route('selecthub')->with("success","Dự đoán của bạn đã được ghi nhận");
        }
        return view('vote');
    }

    public function vote(Request $request){
        $team_pepapig = $request->team2;
        $team_vuon_hoa = $request->team1;
        $vote = new TeamChoices();
        $check_voted = $vote->checkVote(Auth::user()->discord_id);
        if($check_voted){
            dd($check_voted);
        }
        if(empty($team_vuon_hoa)) {
            return redirect()->back()->with('error','Vui lòng nhập tỉ số dự đoán');
        }
        if(empty($team_pepapig)) {
            return redirect()->back()->with('error','Vui lòng nhập tỉ số dự đoán');
        }

        if($team_pepapig > 4 || $team_vuon_hoa > 4 ) {
            return redirect()->back()->with('error','Tỉ số dự đoán tối đa là 3');
        }
        if(!is_numeric( $team_pepapig )) {
            return redirect()->back()->with('error','Tỉ số dự đoán phải là số');
        }
        if(!is_numeric( $team_vuon_hoa )) {
            return redirect()->back()->with('error','Tỉ số dự đoán phải là số');
        }
        try{
            $upVote = $vote->addVote(Auth::user()->discord_id,$team_pepapig,$team_vuon_hoa);
            if($upVote){
                return redirect()->back()->with('success','Dự đoán thành công');
            }
        } catch(Exception $e){
            return redirect()->back()->with('error','Có lỗi xảy ra');
        }



    }

    public function listVote(){
        $Vote = new TeamChoices();
        $listVote = $Vote->listVote();
        $vote_option = new VoteTime();
        $vote_data = $vote_option->getdate();
        return view('admin.vote.list')->with(['listVote' => $listVote, 'vote_data' => $vote_data]);
    }

    public function updadateVote(Request $request){

        $vote_option = new VoteTime();
        $vote_data = $vote_option->getdate();
        $start_date = $request->time_start_vote;
        $end_date = $request->time_end_vote;
        $id = $request->id;

        if($start_date > $end_date){
            return redirect()->back()->with('error','Thời gian kết thúc phải lớn hơn thời gian bắt đầu');
        }
        if($start_date < date('Y-m-d H:i:s')){
            return redirect()->back()->with('error','Thời gian bắt đầu phải lớn hơn thời gian hiện tại');
        }


        if($vote_data){
            try{
                $vote_update = $vote_option->updatedate($start_date, $end_date,$id);
                return redirect()->back()->with('success','Cập nhật thành công');
            } catch (Exception $e) {
                return redirect()->back()->with('error',$e->getMessage());
            }

        } else {
            try{
                $vote_update = $vote_option->adddate($start_date, $end_date);
                return redirect()->back()->with('success','Cập nhật thành công');
            } catch (Exception $e) {
                return redirect()->back()->with('error',$e->getMessage());
            }
        }





    }

}

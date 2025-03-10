<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteTime extends Model
{
    protected $table = "vote_option";

    protected $fillable = ["start_date", "end_date"];

    public $timestamps = false;



    public function updatedate($start_date, $end_date,$id){
        // $start_date = strtotime($start_date);
        // $end_date = strtotime($end_date);
        return $this->where('id', $id)->update([
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }
    public function adddate($start_date, $end_date){
        // $start_date = strtotime($start_date);
        // $end_date = strtotime($end_date);
        return $this->create([
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }

    public function getdate(){
        return $this->orderBy('id', 'desc')->first();
    }
}

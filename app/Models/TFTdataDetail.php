<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TFTdataDetail extends Model
{
    protected $table = 'tft_data_details';
    protected $primaryKey = 'tft_data_details_id';
    public $timestamps = true;

    protected $fillable = [
        'data_id',
        'placement',
        'round',
        'traits',
        'units',
        'items',
        'gold_left',
        'level',
        'time_survived',
        'match_id',
    ];

    public function tftData()
    {
        return $this->belongsTo(TftData::class, 'data_id', 'data_id');
    }
}

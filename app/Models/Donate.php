<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donate extends Model
{
    protected $table = 'donate';
    protected $fillable = ['trx_name', 'amount'];


    public function ListAllDoantion()
    {
        return $this->all();
    }

    public function ListAllDonatePaginate()
    {
        return $this->paginate(10);
    }

    public Function ListAllDonateSum()
    {
        return $this->sum('amount');
    }

    public function AddDonate($trx_name, $amount)
    {
        return $this->create([
            'trx_name' => $trx_name,
            'amount' => $amount
        ]);
    }

    public function deleteDonate($id)
    {
        return $this->where('id', $id)->delete();
    }
    public function UpdateDonate($id, $trx_name, $amount)
    {
        return $this->where('id', $id)->update([
            'trx_name' => $trx_name,
            'amount' => $amount
        ]);
    }
}

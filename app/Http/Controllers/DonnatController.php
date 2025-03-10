<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donate;

class DonnatController extends Controller
{
    public function index()
    {
        $donate = new Donate();
        $donate_data = $donate->ListAllDoantion();
        $sum_donate = $donate->ListAllDonateSum();
        return view('qrcode', compact('donate_data', 'sum_donate'));
    }
}

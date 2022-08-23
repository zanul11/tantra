<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->put('parent', 'Dashboard');
        $request->session()->put('child', 'Dash');
        $sumber = 1;
        $sumur = 1;
        $sungai = 1;


        return view('pages.dashboard.index', compact('sumber', 'sumur',  'sungai'));
    }
}

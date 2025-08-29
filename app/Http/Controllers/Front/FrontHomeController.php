<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class FrontHomeController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sequence_number', 'asc')->get();
        return view('front.home', compact('banners'));
    }
}

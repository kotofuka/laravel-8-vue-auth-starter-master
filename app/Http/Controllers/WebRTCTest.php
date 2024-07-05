<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebRTCTest extends Controller
{
    public function index(){
        return view("video-broadcast", ['type' => 'broadcaster', 'id' => Auth::id()]);
    }
}

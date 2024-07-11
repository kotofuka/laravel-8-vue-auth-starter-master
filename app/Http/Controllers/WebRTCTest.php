<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WebRTCTest extends Controller
{
    public function index(){
        Log::info('test start');
        return view("test-page");
    }
}

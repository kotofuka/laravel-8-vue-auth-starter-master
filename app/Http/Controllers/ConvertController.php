<?php

namespace App\Http\Controllers;

use FFMpeg\FFMpeg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConvertController extends Controller
{
    public function convertWebmToWav(){
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'  => 'C:\FFmpeg\ffmpeg.exe',
            'ffprobe.binaries' => 'C:\FFmpeg\ffprobe.exe'
        ]);
        Log::info("convert");
        var_dump($_GET);
        $data = $_GET;
        Log::info(($_GET));
        //return;
    }
}

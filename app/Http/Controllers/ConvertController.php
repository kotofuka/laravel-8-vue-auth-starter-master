<?php

namespace App\Http\Controllers;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Wav;
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
        Log::info(request()->all());
        Log::info($_FILES);
        $file = $_FILES["voice"];
        $blob = file_get_contents($file['tmp_name']);
        file_put_contents('audio_file.webm', $blob);

        $audio = $ffmpeg->open('audio_file.webm');
        $audio->save(new Wav(), 'export-wav.wav');
        Log::info($audio->getPathfile());
        //return;
    }
}

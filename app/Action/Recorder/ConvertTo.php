<?php

namespace App\Action\Recorder;

use FFMpeg\FFMpeg;
use Illuminate\Support\Facades\Log;

class ConvertTo {
    public function convertWebmToWav($data){
        $ffmpeg = FFMpeg::create();
        Log::info("convert");
    }
}